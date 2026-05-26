@extends('layouts.app')
@section('page-title', $organization->name)
@section('content')
<div class="card card-stat overflow-hidden">
    @if($organization->coverUrl())<img src="{{ $organization->coverUrl() }}" class="w-100" style="height:200px;object-fit:cover" alt="">@endif
    <div class="card-body">
        <div class="d-flex align-items-center mb-3">
            <img src="{{ $organization->logoUrl() }}" class="rounded-circle me-3" width="64" height="64" alt="">
            <div>
                <h4 class="mb-0">{{ $organization->name }}</h4>
                <small class="text-muted">Officer: {{ $organization->officer?->name ?? 'N/A' }}</small>
            </div>
        </div>
        <p>{{ $organization->description }}</p>

        @if($membership)
            <div class="alert alert-{{ $membership->statusBadgeClass() }} d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <strong>Status:</strong> @include('partials.membership-status', ['membership' => $membership])
                    @if($membership->isPending())
                        <div class="small mt-1">Your request was sent {{ $membership->created_at->diffForHumans() }}. Waiting for officer approval.</div>
                    @endif
                    @if($membership->status === 'rejected')
                        <div class="small mt-1">You may submit a new request below.</div>
                    @endif
                </div>
            </div>
        @endif

        @if($membership?->status === 'approved')
            <form method="POST" action="{{ route('student.organizations.leave', $organization) }}" onsubmit="return confirm('Leave this organization?')">@csrf
                <button class="btn btn-outline-danger"><i class="bi bi-box-arrow-right"></i> Leave Organization</button>
            </form>
        @elseif($membership?->status === 'pending')
            <form method="POST" action="{{ route('student.memberships.cancel', $membership) }}" onsubmit="return confirm('Cancel your join request?')">@csrf
                <button class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Cancel Request</button>
            </form>
        @else
            <div class="card bg-light border-0">
                <div class="card-body">
                    <h6><i class="bi bi-send"></i> Request to Join</h6>
                    <form method="POST" action="{{ route('student.organizations.join', $organization) }}">@csrf
                        <div class="mb-3">
                            <label class="form-label">Message to Officer (optional)</label>
                            <textarea name="message" class="form-control" rows="3" placeholder="Introduce yourself or explain why you want to join...">{{ old('message') }}</textarea>
                        </div>
                        <button class="btn btn-primary btn-lg"><i class="bi bi-person-plus"></i> Submit Join Request</button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
