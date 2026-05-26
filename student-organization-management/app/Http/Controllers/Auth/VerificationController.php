<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    use VerifiesEmails;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function show(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        if (app()->environment('local')) {
            $request->user()->markEmailAsVerified();

            return redirect()->route('dashboard')
                ->with('success', 'Email verified (local development mode).');
        }

        return view('auth.verify');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        if (app()->environment('local')) {
            $request->user()->markEmailAsVerified();

            return back()->with('success', 'Email verified (local development mode).');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'A fresh verification link has been sent to your email.');
    }
}
