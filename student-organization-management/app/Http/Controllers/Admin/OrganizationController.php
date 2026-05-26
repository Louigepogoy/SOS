<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'active', 'role:super_admin']);
    }

    public function index(Request $request)
    {
        $organizations = Organization::with(['officer', 'approver'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->search, fn ($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->latest()
            ->paginate(12);

        return view('admin.organizations.index', compact('organizations'));
    }

    public function create()
    {
        $officers = User::where('role', User::ROLE_OFFICER)->where('is_active', true)->get();

        return view('admin.organizations.create', compact('officers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'officer_id' => ['nullable', 'exists:users,id'],
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(4);

        if ($validated['status'] === Organization::STATUS_APPROVED) {
            $validated['approved_by'] = $request->user()->id;
            $validated['approved_at'] = now();
        }

        Organization::create($validated);

        return redirect()->route('admin.organizations.index')->with('success', 'Organization created.');
    }

    public function edit(Organization $organization)
    {
        $officers = User::where('role', User::ROLE_OFFICER)->where('is_active', true)->get();

        return view('admin.organizations.edit', compact('organization', 'officers'));
    }

    public function update(Request $request, Organization $organization)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'officer_id' => ['nullable', 'exists:users,id'],
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);

        if ($validated['status'] === Organization::STATUS_APPROVED && $organization->status !== Organization::STATUS_APPROVED) {
            $validated['approved_by'] = $request->user()->id;
            $validated['approved_at'] = now();
        }

        $organization->update($validated);

        return back()->with('success', 'Organization updated.');
    }

    public function approve(Organization $organization)
    {
        $organization->update([
            'status' => Organization::STATUS_APPROVED,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Organization approved.');
    }

    public function reject(Organization $organization)
    {
        $organization->update(['status' => Organization::STATUS_REJECTED]);

        return back()->with('success', 'Organization rejected.');
    }
}
