@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('page-title', 'Super Admin Dashboard')

@section('content')
<div class="row g-4 mb-4">
    @foreach([
        ['Students', $stats['students'], 'bi-people', 'primary'],
        ['Officers', $stats['officers'], 'bi-person-badge', 'info'],
        ['Organizations', $stats['organizations'], 'bi-building', 'primary'],
        ['Pending Orgs', $stats['pending_orgs'], 'bi-hourglass', 'warning'],
        ['Active Members', $stats['memberships'], 'bi-check-circle', 'success'],
        ['Pending Joins', $stats['pending_memberships'], 'bi-person-plus', 'warning'],
    ] as [$label, $value, $icon, $color])
    <div class="col-md-4 col-lg-2">
        <div class="card card-stat p-3 text-center">
            <i class="bi {{ $icon }} fs-3 text-{{ $color }}"></i>
            <h4 class="mt-2 mb-0">{{ $value }}</h4>
            <small class="text-muted">{{ $label }}</small>
        </div>
    </div>
    @endforeach
</div>

@if($pendingMemberships->count())
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0"><i class="bi bi-bell text-warning"></i> Pending Student Join Requests</h5>
        <a href="{{ route('admin.memberships.index', ['status' => 'pending']) }}" class="btn btn-sm btn-warning">Manage All</a>
    </div>
    <div class="row g-3">
        @foreach($pendingMemberships->take(3) as $membership)
            <div class="col-md-4">
                @include('partials.membership-request-card', ['membership' => $membership, 'showOrganization' => true])
            </div>
        @endforeach
    </div>
</div>
@endif

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card card-stat p-3">
            <h6 class="mb-3">User Registrations (6 months)</h6>
            <canvas id="adminChart" height="100"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-stat p-3">
            <h6 class="mb-3">Organization Status</h6>
            <ul class="list-group list-group-flush">
                @foreach($orgStatus as $status => $count)
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-capitalize">{{ $status }}</span>
                        <span class="badge bg-primary">{{ $count }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('adminChart'), {
    type: 'bar',
    data: {
        labels: @json($chartLabels),
        datasets: [{ label: 'Users', data: @json($chartData), backgroundColor: '#4f46e5' }]
    },
    options: { responsive: true, plugins: { legend: { display: false } } }
});
</script>
@endpush
