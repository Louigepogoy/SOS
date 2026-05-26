<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\SystemSetting;

class HomeController extends Controller
{
    public function index()
    {
        $organizations = Organization::where('status', Organization::STATUS_APPROVED)
            ->latest()
            ->limit(6)
            ->get();

        return view('welcome', [
            'organizations' => $organizations,
            'siteName' => SystemSetting::get('site_name', config('app.name')),
            'siteTagline' => SystemSetting::get('site_tagline', 'Manage student organizations, memberships, events, and more.'),
        ]);
    }
}
