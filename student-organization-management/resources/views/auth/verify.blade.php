@extends('layouts.guest')
@section('title', 'Verify Email')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card auth-card">
            <div class="card-body p-4 text-center">
                <i class="bi bi-envelope-check display-4 text-primary mb-3"></i>
                <h4>Verify your email</h4>
                <p class="text-muted">Check your inbox for a verification link before using the dashboard.</p>
                <form method="POST" action="{{ route('verification.resend') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-primary">Resend verification email</button>
                </form>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="btn btn-link">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
