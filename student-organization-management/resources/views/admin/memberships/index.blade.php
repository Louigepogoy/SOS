@extends('layouts.app')
@section('page-title', 'All Membership Requests')
@section('content')

<div class="row g-3 mb-4">
    @foreach([
        ['pending', 'warning', 'Pending'],
        ['approved', 'success', 'Approved'],
        ['rejected', 'danger', 'Rejected'],
        ['left', 'secondary', 'Left'],
    ] as [$key, $color, $label])
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.memberships.index', ['status' => $key]) }}" class="text-decoration-none">
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
    <div class="col-md-4">
        <input name="search" class="form-control" placeholder="Search student..." value="{{ request('search') }}">
    </div>
    <div class="col-md-4">
        <select name="organization_id" class="form-select">
            <option value="">All Organizations</option>
            @foreach($organizations as $org)
                <option value="{{ $org->id }}" @selected(request('organization_id') == $org->id)>{{ $org->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <button class="btn btn-primary w-100">Filter</button>
    </div>
</form>

@if($memberships->isEmpty())
    <div class="text-center py-5 text-muted">
        <i class="bi bi-inbox display-4 d-block mb-3"></i>
        <h5>No membership requests found</h5>
    </div>
@else
    <div class="row g-3">
        @foreach($memberships as $membership)
            <div class="col-md-6 col-xl-4">
                @include('partials.membership-request-card', ['membership' => $membership, 'showOrganization' => true])
            </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $memberships->links() }}</div>
@endif
@endsection
