@extends('layouts.app')
@section('page-title', 'Reports')
@section('content')
<div class="row g-4 mb-4">
    @foreach($stats as $label => $value)
    <div class="col-md-3"><div class="card card-stat p-3 text-center"><h4>{{ $value }}</h4><small class="text-muted text-capitalize">{{ str_replace('_', ' ', $label) }}</small></div></div>
    @endforeach
</div>
<a href="{{ route('officer.reports.export') }}" class="btn btn-primary"><i class="bi bi-download"></i> Export Members CSV</a>
@endsection
