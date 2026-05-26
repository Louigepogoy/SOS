<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
            <i class="bi bi-person me-2"></i> Profile
        </a>
    </li>

    @if(auth()->user()->isStudent())
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('student.organizations.*') ? 'active' : '' }}" href="{{ route('student.organizations.index') }}"><i class="bi bi-building me-2"></i> Browse Organizations</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('student.memberships.*') ? 'active' : '' }}" href="{{ route('student.memberships.index') }}"><i class="bi bi-people me-2"></i> My Memberships</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('student.events.*') ? 'active' : '' }}" href="{{ route('student.events.index') }}"><i class="bi bi-calendar-event me-2"></i> Events</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('student.announcements.*') ? 'active' : '' }}" href="{{ route('student.announcements.index') }}"><i class="bi bi-megaphone me-2"></i> Announcements</a></li>
    @endif

    @if(auth()->user()->isOfficer())
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('officer.organization.*') ? 'active' : '' }}" href="{{ route('officer.organization.edit') }}"><i class="bi bi-building me-2"></i> My Organization</a></li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('officer.memberships.*') ? 'active' : '' }} d-flex justify-content-between align-items-center" href="{{ route('officer.memberships.index', ['status' => 'pending']) }}">
                <span><i class="bi bi-person-plus me-2"></i> Join Requests</span>
                @if(($pendingMembershipCount ?? 0) > 0)
                    <span class="badge bg-warning text-dark rounded-pill">{{ $pendingMembershipCount }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('officer.events.*') ? 'active' : '' }}" href="{{ route('officer.events.index') }}"><i class="bi bi-calendar-plus me-2"></i> Events</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('officer.announcements.*') ? 'active' : '' }}" href="{{ route('officer.announcements.index') }}"><i class="bi bi-megaphone me-2"></i> Announcements</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('officer.reports.*') ? 'active' : '' }}" href="{{ route('officer.reports.index') }}"><i class="bi bi-file-earmark-bar-graph me-2"></i> Reports</a></li>
    @endif

    @if(auth()->user()->isSuperAdmin())
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="bi bi-people me-2"></i> Users</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.organizations.*') ? 'active' : '' }}" href="{{ route('admin.organizations.index') }}"><i class="bi bi-building me-2"></i> Organizations</a></li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.memberships.*') ? 'active' : '' }} d-flex justify-content-between align-items-center" href="{{ route('admin.memberships.index', ['status' => 'pending']) }}">
                <span><i class="bi bi-person-check me-2"></i> Memberships</span>
                @if(($pendingMembershipCount ?? 0) > 0)
                    <span class="badge bg-warning text-dark rounded-pill">{{ $pendingMembershipCount }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}"><i class="bi bi-graph-up me-2"></i> Reports</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}"><i class="bi bi-gear me-2"></i> Settings</a></li>
    @endif
</ul>
