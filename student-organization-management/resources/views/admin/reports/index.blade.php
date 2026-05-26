@extends('layouts.app')
@section('page-title', 'System Reports')
@section('content')
<div class="row g-4">
    <div class="col-md-6"><div class="card card-stat p-3"><h6>Users by Role</h6>
        <ul class="list-group list-group-flush">@foreach($reports['users_by_role'] as $role => $count)<li class="list-group-item d-flex justify-content-between"><span>{{ ucfirst(str_replace('_',' ',$role)) }}</span><span class="badge bg-primary">{{ $count }}</span></li>@endforeach</ul>
    </div></div>
    <div class="col-md-6"><div class="card card-stat p-3"><h6>Organizations by Status</h6>
        <ul class="list-group list-group-flush">@foreach($reports['orgs_by_status'] as $status => $count)<li class="list-group-item d-flex justify-content-between"><span>{{ ucfirst($status) }}</span><span class="badge bg-primary">{{ $count }}</span></li>@endforeach</ul>
    </div></div>
</div>
@endsection
