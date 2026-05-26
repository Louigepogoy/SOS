@extends('layouts.app')
@section('page-title', 'Announcements')
@section('content')
<a href="{{ route('officer.announcements.create') }}" class="btn btn-primary mb-3">Post Announcement</a>
@foreach($announcements as $a)
<div class="card card-stat mb-2"><div class="card-body d-flex justify-content-between">
    <div><h5>{{ $a->title }}</h5><p class="mb-0 small">{{ Str::limit($a->content, 100) }}</p></div>
    <form method="POST" action="{{ route('officer.announcements.destroy', $a) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form>
</div></div>
@endforeach
{{ $announcements->links() }}
@endsection
