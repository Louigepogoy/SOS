<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Membership;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
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

        $announcements = Announcement::with(['organization', 'creator'])
            ->whereIn('organization_id', $orgIds)
            ->latest()
            ->paginate(12);

        return view('student.announcements.index', compact('announcements'));
    }
}
