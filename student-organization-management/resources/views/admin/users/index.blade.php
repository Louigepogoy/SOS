@extends('layouts.app')
@section('page-title', 'Manage Users')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <div class="btn-group">
        @foreach(['student','officer','super_admin'] as $r)
            <a href="{{ route('admin.users.index', ['role' => $r]) }}" class="btn btn-{{ $role === $r ? 'primary' : 'outline-primary' }}">{{ ucfirst(str_replace('_',' ',$r)) }}</a>
        @endforeach
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add User</a>
</div>
<div class="card card-stat"><div class="table-responsive"><table class="table mb-0">
<thead><tr><th>Name</th><th>Email</th><th>Status</th><th>Actions</th></tr></thead>
<tbody>
@foreach($users as $user)
<tr>
    <td>{{ $user->name }}</td><td>{{ $user->email }}</td>
    <td><span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span></td>
    <td>
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Edit</a>
        <form class="d-inline" method="POST" action="{{ route('admin.users.toggle', $user) }}">@csrf
            <button class="btn btn-sm btn-outline-warning">{{ $user->is_active ? 'Deactivate' : 'Activate' }}</button>
        </form>
    </td>
</tr>
@endforeach
</tbody></table></div></div>
{{ $users->withQueryString()->links() }}
@endsection
