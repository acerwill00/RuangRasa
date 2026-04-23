<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class VerificationController extends Controller
{
    public function show(Request $request)
    {
        $email = session('email') ?? $request->query('email');
        
        if (!$email) {
            return redirect('/login')->with('error', 'Please enter your email to verify.');
        }

        return view('auth.verify-otp', compact('email'));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code'  => 'required|string|size:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->email_verified_at) {
            return redirect('/login')->with('success', 'Email already verified. Please login.');
        }

        if ($user->verification_code !== $request->code) {
            return back()->with('error', 'Invalid verification code.')->with('email', $request->email);
        }

        if (now()->greaterThan($user->verification_code_expires_at)) {
            return back()->with('error', 'Verification code has expired. Please request a new one.')->with('email', $request->email);
        }

        // Verify user
        $user->email_verified_at = now();
        $user->verification_code = null;
        $user->verification_code_expires_at = null;
        $user->save();

        \Illuminate\Support\Facades\Auth::login($user);
        $request->session()->regenerate();
        session()->flash('login_success', $user->name);

        return redirect('/dashboard');
    }

    public function resend(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->email_verified_at) {
            return redirect('/login')->with('success', 'Email already verified. Please login.');
        }

        // Generate new code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $user->verification_code = $code;
        $user->verification_code_expires_at = now()->addMinutes(15);
        $user->save();

        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\VerificationCodeMail($code));

        return back()->with('success', 'A new verification code has been sent to your email.')->with('email', $request->email);
    }
}
