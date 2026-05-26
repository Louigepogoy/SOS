<div class="card membership-request-card h-100 border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex align-items-start gap-3">
            <img src="{{ $membership->user->avatarUrl() }}" class="rounded-circle flex-shrink-0" width="56" height="56" alt="">
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <div>
                        <h6 class="mb-0">{{ $membership->user->name }}</h6>
                        <small class="text-muted">{{ $membership->user->email }}</small>
                    </div>
                    @include('partials.membership-status', ['membership' => $membership])
                </div>
                <div class="mt-2 small">
                    @if($membership->user->student_id)
                        <span class="me-3"><i class="bi bi-person-badge"></i> {{ $membership->user->student_id }}</span>
                    @endif
                    @if($membership->user->course)
                        <span class="me-3"><i class="bi bi-book"></i> {{ $membership->user->course }}</span>
                    @endif
                    @if($membership->user->year_level)
                        <span><i class="bi bi-layers"></i> {{ $membership->user->year_level }}</span>
                    @endif
                </div>
                @if(isset($showOrganization) && $showOrganization)
                    <div class="mt-1 small text-primary"><i class="bi bi-building"></i> {{ $membership->organization->name }}</div>
                @endif
                @if($membership->message)
                    <div class="mt-2 p-2 bg-light rounded small">
                        <strong>Message:</strong> {{ $membership->message }}
                    </div>
                @endif
                <div class="text-muted small mt-2">Requested {{ $membership->created_at->diffForHumans() }}</div>
            </div>
        </div>
        @if($membership->isPending())
            <div class="d-flex gap-2 mt-3 pt-3 border-top">
                @if(auth()->user()->isOfficer())
                    <form method="POST" action="{{ route('officer.memberships.approve', $membership) }}">@csrf
                        <button class="btn btn-success btn-sm"><i class="bi bi-check-lg"></i> Approve</button>
                    </form>
                    <form method="POST" action="{{ route('officer.memberships.reject', $membership) }}" onsubmit="return confirm('Reject this request?')">@csrf
                        <button class="btn btn-outline-danger btn-sm"><i class="bi bi-x-lg"></i> Reject</button>
                    </form>
                    <a href="{{ route('officer.memberships.show', $membership) }}" class="btn btn-outline-secondary btn-sm ms-auto">View Details</a>
                @elseif(auth()->user()->isSuperAdmin())
                    <form method="POST" action="{{ route('admin.memberships.approve', $membership) }}">@csrf
                        <button class="btn btn-success btn-sm"><i class="bi bi-check-lg"></i> Approve</button>
                    </form>
                    <form method="POST" action="{{ route('admin.memberships.reject', $membership) }}" onsubmit="return confirm('Reject this request?')">@csrf
                        <button class="btn btn-outline-danger btn-sm"><i class="bi bi-x-lg"></i> Reject</button>
                    </form>
                    <a href="{{ route('admin.memberships.show', $membership) }}" class="btn btn-outline-secondary btn-sm ms-auto">View Details</a>
                @endif
            </div>
        @endif
    </div>
</div>
