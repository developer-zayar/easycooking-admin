@extends('layouts.app')
@section('title', 'Account Deletion Request')
@section('content')
    <div class="container py-5">
        {{-- <h1>Account Deletion Request Sent</h1> --}}
        {{-- @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif --}}

        <div class="alert alert-info">
            <h4 class="alert-heading">Account Deletion Request Submitted</h4>
            <p>Your request to delete your account has been received. Our team will review it and take necessary action.</p>

            @if (!empty($deletionReason))
                <hr>
                <p class="mb-0"><strong>Your Reason:</strong> {{ $deletionReason }}</p>
            @endif
        </div>
        <a href="{{ route('home') }}" class="btn btn-primary w-50 d-block mx-auto">Return to Home</a>
    </div>
@endsection
