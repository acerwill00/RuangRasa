<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MidtransService;
use App\Models\Order;
use App\Models\Appointment;
use App\Models\Psychologist;
use App\Models\User;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Create a payment token and an Order record.
     * Appointment is NOT created here — only after payment succeeds.
     * All booking context is read from session (set by BookingController).
     */
    public function createPaymentToken(Request $request)
    {
        $user = auth()->user();

        // Read booking data from session
        $psychologistId = session('booking.psychologist_id');
        $date           = session('booking.date');
        $time           = session('booking.time');
        $serviceType    = session('booking.service_type');
        $servicePrice   = session('booking.service_price');

        // Validate we actually have a complete booking in session
        if (!$psychologistId || !$date || !$time || !$serviceType) {
            return response()->json(['error' => 'Incomplete booking data. Please restart the booking flow.'], 422);
        }

        $psychologist = Psychologist::findOrFail($psychologistId);

        // Platform fee
        $platformFee = 5000;
        $totalAmount = $servicePrice + $platformFee;

        // Create Order (with booking meta embedded so webhook can reconstruct appointment)
        $order = Order::create([
            'id'              => 'ORDER-' . strtoupper(Str::random(10)),
            'user_id'         => $user->id,
            'psychologist_id' => $psychologist->id,
            'schedule_date'   => $date,
            'schedule_time'   => $time,
            'service_type'    => $serviceType,
            'amount'          => $totalAmount,
            'status'          => 'pending',
        ]);

        // Get Snap Token from Midtrans
        $snapToken = $this->midtransService->getSnapToken($order);

        // Persist token on the order
        $order->update(['snap_token' => $snapToken]);

        return response()->json(['snap_token' => $snapToken, 'order_id' => $order->id]);
    }

    /**
     * Simulate payment success (sandbox/testing flow).
     * This is where the Appointment record gets created.
     */
    public function simulateSuccess(Request $request)
    {
        $order = Order::find($request->order_id);

        if ($order && $order->status === 'pending') {
            $order->update(['status' => 'success']);

            $this->createAppointmentFromOrder($order);

            // Clear booking session
            $this->clearBookingSession();
        }

        return response()->json(['success' => true]);
    }

    /**
     * Midtrans server-side webhook handler.
     */
    public function webhook(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'invalid signature'], 403);
        }

        $order = Order::find($request->order_id);

        if (!$order) {
            return response()->json(['message' => 'order not found'], 404);
        }

        if (in_array($request->transaction_status, ['capture', 'settlement'])) {
            if ($order->status !== 'success') {
                $order->update(['status' => 'success']);
                $this->createAppointmentFromOrder($order);
            }
        } elseif (in_array($request->transaction_status, ['cancel', 'deny', 'expire'])) {
            $order->update(['status' => 'failed']);
            Appointment::where('order_id', $order->id)->update(['status' => 'canceled']);
        } elseif ($request->transaction_status === 'pending') {
            $order->update(['status' => 'pending']);
        }

        return response()->json(['message' => 'ok']);
    }

    // ─── Private helpers ──────────────────────────────────────────────────────

    /**
     * Create the Appointment from Order's embedded booking meta.
     * Called only after payment is confirmed.
     */
    private function createAppointmentFromOrder(Order $order): void
    {
        // Avoid duplicate appointments for the same order
        if (Appointment::where('order_id', $order->id)->exists()) {
            return;
        }

        $appointment = Appointment::create([
            'order_id'        => $order->id,
            'user_id'         => $order->user_id,
            'psychologist_id' => $order->psychologist_id,
            'schedule_date'   => $order->schedule_date,
            'schedule_time'   => $order->schedule_time,
            'service_type'    => $order->service_type,
            'status'          => 'scheduled',
        ]);

        // Load relationships needed for the email
        $appointment->load(['user', 'psychologist']);

        // Send confirmation email
        \Illuminate\Support\Facades\Mail::to($appointment->user->email)
            ->send(new \App\Mail\BookingConfirmationMail($appointment));
    }

    private function clearBookingSession(): void
    {
        session()->forget([
            'booking.psychologist_id',
            'booking.service_type',
            'booking.service_price',
            'booking.date',
            'booking.time',
        ]);
    }
}
