@extends('layouts.app')
@section('page-title', 'Create User')
@section('content')
@include('admin.users._form', ['user' => null, 'action' => route('admin.users.store')])
@endsection
