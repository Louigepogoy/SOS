<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'SOS'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --sos-primary: #4f46e5; }
        body { background: linear-gradient(135deg, #eef2ff 0%, #f8fafc 50%, #ede9fe 100%); min-height: 100vh; }
        .auth-card { border: 0; border-radius: 1rem; box-shadow: 0 10px 40px rgba(79,70,229,.12); }
        .btn-primary { background: var(--sos-primary); border-color: var(--sos-primary); }
        .btn-primary:hover { background: #4338ca; border-color: #4338ca; }
        .brand-link { color: var(--sos-primary); font-weight: 700; text-decoration: none; }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="brand-link" href="{{ route('home') }}"><i class="bi bi-mortarboard-fill"></i> {{ config('app.name') }}</a>
        <div>
            @if(Route::has('login') && !request()->routeIs('login'))
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary me-1">Login</a>
            @endif
            @if(Route::has('register') && !request()->routeIs('register'))
                <a href="{{ route('register') }}" class="btn btn-sm btn-primary">Register</a>
            @endif
        </div>
    </div>
</nav>

<div class="container py-5">
    @include('layouts.partials.alerts')
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('layouts.partials.flash-swal')
@stack('scripts')
</body>
</html>
