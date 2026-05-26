@extends('layouts.app')
@section('page-title', 'Review Join Request')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        @include('partials.membership-request-card', ['membership' => $membership])
        <a href="{{ route('officer.memberships.index', ['status' => 'pending']) }}" class="btn btn-outline-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Back to requests
        </a>
    </div>
</div>
@endsection
