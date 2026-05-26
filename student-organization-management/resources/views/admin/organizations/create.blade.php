@extends('layouts.app')
@section('page-title', 'Create Organization')
@section('content')
@include('admin.organizations._form', ['organization' => null, 'officers' => $officers, 'action' => route('admin.organizations.store')])
@endsection
