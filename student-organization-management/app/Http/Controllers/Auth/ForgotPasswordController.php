<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        try {
            $status = Password::sendResetLink($request->only('email'));

            return $status === Password::RESET_LINK_SENT
                ? back()->with('status', __($status))
                : back()->withErrors(['email' => __($status)]);
        } catch (\Throwable $e) {
            Log::error('Password reset email failed: ' . $e->getMessage());

            if (app()->environment('local')) {
                return back()->with('status', 'Password reset requested. On local setup, check storage/logs/laravel.log for the reset link, or contact an administrator.');
            }

            return back()->withErrors(['email' => 'Unable to send reset email. Please try again later.']);
        }
    }
}
