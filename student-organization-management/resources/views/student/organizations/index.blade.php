@extends('layouts.app')
@section('page-title', 'Browse Organizations')
@section('content')
<form class="row g-2 mb-4" method="GET">
    <div class="col-md-8"><input name="search" class="form-control" placeholder="Search organizations..." value="{{ request('search') }}"></div>
    <div class="col-md-4"><button class="btn btn-primary w-100"><i class="bi bi-search"></i> Search</button></div>
</form>
<div class="row g-4">
    @foreach($organizations as $org)
        @php $m = $memberships[$org->id] ?? null; @endphp
        <div class="col-md-4">
            <div class="card card-stat h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center mb-2">
                        <img src="{{ $org->logoUrl() }}" class="rounded-circle me-2" width="48" height="48" alt="">
                        <h5 class="mb-0">{{ $org->name }}</h5>
                    </div>
                    <p class="text-muted small flex-grow-1">{{ \Illuminate\Support\Str::limit($org->description, 90) }}</p>
                    @if($m)
                        <div class="mb-2">@include('partials.membership-status', ['membership' => $m])</div>
                    @endif
                    <a href="{{ route('student.organizations.show', $org) }}" class="btn btn-sm {{ $m?->isPending() ? 'btn-warning' : ($m?->isActive() ? 'btn-success' : 'btn-primary') }}">
                        @if($m?->isPending()) View Pending Request
                        @elseif($m?->isActive()) View Membership
                        @else Join Organization @endif
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="mt-4">{{ $organizations->withQueryString()->links() }}</div>
@endsection
