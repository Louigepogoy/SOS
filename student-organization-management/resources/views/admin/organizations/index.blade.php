@extends('layouts.app')
@section('page-title', 'Organizations')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('admin.organizations.create') }}" class="btn btn-primary">Add Organization</a>
</div>
@foreach($organizations as $org)
<div class="card card-stat mb-2"><div class="card-body d-flex justify-content-between align-items-center">
    <div><h5 class="mb-0">{{ $org->name }}</h5><small class="text-muted">Officer: {{ $org->officer?->name ?? 'None' }} · <span class="badge bg-secondary">{{ $org->status }}</span></small></div>
    <div>
        @if($org->status === 'pending')
            <form class="d-inline" method="POST" action="{{ route('admin.organizations.approve', $org) }}">@csrf<button class="btn btn-sm btn-success">Approve</button></form>
            <form class="d-inline" method="POST" action="{{ route('admin.organizations.reject', $org) }}">@csrf<button class="btn btn-sm btn-danger">Reject</button></form>
        @endif
        <a href="{{ route('admin.organizations.edit', $org) }}" class="btn btn-sm btn-outline-primary">Edit</a>
    </div>
</div></div>
@endforeach
{{ $organizations->links() }}
@endsection
