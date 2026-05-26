<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'active', 'role:officer']);
    }

    protected function organization(Request $request)
    {
        $organization = $request->user()->managedOrganization;
        abort_unless($organization, 403, 'No organization assigned to your account. Contact the administrator.');

        return $organization;
    }

    public function index(Request $request)
    {
        $organization = $this->organization($request);
        $status = $request->get('status', Membership::STATUS_PENDING);

        $memberships = Membership::with(['user', 'reviewer'])
            ->where('organization_id', $organization->id)
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->when($request->search, function ($q) use ($request) {
                $q->whereHas('user', function ($userQuery) use ($request) {
                    $userQuery->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%')
                        ->orWhere('student_id', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $counts = [
            'pending' => Membership::where('organization_id', $organization->id)->pending()->count(),
            'approved' => Membership::where('organization_id', $organization->id)->approved()->count(),
            'rejected' => Membership::where('organization_id', $organization->id)->where('status', Membership::STATUS_REJECTED)->count(),
            'left' => Membership::where('organization_id', $organization->id)->where('status', Membership::STATUS_LEFT)->count(),
        ];

        return view('officer.memberships.index', compact('organization', 'memberships', 'status', 'counts'));
    }

    public function show(Membership $membership)
    {
        $this->authorizeMembership($membership);
        $membership->load(['user', 'organization', 'reviewer']);

        return view('officer.memberships.show', compact('membership'));
    }

    public function approve(Membership $membership)
    {
        $this->authorizeMembership($membership);

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

        return redirect()
            ->route('officer.memberships.index', ['status' => Membership::STATUS_PENDING])
            ->with('success', $membership->user->name . ' is now a member.');
    }

    public function reject(Membership $membership)
    {
        $this->authorizeMembership($membership);

        if (! $membership->isPending()) {
            return back()->with('error', 'This request is no longer pending.');
        }

        $membership->update([
            'status' => Membership::STATUS_REJECTED,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()
            ->route('officer.memberships.index', ['status' => Membership::STATUS_PENDING])
            ->with('success', 'Request from ' . $membership->user->name . ' was rejected.');
    }

    protected function authorizeMembership(Membership $membership): void
    {
        $organization = auth()->user()->managedOrganization;
        abort_unless($organization && $membership->organization_id === $organization->id, 403);
    }
}
