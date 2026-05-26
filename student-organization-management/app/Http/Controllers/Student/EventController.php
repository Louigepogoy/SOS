<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Membership;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'active', 'role:student']);
    }

    public function index(Request $request)
    {
        $orgIds = Membership::where('user_id', $request->user()->id)
            ->where('status', Membership::STATUS_APPROVED)
            ->pluck('organization_id');

        $events = Event::with('organization')
            ->whereIn('organization_id', $orgIds)
            ->orderBy('starts_at')
            ->paginate(12);

        return view('student.events.index', compact('events'));
    }
}
