@extends('layouts.app')

@section('title', 'Confirm & Pay — Ruang Rasa')

@section('content')
<div class="bg-secondary/10 py-10 min-h-[calc(100vh-80px)]">
    <div class="max-w-6xl mx-auto px-6">

        {{-- ── Progress Bar ──────────────────────────────────────────────── --}}
        <div class="mb-12 mt-4 px-4 md:px-10">
            <div class="flex items-center justify-between relative">
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1.5 bg-white rounded-full -z-10 shadow-sm border border-secondary/50"></div>
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1.5 bg-cta rounded-full -z-10"></div>

                @foreach([
                    ['label' => '1. Psych',   'href' => '/our-psychologist'],
                    ['label' => '2. Service', 'href' => '/book/' . $booking['psychologist']->id],
                    ['label' => '3. Schedule','href' => '/book/' . $booking['psychologist']->id . '/schedule'],
                ] as $step)
                    <a href="{{ $step['href'] }}" class="flex flex-col items-center gap-2 bg-secondary/10 hover:bg-secondary/20 transition-colors py-1 px-1 md:px-2 rounded-lg group">
                        <div class="w-8 h-8 rounded-full bg-cta text-white flex items-center justify-center font-bold text-sm shadow-md ring-4 ring-white group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-xs font-semibold text-text-main hidden md:block opacity-80 group-hover:opacity-100">{{ $step['label'] }}</span>
                    </a>
                @endforeach

                {{-- Step 4 — Active --}}
                <div class="flex flex-col items-center gap-2 cursor-default">
                    <div class="w-10 h-10 rounded-full bg-primary text-text-main ring-4 ring-white flex items-center justify-center font-bold text-lg shadow-soft">4</div>
                    <span class="text-xs font-bold text-cta bg-white px-2 py-0.5 rounded shadow-sm">4. Payment</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-10">
            {{-- ── Patient Info Form ─────────────────────────────────────── --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-[2rem] shadow-soft border border-secondary/50">
                    <h1 class="text-2xl font-bold mb-6">Patient Details</h1>

                    @php
                        $user      = auth()->user();
                        $nameParts = explode(' ', $user->name ?? '', 2);
                        $firstName = $nameParts[0] ?? '';
                        $lastName  = $nameParts[1] ?? '';
                    @endphp

                    <div class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-text-main mb-2">First Name</label>
                                <input type="text" value="{{ $firstName }}" class="w-full px-5 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:border-cta focus:ring-4 focus:ring-primary/20 transition-all font-medium" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-text-main mb-2">Last Name</label>
                                <input type="text" value="{{ $lastName }}" class="w-full px-5 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:border-cta focus:ring-4 focus:ring-primary/20 transition-all font-medium" readonly>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-text-main mb-2">Email</label>
                            <input type="email" value="{{ $user->email }}" class="w-full px-5 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:border-cta focus:ring-4 focus:ring-primary/20 transition-all font-medium" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-text-main mb-2">Phone Number <span class="font-normal opacity-50">(optional)</span></label>
                            <input type="tel" id="patient_phone" class="w-full px-5 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:border-cta focus:ring-4 focus:ring-primary/20 transition-all font-medium" placeholder="+62 8xx xxxx xxxx">
                            <p class="text-[11px] opacity-60 mt-1.5">For WhatsApp reminders 1 hour before your session.</p>
                        </div>
                    </div>
                </div>

                {{-- Secure Payment Notice --}}
                <div class="bg-white p-8 rounded-[2rem] shadow-soft border border-secondary/50">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-xl font-bold">Secure Payment</h2>
                        <div class="flex items-center gap-2">
                            <div class="h-6 px-2 bg-slate-100 rounded flex items-center justify-center border border-slate-200">
                                <span class="text-[9px] font-black italic text-slate-600">VISA</span>
                            </div>
                            <div class="h-6 px-2 bg-slate-100 rounded flex items-center justify-center border border-slate-200">
                                <span class="text-[9px] font-black text-slate-600">GoPay</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-sm opacity-70">You will be securely redirected to Midtrans to complete your payment via bank transfer, e-wallet, or credit card.</p>
                </div>
            </div>

            {{-- ── Summary Sidebar ──────────────────────────────────────── --}}
            <div class="lg:col-span-1">
                <div class="bg-white p-6 md:p-8 rounded-[2rem] shadow-soft border border-primary/30 sticky top-28 bg-gradient-to-b from-white to-primary/5">
                    <h3 class="font-bold text-lg mb-6 flex items-center justify-between">
                        Booking Summary
                        <button type="button" onclick="copySummary()" class="text-cta hover:text-cta-hover transition-colors p-1 rounded-md hover:bg-primary/20 focus:outline-none focus:ring-2 focus:ring-cta" title="Copy Summary">
                            <svg class="w-5 h-5 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </button>
                    </h3>

                    @php
                        $psychologist = $booking['psychologist'];
                        $photo = asset('img/prof-pic.jpeg');
                        $serviceLabel = $booking['service_type'] === 'psikolog_klinis' ? 'Psikolog Klinis' : 'Konseling';

                        $dateFormatted = \Carbon\Carbon::parse($booking['date'])->format('D, d M Y');
                        $timeFormatted = \Carbon\Carbon::createFromFormat('H:i:s', $booking['time'])->format('h:i A');

                        $platformFee   = 5000;
                        $total         = $booking['service_price'] + $platformFee;
                    @endphp

                    <div class="flex gap-4 mb-6 bg-white p-4 rounded-xl border border-secondary shadow-sm">
                        <img src="{{ $photo }}" alt="{{ $psychologist->name }}" class="w-14 h-14 rounded-lg object-cover flex-shrink-0">
                        <div class="flex flex-col justify-center min-w-0">
                            <p class="font-bold text-sm truncate">{{ $psychologist->name }}</p>
                            <p class="text-xs opacity-70">{{ $serviceLabel }}</p>
                        </div>
                    </div>

                    <div class="space-y-4 mb-6 text-sm divide-y divide-secondary">
                        <div class="flex justify-between items-center py-2">
                            <span class="opacity-70 font-medium">Date & Time</span>
                            <span class="font-bold text-right text-cta">{{ $dateFormatted }}<br>{{ $timeFormatted }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="opacity-70 font-medium">Consultation Fee</span>
                            <span class="font-semibold">Rp {{ number_format($booking['service_price'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="opacity-60 text-xs font-medium">Platform Fee</span>
                            <span class="font-semibold text-xs opacity-60">Rp {{ number_format($platformFee, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t-2 border-dashed border-secondary mb-6">
                        <div class="flex justify-between items-end">
                            <span class="font-semibold opacity-70">Total Due</span>
                            <span class="font-black text-2xl text-text-main">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button id="pay-button" class="w-full py-4 px-4 bg-cta hover:bg-cta-hover text-white rounded-xl font-bold transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 flex items-center justify-center gap-2 text-[15px]">
                        Confirm & Pay
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </button>

                    <p class="text-[11px] text-center opacity-60 mt-4 flex items-center justify-center gap-1">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        SSL secured · Data strictly confidential
                    </p>


                    <div class="mt-3 flex justify-center">
                        <a href="/book/{{ $psychologist->id }}/schedule" class="text-xs font-bold text-slate-400 hover:text-cta transition-colors border-b border-transparent hover:border-cta pb-0.5">
                            ← Edit Schedule
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
function copySummary() {
    const psychologistName = `{!! addslashes($booking['psychologist']->name) !!}`;
    const serviceLabel = `{!! $booking['service_type'] === 'psikolog_klinis' ? 'Psikolog Klinis' : 'Konseling' !!}`;
    const price = `{!! number_format($total, 0, ',', '.') !!}`;
    const dateTime = `{!! \Carbon\Carbon::parse($booking['date'])->format('D, d M Y') !!} · {!! \Carbon\Carbon::createFromFormat('H:i:s', $booking['time'])->format('h:i A') !!}`;
    
    const textToCopy = `Booking Summary\n` +
                       `Psychologist: ${psychologistName}\n` +
                       `Service: ${serviceLabel}\n` +
                       `Duration: 60 Minutes\n` +
                       `Date & Time: ${dateTime}\n` +
                       `Total Amount: Rp ${price}`;
    
    navigator.clipboard.writeText(textToCopy).then(() => {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Copied!',
                text: 'Booking summary copied to clipboard',
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                background: '#fff',
                color: '#00263E',
                iconColor: '#B18FE4'
            });
        }
    });
}

document.getElementById('pay-button').onclick = async function () {
    const button = this;
    const originalHTML = button.innerHTML;
    button.innerHTML = '<svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg> Processing…';
    button.disabled = true;

    try {
        // Create order — all booking data comes from server session
        const response = await fetch('/api/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        });

        const data = await response.json();

        if (data.error) {
            alert(data.error);
            button.innerHTML = originalHTML;
            button.disabled = false;
            return;
        }

        // Shared helper — called regardless of how the popup ends
        async function confirmAndRedirect() {
            try {
                await fetch('/api/checkout/simulate-success', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order_id: data.order_id })
                });
            } catch(e) {
                console.error('simulate-success failed:', e);
            }
            window.location.href = `/booking/success/${data.order_id}`;
        }

        if (data.snap_token) {
            window.snap.pay(data.snap_token, {
                onSuccess:  async function() { await confirmAndRedirect(); },
                onPending:  async function() { await confirmAndRedirect(); },
                onError:    function(result) {
                    alert('Payment failed. Please try again.');
                    button.innerHTML = originalHTML;
                    button.disabled = false;
                },
                onClose:    async function() { await confirmAndRedirect(); }
            });
        } else {
            alert('Failed to get payment token. Please try again.');
            button.innerHTML = originalHTML;
            button.disabled = false;
        }
    } catch (err) {
        console.error(err);
        alert('Something went wrong. Please try again.');
        button.innerHTML = originalHTML;
        button.disabled = false;
    }
};

</script>
@endsection
