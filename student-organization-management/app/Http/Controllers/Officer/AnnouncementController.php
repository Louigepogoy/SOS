<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'active', 'role:officer']);
    }

    public function index(Request $request)
    {
        $organization = $request->user()->managedOrganization;
        abort_unless($organization, 403);

        $announcements = $organization->announcements()->with('creator')->latest()->paginate(10);

        return view('officer.announcements.index', compact('organization', 'announcements'));
    }

    public function create(Request $request)
    {
        $organization = $request->user()->managedOrganization;
        abort_unless($organization, 403);

        return view('officer.announcements.create', compact('organization'));
    }

    public function store(Request $request)
    {
        $organization = $request->user()->managedOrganization;
        abort_unless($organization, 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $organization->announcements()->create(array_merge($validated, [
            'created_by' => $request->user()->id,
        ]));

        return redirect()->route('officer.announcements.index')->with('success', 'Announcement posted.');
    }

    public function destroy(Announcement $announcement)
    {
        $organization = auth()->user()->managedOrganization;
        abort_unless($organization && $announcement->organization_id === $organization->id, 403);
        $announcement->delete();

        return back()->with('success', 'Announcement deleted.');
    }
}
