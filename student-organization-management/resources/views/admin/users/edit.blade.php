@extends('layouts.app')
@section('page-title', 'Edit User')
@section('content')
@include('admin.users._form', ['user' => $user, 'action' => route('admin.users.update', $user), 'method' => 'PUT'])
@endsection
