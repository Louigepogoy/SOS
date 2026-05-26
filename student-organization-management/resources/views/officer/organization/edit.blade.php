@extends('layouts.app')
@section('page-title', 'Manage Organization')
@section('content')
<div class="card card-stat"><div class="card-body">
<form action="{{ route('officer.organization.update') }}" method="POST" enctype="multipart/form-data">@csrf @method('PUT')
    <div class="mb-3"><label class="form-label">Name</label><input name="name" class="form-control" value="{{ old('name', $organization->name) }}" required></div>
    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="4">{{ old('description', $organization->description) }}</textarea></div>
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label">Logo</label><input type="file" name="logo" class="form-control" accept="image/*"></div>
        <div class="col-md-6"><label class="form-label">Cover Photo</label><input type="file" name="cover_photo" class="form-control" accept="image/*"></div>
    </div>
    <button class="btn btn-primary mt-3">Save</button>
</form>
</div></div>
@endsection
