@extends('layouts.app')
@section('page-title', 'Create Event')
@section('content')
@include('officer.events._form', ['action' => route('officer.events.store'), 'event' => null])
@endsection
