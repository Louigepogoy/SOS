@extends('layouts.app')
@section('page-title', 'Membership Request Details')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        @include('partials.membership-request-card', ['membership' => $membership, 'showOrganization' => true])
        @if($membership->reviewer)
            <div class="card card-stat mt-3 p-3 small text-muted">
                Reviewed by {{ $membership->reviewer->name }} on {{ $membership->reviewed_at?->format('M d, Y h:i A') }}
            </div>
        @endif
        <a href="{{ route('admin.memberships.index', ['status' => $membership->status]) }}" class="btn btn-outline-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
</div>
@endsection
