<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Appointment;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function create(Request $request)
    {
        $appointmentId = $request->query('appointment_id');
        return view('dashboard.complaint', compact('appointmentId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'nullable|exists:appointments,id',
            'subject'        => 'required|string|max:255',
            'description'    => 'required|string|max:2000',
        ]);

        Complaint::create([
            'user_id'        => auth()->id(),
            'appointment_id' => $request->appointment_id,
            'subject'        => $request->subject,
            'description'    => $request->description,
        ]);

        return redirect('/dashboard')->with('success', 'Your issue has been reported. Our team will review it shortly.');
    }
}
