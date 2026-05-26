<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'active', 'role:officer']);
    }

    public function edit(Request $request)
    {
        $organization = $request->user()->managedOrganization;

        if (! $organization) {
            return redirect()->route('dashboard')
                ->with('error', 'No organization has been assigned to you yet.');
        }

        return view('officer.organization.edit', compact('organization'));
    }

    public function update(Request $request)
    {
        $organization = $request->user()->managedOrganization;

        if (! $organization) {
            return back()->with('error', 'No organization assigned.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'cover_photo' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('logo')) {
            if ($organization->logo) {
                Storage::disk('public')->delete($organization->logo);
            }
            $validated['logo'] = $request->file('logo')->store('organizations/logos', 'public');
        } else {
            unset($validated['logo']);
        }

        if ($request->hasFile('cover_photo')) {
            if ($organization->cover_photo) {
                Storage::disk('public')->delete($organization->cover_photo);
            }
            $validated['cover_photo'] = $request->file('cover_photo')->store('organizations/covers', 'public');
        } else {
            unset($validated['cover_photo']);
        }

        $organization->update($validated);

        return back()->with('success', 'Organization updated successfully.');
    }
}
