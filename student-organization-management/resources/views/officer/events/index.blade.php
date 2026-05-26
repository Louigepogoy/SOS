@extends('layouts.app')
@section('page-title', 'Events')
@section('content')
<a href="{{ route('officer.events.create') }}" class="btn btn-primary mb-3">Create Event</a>
@foreach($events as $event)
<div class="card card-stat mb-2"><div class="card-body d-flex justify-content-between">
    <div><h5 class="mb-1">{{ $event->title }}</h5><small>{{ $event->starts_at->format('M d, Y h:i A') }}</small></div>
    <div>
        <a href="{{ route('officer.events.edit', $event) }}" class="btn btn-sm btn-outline-primary">Edit</a>
        <form class="d-inline" method="POST" action="{{ route('officer.events.destroy', $event) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form>
    </div>
</div></div>
@endforeach
{{ $events->links() }}
@endsection
