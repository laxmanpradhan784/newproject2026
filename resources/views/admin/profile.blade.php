@extends('admin.layouts.app') <!-- your admin layout -->

@section('title', 'Admin Profile')

@section('content')
<div class="container mt-5">
    <h2>Admin Profile</h2>
    <div class="card p-3">
        <p><strong>ID:</strong> {{ $admin->id }}</p>
        <p><strong>Name:</strong> {{ $admin->name }}</p>
        <p><strong>Email:</strong> {{ $admin->email }}</p>
        <p><strong>Phone:</strong> {{ $admin->phone ?? 'N/A' }}</p>
        <p><strong>Role:</strong> {{ $admin->role }}</p>
        <p><strong>Registered At:</strong> {{ $admin->created_at->format('d M Y') }}</p>
    </div>
</div>
@endsection
