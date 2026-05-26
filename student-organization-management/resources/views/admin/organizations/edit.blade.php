@extends('layouts.app')
@section('page-title', 'Edit Organization')
@section('content')
@include('admin.organizations._form', ['organization' => $organization, 'officers' => $officers, 'action' => route('admin.organizations.update', $organization), 'method' => 'PUT'])
@endsection
