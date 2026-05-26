<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'active', 'role:super_admin']);
    }

    public function index()
    {
        $settings = [
            'site_name' => SystemSetting::get('site_name', config('app.name')),
            'site_tagline' => SystemSetting::get('site_tagline', 'Student Organization System'),
            'contact_email' => SystemSetting::get('contact_email', ''),
            'registration_enabled' => SystemSetting::get('registration_enabled', '1'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_tagline' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email'],
            'registration_enabled' => ['required', 'in:0,1'],
        ]);

        foreach ($validated as $key => $value) {
            SystemSetting::set($key, $value);
        }

        return back()->with('success', 'Settings saved successfully.');
    }
}
