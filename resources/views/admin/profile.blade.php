@extends('admin.layouts.app')

@section('title', 'Admin Profile')

@section('content')
<div class="container-fluid py-4">
    <!-- Profile Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">
                    <i class="bi bi-person-badge me-2"></i>Admin Profile
                </h1>
                <div class="btn-group">
                    <a href="#" class="btn btn-outline-primary">
                        <i class="bi bi-pencil-square me-1"></i> Edit Profile
                    </a>
                    <a href="#" class="btn btn-outline-secondary">
                        <i class="bi bi-shield-lock me-1"></i> Security
                    </a>
                </div>
            </div>
            <p class="text-muted mb-0">View and manage your administrator account details</p>
        </div>
    </div>

    <div class="row">
        <!-- Left Column: Profile Card -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <!-- Profile Avatar -->
                    <div class="text-center mb-4">
                        <div class="avatar-profile mx-auto mb-3">
                            <div class="avatar-initials bg-primary text-white">
                                {{ substr($admin->name, 0, 2) }}
                            </div>
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <h4 class="mb-1">{{ $admin->name }}</h4>
                        <p class="text-muted mb-2">
                            <i class="bi bi-shield-check me-1"></i>
                            {{ $admin->role }}
                        </p>
                        <span class="badge bg-light text-dark border">
                            <i class="bi bi-person me-1"></i>
                            ID: {{ $admin->id }}
                        </span>
                    </div>

                    <!-- Quick Stats -->
                    <div class="row text-center mb-4">
                        <div class="col-4">
                            <div class="stat-number">152</div>
                            <div class="stat-label">Products</div>
                        </div>
                        <div class="col-4">
                            <div class="stat-number">42</div>
                            <div class="stat-label">Orders</div>
                        </div>
                        <div class="col-4">
                            <div class="stat-number">89</div>
                            <div class="stat-label">Users</div>
                        </div>
                    </div>

                    <!-- Account Status -->
                    <div class="alert alert-success d-flex align-items-center mb-0">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div>
                            <strong>Account Active</strong>
                            <div class="small">Last login: Today, 10:30 AM</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Quick Actions</h6>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-key me-1"></i> Change Password
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-bell me-1"></i> Notification Settings
                        </a>
                        <a href="#" class="btn btn-outline-info btn-sm">
                            <i class="bi bi-gear me-1"></i> Account Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Details -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Profile Information</h6>
                </div>
                <div class="card-body p-4">
                    <!-- Personal Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="bi bi-person me-2"></i>Personal Information
                            </h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small mb-1">Full Name</label>
                            <div class="profile-field">
                                <i class="bi bi-person-circle me-2"></i>
                                {{ $admin->name }}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small mb-1">Admin ID</label>
                            <div class="profile-field">
                                <i class="bi bi-credit-card me-2"></i>
                                ADMIN-{{ str_pad($admin->id, 4, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small mb-1">Email Address</label>
                            <div class="profile-field">
                                <i class="bi bi-envelope me-2"></i>
                                {{ $admin->email }}
                                <span class="badge bg-success ms-2">Verified</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small mb-1">Phone Number</label>
                            <div class="profile-field">
                                <i class="bi bi-telephone me-2"></i>
                                {{ $admin->phone ?? 'Not provided' }}
                            </div>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="bi bi-shield me-2"></i>Account Information
                            </h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small mb-1">User Role</label>
                            <div class="profile-field">
                                <i class="bi bi-shield-check me-2"></i>
                                <span class="badge bg-primary">{{ $admin->role }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small mb-1">Account Status</label>
                            <div class="profile-field">
                                <i class="bi bi-circle-fill me-2 text-success"></i>
                                Active
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small mb-1">Member Since</label>
                            <div class="profile-field">
                                <i class="bi bi-calendar me-2"></i>
                                {{ $admin->created_at->format('d M Y') }}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small mb-1">Account Age</label>
                            <div class="profile-field">
                                <i class="bi bi-clock-history me-2"></i>
                                {{ $admin->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-outline-danger">
                            <i class="bi bi-trash me-1"></i> Delete Account
                        </button>
                        <div class="btn-group">
                            <button class="btn btn-outline-secondary">
                                <i class="bi bi-printer me-1"></i> Print
                            </button>
                            <button class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Profile Styles */
    .avatar-profile {
        position: relative;
        width: 100px;
        margin: 0 auto;
    }

    .avatar-initials {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: bold;
        border: 4px solid white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .status-indicator {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 3px solid white;
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: bold;
        color: #4361ee;
    }

    .stat-label {
        font-size: 0.8rem;
        color: #6c757d;
    }

    .profile-field {
        padding: 10px 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        display: flex;
        align-items: center;
    }

    .card {
        border-radius: 12px;
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .border-bottom {
        border-color: #e9ecef !important;
    }

    h6 {
        color: #495057;
        font-weight: 600;
    }

    .profile-field i {
        color: #4361ee;
        width: 20px;
    }

    @media (max-width: 768px) {
        .avatar-initials {
            width: 80px;
            height: 80px;
            font-size: 1.5rem;
        }
        
        .btn-group {
            flex-wrap: wrap;
        }
    }
</style>
@endsection