<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
        <small class="text-muted text-capitalize">{{ str_replace('_', ' ', auth()->user()->role) }}</small>
    </div>
    <div class="d-flex align-items-center gap-3">
        @if(($pendingMembershipCount ?? 0) > 0 && (auth()->user()->isOfficer() || auth()->user()->isSuperAdmin()))
            <a href="{{ auth()->user()->isOfficer() ? route('officer.memberships.index', ['status' => 'pending']) : route('admin.memberships.index', ['status' => 'pending']) }}"
               class="btn btn-warning btn-sm position-relative">
                <i class="bi bi-bell"></i> {{ $pendingMembershipCount }} Pending
            </a>
        @endif
        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                <img src="{{ auth()->user()->avatarUrl() }}" class="rounded-circle me-2" width="32" height="32" alt="">
                {{ auth()->user()->name }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </li>
            </ul>
        </div>
    </div>
</div>
