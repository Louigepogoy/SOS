@extends('layouts.app')
@section('page-title', 'Membership Requests')
@section('content')

<div class="alert alert-light border mb-4 d-flex align-items-center">
    <i class="bi bi-building fs-4 text-primary me-3"></i>
    <div>
        <strong>{{ $organization->name }}</strong>
        <div class="small text-muted">Review students who want to join your organization</div>
    </div>
</div>

<div class="row g-3 mb-4">
    @foreach([
        ['pending', 'warning', 'Pending'],
        ['approved', 'success', 'Active Members'],
        ['rejected', 'danger', 'Rejected'],
        ['left', 'secondary', 'Left'],
    ] as [$key, $color, $label])
    <div class="col-6 col-md-3">
        <a href="{{ route('officer.memberships.index', ['status' => $key]) }}" class="text-decoration-none">
            <div class="card card-stat p-3 text-center {{ $status === $key ? 'border-primary border-2' : '' }}">
                <h4 class="mb-0 text-{{ $color }}">{{ $counts[$key] }}</h4>
                <small class="text-muted">{{ $label }}</small>
            </div>
        </a>
    </div>
    @endforeach
</div>

<form class="row g-2 mb-4" method="GET">
    <input type="hidden" name="status" value="{{ $status }}">
    <div class="col-md-8">
        <input name="search" class="form-control" placeholder="Search by name, email, or student ID..." value="{{ request('search') }}">
    </div>
    <div class="col-md-4">
        <button class="btn btn-primary w-100"><i class="bi bi-search"></i> Search</button>
    </div>
</form>

@if($status === 'pending' && $memberships->isEmpty())
    <div class="text-center py-5 text-muted">
        <i class="bi bi-inbox display-4 d-block mb-3"></i>
        <h5>No pending join requests</h5>
        <p>When students request to join, they will appear here for your approval.</p>
    </div>
@else
    <div class="row g-3">
        @foreach($memberships as $membership)
            <div class="col-md-6 col-xl-4">
                @include('partials.membership-request-card', ['membership' => $membership])
            </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $memberships->links() }}</div>
@endif
@endsection
