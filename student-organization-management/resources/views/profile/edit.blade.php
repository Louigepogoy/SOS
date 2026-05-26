@extends('layouts.app')
@section('page-title', 'Edit Profile')
@section('content')
<div class="card card-stat">
    <div class="card-body">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-4 text-center">
                    <img src="{{ $user->avatarUrl() }}" class="rounded-circle mb-3" width="120" height="120" alt="">
                    <input type="file" name="avatar" class="form-control" accept="image/*">
                </div>
                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Name</label><input name="name" class="form-control" value="{{ old('name', $user->name) }}" required></div>
                        <div class="col-md-6"><label class="form-label">Email</label><input name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required></div>
                        <div class="col-md-6"><label class="form-label">Student ID</label><input name="student_id" class="form-control" value="{{ old('student_id', $user->student_id) }}"></div>
                        <div class="col-md-6"><label class="form-label">Phone</label><input name="phone" class="form-control" value="{{ old('phone', $user->phone) }}"></div>
                        <div class="col-md-6"><label class="form-label">Course</label><input name="course" class="form-control" value="{{ old('course', $user->course) }}"></div>
                        <div class="col-md-6"><label class="form-label">Year Level</label><input name="year_level" class="form-control" value="{{ old('year_level', $user->year_level) }}"></div>
                        <div class="col-md-6"><label class="form-label">New Password</label><input name="password" type="password" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Confirm Password</label><input name="password_confirmation" type="password" class="form-control"></div>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary mt-3">Save Changes</button>
        </form>
    </div>
</div>
@endsection
