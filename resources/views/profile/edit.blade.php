@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Edit Profile</h2>

    {{-- Update Profile Information --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">Profile Information</h5>
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    {{-- Update Password --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">Change Password</h5>
            @include('profile.partials.update-password-form')
        </div>
    </div>

    {{-- Delete Account --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3 text-danger">Delete Account</h5>
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
