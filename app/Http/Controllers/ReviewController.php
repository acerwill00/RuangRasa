<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Appointment $appointment)
    {
        // Only the patient can review their own completed appointment
        if ($appointment->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($appointment->status !== 'completed') {
            return redirect('/dashboard')->with('error', 'You can only review completed sessions.');
        }

        if ($appointment->rating !== null) {
            return redirect('/dashboard')->with('error', 'You have already reviewed this session.');
        }

        return view('pages.review', compact('appointment'));
    }

    public function store(Request $request, Appointment $appointment)
    {
        if ($appointment->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        $appointment->update([
            'rating' => $validated['rating'],
            'review' => $validated['review'],
        ]);

        return redirect('/dashboard')->with('success', 'Thank you! Your review has been submitted.');
    }
}
