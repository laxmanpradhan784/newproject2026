@extends('layouts.app')

@section('title','My Profile')

@section('content')
<section class="py-5">
    <div class="container">
        <h3 class="mb-4">My Profile</h3>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Profile Details</h5>
                    </div>
                    <div class="card-body">
                        @if($user)
                            <p><strong>Name:</strong> {{ $user->name }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
                            <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                            <p><strong>Email Verified At:</strong> {{ $user->email_verified_at ?? 'Not verified' }}</p>
                            <p><strong>Created At:</strong> {{ $user->created_at->format('d M Y, h:i A') }}</p>
                            <p><strong>Last Updated:</strong> {{ $user->updated_at->format('d M Y, h:i A') }}</p>
                        @else
                            <p>User not found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
