<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'active', 'role:officer']);
    }

    public function index(Request $request)
    {
        $organization = $request->user()->managedOrganization;
        abort_unless($organization, 403);

        $stats = [
            'total_members' => Membership::where('organization_id', $organization->id)
                ->where('status', Membership::STATUS_APPROVED)->count(),
            'pending' => Membership::where('organization_id', $organization->id)
                ->where('status', Membership::STATUS_PENDING)->count(),
            'events' => $organization->events()->count(),
            'announcements' => $organization->announcements()->count(),
        ];

        return view('officer.reports.index', compact('organization', 'stats'));
    }

    public function export(Request $request): StreamedResponse
    {
        $organization = $request->user()->managedOrganization;
        abort_unless($organization, 403);

        $members = Membership::with('user')
            ->where('organization_id', $organization->id)
            ->where('status', Membership::STATUS_APPROVED)
            ->get();

        $filename = 'members-' . $organization->slug . '-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($members, $organization) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Organization', $organization->name]);
            fputcsv($handle, ['Name', 'Email', 'Student ID', 'Course', 'Joined At']);
            foreach ($members as $membership) {
                fputcsv($handle, [
                    $membership->user->name,
                    $membership->user->email,
                    $membership->user->student_id,
                    $membership->user->course,
                    optional($membership->joined_at)->format('Y-m-d H:i'),
                ]);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
