@extends('layouts.app')
@section('page-title', 'Events')
@section('content')
<div class="row g-4">
    @forelse($events as $event)
        <div class="col-md-6">
            <div class="card card-stat h-100 p-3">
                <h5>{{ $event->title }}</h5>
                <p class="text-muted small mb-1">{{ $event->organization->name }}</p>
                <p class="mb-1"><i class="bi bi-calendar"></i> {{ $event->starts_at->format('M d, Y h:i A') }}</p>
                @if($event->location)<p class="mb-0"><i class="bi bi-geo-alt"></i> {{ $event->location }}</p>@endif
                <p class="mt-2 small">{{ Str::limit($event->description, 120) }}</p>
            </div>
        </div>
    @empty
        <p class="text-muted">No events from your organizations.</p>
    @endforelse
</div>
{{ $events->links() }}
@endsection
