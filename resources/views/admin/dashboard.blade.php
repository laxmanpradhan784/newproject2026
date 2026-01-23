@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid py-4">
    <!-- Dashboard Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </h1>
                <div class="btn-group">
                    <button class="btn btn-outline-primary">
                        <i class="bi bi-calendar-week"></i> {{ now()->format('F d, Y') }}
                    </button>
                </div>
            </div>
            <p class="text-muted">Welcome back, Administrator! Here's what's happening with your store.</p>
        </div>
    </div>
</div>
@endsection