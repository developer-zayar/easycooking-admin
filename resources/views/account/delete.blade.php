@extends('layouts.app')

@section('title', 'Delete Account')

@section('content')
    <div class="container py-5">
        <h1>Request Account Deletion</h1>

        <form method="POST" action="{{ route('account.delete.submit') }}">
            @csrf
            <div class="mb-3">
                <p>Are you sure you want to delete your account?</p>
            </div>

            <div class="mb-3">
                <label for="reason" class="form-label">Reason for deletion (optional)</label>
                <textarea id="reason" name="reason" class="form-control" rows="4"
                    placeholder="Tell us why you want to delete your account...">{{ old('reason') }}</textarea>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="confirm" id="confirm" required>
                <label class="form-check-label" for="confirm">
                    I confirm I want to delete my account.
                </label>
            </div>

            <button type="submit" class="btn btn-danger">Request Account Deletion</button>
        </form>
    </div>
@endsection
