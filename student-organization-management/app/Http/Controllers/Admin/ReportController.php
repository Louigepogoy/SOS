<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'active', 'role:super_admin']);
    }

    public function index()
    {
        $reports = [
            'users_by_role' => User::select('role', DB::raw('count(*) as total'))->groupBy('role')->pluck('total', 'role'),
            'orgs_by_status' => Organization::select('status', DB::raw('count(*) as total'))->groupBy('status')->pluck('total', 'status'),
            'memberships_by_status' => Membership::select('status', DB::raw('count(*) as total'))->groupBy('status')->pluck('total', 'status'),
            'total_events' => Event::count(),
            'recent_orgs' => Organization::latest()->limit(5)->get(),
        ];

        return view('admin.reports.index', compact('reports'));
    }
}
