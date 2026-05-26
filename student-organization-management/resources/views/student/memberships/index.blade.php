@extends('layouts.app')
@section('page-title', 'My Memberships')
@section('content')

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card card-stat p-3 text-center">
            <h4 class="text-warning mb-0">{{ $counts['pending'] }}</h4>
            <small class="text-muted">Pending Approval</small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-stat p-3 text-center">
            <h4 class="text-success mb-0">{{ $counts['approved'] }}</h4>
            <small class="text-muted">Active Memberships</small>
        </div>
    </div>
</div>

@forelse($memberships as $m)
    <div class="card card-stat mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                <div>
                    <h5 class="mb-1">{{ $m->organization->name }}</h5>
                    @include('partials.membership-status', ['membership' => $m])
                    @if($m->message)<p class="small text-muted mt-2 mb-0">Your message: {{ $m->message }}</p>@endif
                    @if($m->isPending())
                        <p class="small text-warning mt-2 mb-0"><i class="bi bi-clock"></i> Waiting for officer to approve — submitted {{ $m->created_at->diffForHumans() }}</p>
                    @endif
                    @if($m->joined_at)<p class="small text-muted mt-1 mb-0">Joined {{ $m->joined_at->format('M d, Y') }}</p>@endif
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('student.organizations.show', $m->organization) }}" class="btn btn-sm btn-outline-primary">View</a>
                    @if($m->isPending())
                        <form method="POST" action="{{ route('student.memberships.cancel', $m) }}" onsubmit="return confirm('Cancel request?')">@csrf
                            <button class="btn btn-sm btn-outline-secondary">Cancel</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="text-center py-5 text-muted">
        <i class="bi bi-building display-4 d-block mb-3"></i>
        <h5>No memberships yet</h5>
        <a href="{{ route('student.organizations.index') }}" class="btn btn-primary">Browse Organizations</a>
    </div>
@endforelse
{{ $memberships->links() }}
@endsection
