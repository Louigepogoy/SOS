@extends('layouts.app')
@section('page-title', 'Announcements')
@section('content')
@forelse($announcements as $item)
    <div class="card card-stat mb-3">
        <div class="card-body">
            <h5>{{ $item->title }}</h5>
            <small class="text-muted">{{ $item->organization->name }} · {{ $item->created_at->diffForHumans() }}</small>
            <p class="mt-2 mb-0">{{ $item->content }}</p>
        </div>
    </div>
@empty
    <p class="text-muted">No announcements.</p>
@endforelse
{{ $announcements->links() }}
@endsection
