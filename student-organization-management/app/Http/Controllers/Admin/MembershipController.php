<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\Organization;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'active', 'role:super_admin']);
    }

    public function index(Request $request)
    {
        $status = $request->get('status', Membership::STATUS_PENDING);

        $memberships = Membership::with(['user', 'organization', 'reviewer'])
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->when($request->organization_id, fn ($q) => $q->where('organization_id', $request->organization_id))
            ->when($request->search, function ($q) use ($request) {
                $q->whereHas('user', function ($userQuery) use ($request) {
                    $userQuery->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%')
                        ->orWhere('student_id', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'pending' => Membership::pending()->count(),
            'approved' => Membership::approved()->count(),
            'rejected' => Membership::where('status', Membership::STATUS_REJECTED)->count(),
            'left' => Membership::where('status', Membership::STATUS_LEFT)->count(),
        ];

        $organizations = Organization::orderBy('name')->get(['id', 'name']);

        return view('admin.memberships.index', compact('memberships', 'status', 'counts', 'organizations'));
    }

    public function show(Membership $membership)
    {
        $membership->load(['user', 'organization.officer', 'reviewer']);

        return view('admin.memberships.show', compact('membership'));
    }

    public function approve(Membership $membership)
    {
        if (! $membership->isPending()) {
            return back()->with('error', 'This request is no longer pending.');
        }

        $membership->update([
            'status' => Membership::STATUS_APPROVED,
            'joined_at' => now(),
            'left_at' => null,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Membership approved for ' . $membership->user->name . '.');
    }

    public function reject(Membership $membership)
    {
        if (! $membership->isPending()) {
            return back()->with('error', 'This request is no longer pending.');
        }

        $membership->update([
            'status' => Membership::STATUS_REJECTED,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Membership request rejected.');
    }
}
