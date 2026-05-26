@extends('layouts.app')
@section('page-title', 'System Settings')
@section('content')
<div class="card card-stat"><div class="card-body">
<form method="POST" action="{{ route('admin.settings.update') }}">@csrf @method('PUT')
    <div class="mb-3"><label class="form-label">Site Name</label><input name="site_name" class="form-control" value="{{ old('site_name', $settings['site_name']) }}" required></div>
    <div class="mb-3"><label class="form-label">Site Tagline</label><input name="site_tagline" class="form-control" value="{{ old('site_tagline', $settings['site_tagline']) }}"></div>
    <div class="mb-3"><label class="form-label">Contact Email</label><input name="contact_email" type="email" class="form-control" value="{{ old('contact_email', $settings['contact_email']) }}"></div>
    <div class="mb-3"><label class="form-label">Registration Enabled</label>
        <select name="registration_enabled" class="form-select"><option value="1" @selected($settings['registration_enabled']=='1')>Yes</option><option value="0" @selected($settings['registration_enabled']=='0')>No</option></select>
    </div>
    <button class="btn btn-primary">Save Settings</button>
</form>
</div></div>
@endsection
