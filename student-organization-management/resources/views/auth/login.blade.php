@extends('layouts.guest')
@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card auth-card">
            <div class="card-body p-4">
                <h4 class="mb-1 text-center">Welcome back</h4>
                <p class="text-muted text-center small mb-4">Sign in to your account</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required autofocus autocomplete="email">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                               required autocomplete="current-password">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
                    @if(Route::has('password.request'))
                        <p class="text-center small mb-2">
                            <a href="{{ route('password.request') }}">Forgot your password?</a>
                        </p>
                    @endif
                    <p class="text-center small mb-0">
                        No account? <a href="{{ route('register') }}">Register as student</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
