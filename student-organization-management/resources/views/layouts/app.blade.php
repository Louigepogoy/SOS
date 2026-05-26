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
        :root { --sos-primary: #4f46e5; --sos-sidebar: #1e1b4b; }
        body { background: #f4f6fb; min-height: 100vh; }
        .sidebar { background: var(--sos-sidebar); min-height: calc(100vh - 0px); }
        .sidebar .nav-link { color: rgba(255,255,255,.75); border-radius: .5rem; margin-bottom: .25rem; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,.12); color: #fff; }
        .card-stat { border: 0; border-radius: 1rem; box-shadow: 0 4px 20px rgba(0,0,0,.06); }
        .membership-request-card { transition: transform .15s; }
        .membership-request-card:hover { transform: translateY(-2px); }
        .navbar-brand { font-weight: 700; color: var(--sos-primary) !important; }
        .btn-primary { background: var(--sos-primary); border-color: var(--sos-primary); }
        .btn-primary:hover { background: #4338ca; border-color: #4338ca; }
    </style>
    @stack('styles')
</head>
<body>
@auth
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 sidebar p-3 d-none d-md-block">
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-white text-decoration-none mb-4">
                <i class="bi bi-mortarboard-fill fs-4 me-2"></i>
                <span class="fw-bold">SOS</span>
            </a>
            @include('layouts.partials.sidebar')
        </nav>
        <main class="col-md-9 col-lg-10 px-md-4 py-4">
            @include('layouts.partials.topbar')
            @include('layouts.partials.alerts')
            @yield('content')
        </main>
    </div>
</div>
@else
    @include('layouts.partials.alerts')
    @yield('content')
@endauth

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('layouts.partials.flash-swal')
@stack('scripts')
</body>
</html>
