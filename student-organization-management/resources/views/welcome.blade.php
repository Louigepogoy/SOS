<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $siteName }} - Student Organization System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .hero { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: #fff; padding: 5rem 0; }
        .org-card { border: 0; border-radius: 1rem; box-shadow: 0 4px 20px rgba(0,0,0,.08); transition: transform .2s; }
        .org-card:hover { transform: translateY(-4px); }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="/"><i class="bi bi-mortarboard-fill"></i> {{ $siteName }}</a>
        <div class="ms-auto">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
            @endauth
        </div>
    </div>
</nav>

<section class="hero text-center">
    <div class="container">
        <h1 class="display-5 fw-bold">{{ $siteName }}</h1>
        <p class="lead col-lg-8 mx-auto">{{ $siteTagline }}</p>
        @guest
            <a href="{{ route('register') }}" class="btn btn-light btn-lg mt-3">Get Started as Student</a>
        @endguest
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h3 class="mb-4">Featured Organizations</h3>
        <div class="row g-4">
            @forelse($organizations as $org)
                <div class="col-md-4">
                    <div class="card org-card h-100">
                        @if($org->coverUrl())
                            <img src="{{ $org->coverUrl() }}" class="card-img-top" alt="" style="height:140px;object-fit:cover;">
                        @endif
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <img src="{{ $org->logoUrl() }}" class="rounded-circle me-2" width="40" height="40" alt="">
                                <h5 class="card-title mb-0">{{ $org->name }}</h5>
                            </div>
                            <p class="card-text text-muted small">{{ \Illuminate\Support\Str::limit($org->description, 100) }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">No organizations yet.</p>
            @endforelse
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
