@extends('layouts.app')
@section('title', 'Student Dashboard')
@section('page-title', 'Student Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card card-stat p-3">
            <div class="text-muted small">My Memberships</div>
            <h3>{{ $memberships->where('status', 'approved')->count() }}</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-stat p-3">
            <div class="text-muted small">Pending Requests</div>
            <h3>{{ $memberships->where('status', 'pending')->count() }}</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-stat p-3">
            <div class="text-muted small">Available Organizations</div>
            <h3>{{ $organizationsCount }}</h3>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card card-stat">
            <div class="card-header bg-white border-0 fw-bold">Upcoming Events</div>
            <ul class="list-group list-group-flush">
                @forelse($upcomingEvents as $event)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ $event->title }} <small class="text-muted">({{ $event->organization->name }})</small></span>
                        <small>{{ $event->starts_at->format('M d, Y') }}</small>
                    </li>
                @empty
                    <li class="list-group-item text-muted">No upcoming events.</li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card card-stat">
            <div class="card-header bg-white border-0 fw-bold">Recent Announcements</div>
            <ul class="list-group list-group-flush">
                @forelse($announcements as $item)
                    <li class="list-group-item">
                        <strong>{{ $item->title }}</strong>
                        <div class="small text-muted">{{ $item->organization->name }} · {{ $item->created_at->diffForHumans() }}</div>
                    </li>
                @empty
                    <li class="list-group-item text-muted">No announcements.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
