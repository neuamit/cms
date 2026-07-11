<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function notice()
    {
        return auth()->user()->hasVerifiedEmail()
            ? redirect()->route('admin.dashboard')
            : view('auth.verify-email');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect()->route('admin.dashboard')->with('success', 'Email verified! Welcome aboard.');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('admin.dashboard');
        }
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Verification link sent!');
    }
}