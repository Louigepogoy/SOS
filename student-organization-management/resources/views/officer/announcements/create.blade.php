@extends('layouts.app')
@section('page-title', 'Post Announcement')
@section('content')
<div class="card card-stat"><div class="card-body">
<form method="POST" action="{{ route('officer.announcements.store') }}">@csrf
    <div class="mb-3"><label class="form-label">Title</label><input name="title" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">Content</label><textarea name="content" class="form-control" rows="5" required></textarea></div>
    <button class="btn btn-primary">Post</button>
</form>
</div></div>
@endsection
