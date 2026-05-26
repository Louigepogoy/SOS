<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'active', 'role:officer']);
    }

    public function index(Request $request)
    {
        $organization = $request->user()->managedOrganization;
        abort_unless($organization, 403);

        $events = $organization->events()->latest('starts_at')->paginate(10);

        return view('officer.events.index', compact('organization', 'events'));
    }

    public function create(Request $request)
    {
        $organization = $request->user()->managedOrganization;
        abort_unless($organization, 403);

        return view('officer.events.create', compact('organization'));
    }

    public function store(Request $request)
    {
        $organization = $request->user()->managedOrganization;
        abort_unless($organization, 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
        ]);

        $organization->events()->create(array_merge($validated, [
            'created_by' => $request->user()->id,
        ]));

        return redirect()->route('officer.events.index')->with('success', 'Event created.');
    }

    public function edit(Event $event)
    {
        $this->authorizeEvent($event);

        return view('officer.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorizeEvent($event);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
        ]);

        $event->update($validated);

        return redirect()->route('officer.events.index')->with('success', 'Event updated.');
    }

    public function destroy(Event $event)
    {
        $this->authorizeEvent($event);
        $event->delete();

        return back()->with('success', 'Event deleted.');
    }

    protected function authorizeEvent(Event $event): void
    {
        $organization = auth()->user()->managedOrganization;
        abort_unless($organization && $event->organization_id === $organization->id, 403);
    }
}
