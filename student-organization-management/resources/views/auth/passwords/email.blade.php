@extends('layouts.guest')
@section('title', 'Forgot Password')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card auth-card">
            <div class="card-body p-4">
                <h4 class="mb-3 text-center">Reset Password</h4>
                <p class="text-muted small text-center">Enter your email and we will send a reset link.</p>

                @if(session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required autofocus>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                    <p class="text-center small mt-3 mb-0"><a href="{{ route('login') }}">Back to login</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
