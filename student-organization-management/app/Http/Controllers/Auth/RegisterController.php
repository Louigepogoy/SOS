<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        if (SystemSetting::get('registration_enabled', '1') !== '1') {
            return redirect()->route('login')
                ->with('error', 'New student registration is currently disabled.');
        }

        return view('auth.register');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'student_id' => ['required', 'string', 'max:50', 'unique:users'],
            'course' => ['nullable', 'string', 'max:255'],
            'year_level' => ['nullable', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'student_id' => $data['student_id'],
            'course' => $data['course'] ?? null,
            'year_level' => $data['year_level'] ?? null,
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'role' => User::ROLE_STUDENT,
            'is_active' => true,
        ]);

        // On local/XAMPP, skip email verification (no mail server configured)
        if (app()->environment('local')) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        return $user;
    }

    protected function registered(Request $request, $user)
    {
        if (app()->environment('local')) {
            return redirect()->route('dashboard')
                ->with('success', 'Welcome! Your account has been created successfully.');
        }

        return redirect()->route('verification.notice')
            ->with('success', 'Account created! Please check your email to verify your account.');
    }
}
