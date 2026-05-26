<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Event;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'active']);
    }

    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isSuperAdmin()) {
            return $this->adminDashboard();
        }

        if ($user->isOfficer()) {
            return $this->officerDashboard($user);
        }

        return $this->studentDashboard($user);
    }

    protected function studentDashboard(User $user)
    {
        $memberships = Membership::with('organization')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $orgIds = $memberships->where('status', Membership::STATUS_APPROVED)
            ->pluck('organization_id');

        return view('dashboard.student', [
            'memberships' => $memberships,
            'upcomingEvents' => Event::with('organization')
                ->whereIn('organization_id', $orgIds)
                ->where('starts_at', '>=', now())
                ->orderBy('starts_at')
                ->limit(5)
                ->get(),
            'announcements' => Announcement::with('organization')
                ->whereIn('organization_id', $orgIds)
                ->latest()
                ->limit(5)
                ->get(),
            'organizationsCount' => Organization::where('status', Organization::STATUS_APPROVED)->count(),
        ]);
    }

    protected function officerDashboard(User $user)
    {
        $organization = $user->managedOrganization;

        if (! $organization) {
            return view('dashboard.officer', [
                'organization' => null,
                'pendingRequests' => collect(),
                'memberCount' => 0,
                'eventCount' => 0,
                'chartLabels' => [],
                'chartData' => [],
            ]);
        }

        $pendingRequests = Membership::with('user')
            ->where('organization_id', $organization->id)
            ->where('status', Membership::STATUS_PENDING)
            ->latest()
            ->get();

        $memberCount = Membership::where('organization_id', $organization->id)
            ->where('status', Membership::STATUS_APPROVED)
            ->count();

        $monthlyMembers = Membership::where('organization_id', $organization->id)
            ->where('status', Membership::STATUS_APPROVED)
            ->where('joined_at', '>=', now()->subMonths(6))
            ->select(DB::raw("DATE_FORMAT(joined_at, '%Y-%m') as month"), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        return view('dashboard.officer', [
            'organization' => $organization,
            'pendingRequests' => $pendingRequests,
            'memberCount' => $memberCount,
            'eventCount' => $organization->events()->count(),
            'chartLabels' => $monthlyMembers->keys()->toArray(),
            'chartData' => $monthlyMembers->values()->toArray(),
        ]);
    }

    protected function adminDashboard()
    {
        $stats = [
            'students' => User::where('role', User::ROLE_STUDENT)->count(),
            'officers' => User::where('role', User::ROLE_OFFICER)->count(),
            'organizations' => Organization::count(),
            'pending_orgs' => Organization::where('status', Organization::STATUS_PENDING)->count(),
            'memberships' => Membership::where('status', Membership::STATUS_APPROVED)->count(),
            'events' => Event::count(),
        ];

        $orgStatus = Organization::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $monthlyUsers = User::where('created_at', '>=', now()->subMonths(6))
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $pendingMemberships = Membership::with(['user', 'organization'])
            ->pending()
            ->latest()
            ->limit(8)
            ->get();

        $stats['pending_memberships'] = Membership::pending()->count();

        return view('dashboard.admin', [
            'stats' => $stats,
            'orgStatus' => $orgStatus,
            'pendingMemberships' => $pendingMemberships,
            'chartLabels' => $monthlyUsers->keys()->toArray(),
            'chartData' => $monthlyUsers->values()->toArray(),
        ]);
    }
}
