@extends('layouts.app')
@section('page-title', 'Edit Event')
@section('content')
@include('officer.events._form', ['action' => route('officer.events.update', $event), 'event' => $event, 'method' => 'PUT'])
@endsection
