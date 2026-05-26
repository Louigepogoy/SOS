@extends('layouts.app')
@section('title', 'Officer Dashboard')
@section('page-title', 'Officer Dashboard')

@section('content')
@if(!$organization)
    <div class="alert alert-warning"><i class="bi bi-exclamation-triangle me-2"></i>No organization has been assigned to your account yet. Contact the administrator.</div>
@else
<div class="row g-4 mb-4">
    <div class="col-md-4"><div class="card card-stat p-3"><div class="text-muted small">Active Members</div><h3 class="text-success">{{ $memberCount }}</h3></div></div>
    <div class="col-md-4">
        <div class="card card-stat p-3 {{ $pendingRequests->count() ? 'border-warning' : '' }}">
            <div class="text-muted small">Pending Join Requests</div>
            <h3 class="text-warning">{{ $pendingRequests->count() }}</h3>
            @if($pendingRequests->count())
                <a href="{{ route('officer.memberships.index', ['status' => 'pending']) }}" class="small">Review now →</a>
            @endif
        </div>
    </div>
    <div class="col-md-4"><div class="card card-stat p-3"><div class="text-muted small">Events</div><h3>{{ $eventCount }}</h3></div></div>
</div>

@if($pendingRequests->count())
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0"><i class="bi bi-person-plus text-warning"></i> Students Waiting to Join</h5>
        <a href="{{ route('officer.memberships.index', ['status' => 'pending']) }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="row g-3">
        @foreach($pendingRequests->take(3) as $req)
            <div class="col-md-4">
                @include('partials.membership-request-card', ['membership' => $req])
            </div>
        @endforeach
    </div>
</div>
@endif

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card card-stat p-3">
            <h6 class="mb-3">Member Growth (6 months)</h6>
            <canvas id="officerChart" height="120"></canvas>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card card-stat p-3">
            <h6 class="mb-3">Quick Actions</h6>
            <div class="d-grid gap-2">
                <a href="{{ route('officer.memberships.index', ['status' => 'pending']) }}" class="btn btn-outline-warning text-start"><i class="bi bi-person-plus me-2"></i> Review Join Requests</a>
                <a href="{{ route('officer.events.create') }}" class="btn btn-outline-primary text-start"><i class="bi bi-calendar-plus me-2"></i> Create Event</a>
                <a href="{{ route('officer.announcements.create') }}" class="btn btn-outline-primary text-start"><i class="bi bi-megaphone me-2"></i> Post Announcement</a>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
@if($organization)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('officerChart'), {
    type: 'line',
    data: {
        labels: @json($chartLabels ?? []),
        datasets: [{ label: 'New Members', data: @json($chartData ?? []), borderColor: '#4f46e5', tension: 0.3, fill: false }]
    },
    options: { responsive: true, plugins: { legend: { display: false } } }
});
</script>
@endif
@endpush
