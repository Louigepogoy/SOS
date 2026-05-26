<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'active', 'role:student']);
    }

    public function index(Request $request)
    {
        $query = Organization::with('officer')
            ->where('status', Organization::STATUS_APPROVED);

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $organizations = $query->latest()->paginate(9);
        $memberships = Membership::where('user_id', $request->user()->id)
            ->get()
            ->keyBy('organization_id');

        return view('student.organizations.index', compact('organizations', 'memberships'));
    }

    public function show(Organization $organization)
    {
        abort_unless($organization->isApproved(), 404);

        $membership = Membership::where('user_id', auth()->id())
            ->where('organization_id', $organization->id)
            ->first();

        return view('student.organizations.show', compact('organization', 'membership'));
    }

    public function join(Request $request, Organization $organization)
    {
        abort_unless($organization->isApproved(), 404);

        $validated = $request->validate([
            'message' => ['nullable', 'string', 'max:500'],
        ]);

        $existing = Membership::where('user_id', $request->user()->id)
            ->where('organization_id', $organization->id)
            ->first();

        if ($existing?->status === Membership::STATUS_PENDING) {
            return back()->with('error', 'You already have a pending request for this organization.');
        }

        if ($existing?->status === Membership::STATUS_APPROVED) {
            return back()->with('error', 'You are already a member of this organization.');
        }

        Membership::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'organization_id' => $organization->id,
            ],
            [
                'status' => Membership::STATUS_PENDING,
                'message' => $validated['message'] ?? null,
                'left_at' => null,
                'reviewed_by' => null,
                'reviewed_at' => null,
                'joined_at' => null,
            ]
        );

        return back()->with('success', 'Join request sent! The organization officer will review your application.');
    }

    public function cancel(Membership $membership)
    {
        abort_unless($membership->user_id === auth()->id(), 403);
        abort_unless($membership->isPending(), 403, 'Only pending requests can be cancelled.');

        $membership->delete();

        return back()->with('success', 'Your join request has been cancelled.');
    }

    public function leave(Organization $organization)
    {
        $membership = Membership::where('user_id', auth()->id())
            ->where('organization_id', $organization->id)
            ->where('status', Membership::STATUS_APPROVED)
            ->firstOrFail();

        $membership->update([
            'status' => Membership::STATUS_LEFT,
            'left_at' => now(),
        ]);

        return back()->with('success', 'You have left the organization.');
    }

    public function memberships(Request $request)
    {
        $memberships = Membership::with('organization')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        $counts = [
            'pending' => Membership::where('user_id', $request->user()->id)->pending()->count(),
            'approved' => Membership::where('user_id', $request->user()->id)->approved()->count(),
        ];

        return view('student.memberships.index', compact('memberships', 'counts'));
    }
}
