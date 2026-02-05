@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
    <section>
        <div class="container">
            <!-- Success/Error Messages -->
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                                <div class="flex-grow-1">{{ session('success') }}</div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-exclamation-circle-fill me-3 fs-4"></i>
                                <div class="flex-grow-1">{{ session('error') }}</div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Header -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-2">
                        <div>
                            <h1 class="fw-bold mb-2" style="color: #2c3e50;">My Profile</h1>
                            <p class="text-muted mb-0">Manage your account information and preferences</p>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-outline-primary px-4 py-2 rounded-pill shadow-sm" id="editProfileBtn">
                                <i class="bi bi-pencil-square me-2"></i>Edit Profile
                            </button>
                            <button type="button" class="btn btn-outline-danger px-4 py-2 rounded-pill shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#changePasswordModal">
                                <i class="bi bi-key me-2"></i>Change Password
                            </button>
                        </div>
                    </div>

                    <div class="row g-4">
                        <!-- Left Column - Profile Overview -->
                        <div class="col-lg-4">
                            <!-- Profile Card -->
                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                                <div class="card-header bg-white border-0 py-4">
                                    <h5 class="mb-0 d-flex align-items-center">
                                        <i class="bi bi-person-circle text-primary me-3 fs-4"></i>
                                        <span style="color: #2c3e50;">Profile Overview</span>
                                    </h5>
                                </div>
                                <div class="card-body p-4 text-center">
                                    <!-- Profile Avatar with Edit Option -->
                                    <div class="position-relative d-inline-block mb-4">
                                        <div id="avatarContainer" class="mx-auto">
                                            @if ($user->avatar)
                                                <img src="{{ asset('storage/avatars/' . $user->avatar) }}"
                                                    class="avatar-lg rounded-circle shadow border border-3 border-white"
                                                    alt="{{ $user->name }}"
                                                    id="avatarImage">
                                            @else
                                                <div class="avatar-lg bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center text-white shadow"
                                                    id="avatarInitials"
                                                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                    <span class="display-5 fw-bold">{{ substr($user->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button"
                                            class="btn btn-sm btn-white shadow-sm position-absolute bottom-0 end-0 rounded-circle"
                                            id="changeAvatarBtn" data-bs-toggle="modal" data-bs-target="#avatarModal"
                                            style="width: 40px; height: 40px;">
                                            <i class="bi bi-camera fs-6"></i>
                                        </button>
                                        @if ($user->email_verified_at)
                                            <span class="position-absolute top-0 end-0 bg-success text-white rounded-circle p-1 shadow-sm"
                                                data-bs-toggle="tooltip" title="Verified Account" style="width: 30px; height: 30px;">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </span>
                                        @endif
                                    </div>

                                    <h4 class="fw-bold mb-2" id="displayName" style="color: #2c3e50;">{{ $user->name }}</h4>
                                    <p class="text-muted mb-4">
                                        <span class="badge bg-primary bg-opacity-10 text-primary py-2 px-3 rounded-pill">
                                            <i class="bi bi-person-badge me-1"></i>
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </p>

                                    <!-- Email Verification Status -->
                                    @if (!$user->email_verified_at)
                                        <div class="alert alert-warning py-3 small rounded-3 mb-4 border-0 shadow-sm">
                                            <div class="d-flex align-items-start">
                                                <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                                                <div>
                                                    <strong>Email not verified</strong>
                                                    <p class="mb-2">Please verify your email address to access all features.</p>
                                                    <form action="{{ route('verification.resend') }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-warning rounded-pill">
                                                            Resend verification email
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Stats -->
                                    <div class="border-top pt-4">
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <div class="text-muted small mb-1">Member Since</div>
                                                    <div class="fw-bold">{{ $user->created_at->format('M Y') }}</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <div class="text-muted small mb-1">Last Updated</div>
                                                    <div class="fw-bold">{{ $user->updated_at->format('d M Y') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center mt-3">
                                            <span class="text-muted small">Account ID:</span>
                                            <span class="badge bg-light text-dark ms-2">#{{ $user->id }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Detailed Information with Inline Edit -->
                        <div class="col-lg-8">
                            <!-- Personal Information Card -->
                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                                <div class="card-header bg-white border-0 py-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 d-flex align-items-center">
                                            <i class="bi bi-person-lines-fill text-primary me-3 fs-5"></i>
                                            <span style="color: #2c3e50;">Personal Information</span>
                                        </h5>
                                        <span class="badge bg-primary bg-opacity-10 text-primary py-2 px-3 rounded-pill">
                                            <i class="bi bi-shield-check me-1"></i>
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <!-- View Mode -->
                                    <div id="viewMode">
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <div class="p-3 rounded-3 border" style="background: #f8f9fa;">
                                                    <label class="form-label text-muted small mb-2">Full Name</label>
                                                    <div class="fw-semibold fs-5" style="color: #2c3e50;">{{ $user->name }}</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="p-3 rounded-3 border" style="background: #f8f9fa;">
                                                    <label class="form-label text-muted small mb-2">Email Address</label>
                                                    <div class="d-flex align-items-center">
                                                        <div class="fw-semibold fs-5 me-3" style="color: #2c3e50;">{{ $user->email }}</div>
                                                        {{-- @if ($user->email_verified_at)
                                                            <span class="badge bg-success py-1 px-2 rounded-pill">
                                                                <i class="bi bi-check-circle me-1"></i>Verified
                                                            </span>
                                                        @else
                                                            <span class="badge bg-warning py-1 px-2 rounded-pill">
                                                                <i class="bi bi-exclamation-triangle me-1"></i>Not Verified
                                                            </span>
                                                        @endif --}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="p-3 rounded-3 border" style="background: #f8f9fa;">
                                                    <label class="form-label text-muted small mb-2">Phone Number</label>
                                                    <div class="fw-semibold fs-5" style="color: #2c3e50;">
                                                        {{ $user->phone ?? '<span class="text-muted fst-italic">Not provided</span>' }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="p-3 rounded-3 border" style="background: #f8f9fa;">
                                                    <label class="form-label text-muted small mb-2">Account Status</label>
                                                    <div>
                                                        <span class="badge bg-success py-2 px-3 rounded-pill">
                                                            <i class="bi bi-check-circle me-1"></i>Active
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit Mode (Hidden by default) -->
                                    <form id="editForm" action="{{ route('profile.update') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('POST')

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="editName" class="form-label fw-medium">Full Name *</label>
                                                <input type="text"
                                                    class="form-control form-control-lg rounded-3 @error('name') is-invalid @enderror"
                                                    id="editName" name="name" value="{{ old('name', $user->name) }}"
                                                    required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-medium">Email Address</label>
                                                <input type="email" class="form-control form-control-lg rounded-3 bg-light" 
                                                    value="{{ $user->email }}" readonly disabled>
                                                <div class="form-text mt-1">
                                                    <i class="bi bi-info-circle me-1"></i>Email cannot be changed
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="editPhone" class="form-label fw-medium">Phone Number</label>
                                                <input type="tel"
                                                    class="form-control form-control-lg rounded-3 @error('phone') is-invalid @enderror"
                                                    id="editPhone" name="phone"
                                                    value="{{ old('phone', $user->phone) }}"
                                                    placeholder="+1 (123) 456-7890">
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-medium">Role</label>
                                                <input type="text" class="form-control form-control-lg rounded-3 bg-light"
                                                    value="{{ ucfirst($user->role) }}" readonly disabled>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
                                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4 py-2" id="cancelEditBtn">
                                                <i class="bi bi-x-circle me-2"></i>Cancel
                                            </button>
                                            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                                                <i class="bi bi-save me-2"></i>Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Contact Details Card -->
                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                                <div class="card-header bg-white border-0 py-4">
                                    <h5 class="mb-0 d-flex align-items-center">
                                        <i class="bi bi-telephone-fill text-primary me-3 fs-5"></i>
                                        <span style="color: #2c3e50;">Contact Details</span>
                                    </h5>
                                </div>
                                <div class="card-body p-4">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="p-3 rounded-3 border" style="background: #f8f9fa;">
                                                <label class="form-label text-muted small mb-2">Email</label>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-envelope-fill text-primary me-3 fs-5"></i>
                                                    <div>
                                                        <a href="mailto:{{ $user->email }}" 
                                                           class="text-decoration-none fw-medium" style="color: #2c3e50;">
                                                            {{ $user->email }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($user->phone)
                                            <div class="col-md-6">
                                                <div class="p-3 rounded-3 border" style="background: #f8f9fa;">
                                                    <label class="form-label text-muted small mb-2">Phone</label>
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-telephone-fill text-primary me-3 fs-5"></i>
                                                        <div>
                                                            <a href="tel:{{ $user->phone }}" 
                                                               class="text-decoration-none fw-medium" style="color: #2c3e50;">
                                                                {{ $user->phone }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Order Details Card -->
                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                                <div class="card-body p-4">
                                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-4">
                                        <div class="d-flex align-items-center gap-4">
                                            <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                                                <i class="bi bi-receipt text-primary fs-2"></i>
                                            </div>
                                            <div>
                                                <h3 class="h4 fw-bold mb-1" style="color: #2c3e50;">Order Details</h3>
                                                <p class="text-muted mb-0">View and manage order information</p>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary px-4 py-3 rounded-pill shadow-sm"
                                            onclick="window.location='{{ route('orders') }}'">
                                            <i class="bi bi-arrow-left me-2"></i>Back to Orders
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title fw-bold" id="changePasswordModalLabel" style="color: #2c3e50;">
                            <i class="bi bi-key-fill text-primary me-2"></i>Change Password
                        </h5>
                        <p class="text-muted small mb-0">Update your account password</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('profile.password.update') }}" method="POST" id="passwordForm">
                    @csrf
                    @method('POST')
                    <div class="modal-body py-4">
                        <div class="mb-4">
                            <label for="current_password" class="form-label fw-medium">Current Password *</label>
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg rounded-3 @error('current_password') is-invalid @enderror"
                                    id="current_password" name="current_password" required>
                                <button class="btn btn-outline-secondary rounded-end-3" type="button" id="toggleCurrentPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="new_password" class="form-label fw-medium">New Password *</label>
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg rounded-3 @error('new_password') is-invalid @enderror"
                                    id="new_password" name="new_password" required>
                                <button class="btn btn-outline-secondary rounded-end-3" type="button" id="toggleNewPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('new_password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="form-text mt-2">
                                <i class="bi bi-info-circle me-1"></i>Password must be at least 6 characters long.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label fw-medium">Confirm New Password *</label>
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg rounded-3" id="new_password_confirmation"
                                    name="new_password_confirmation" required>
                                <button class="btn btn-outline-secondary rounded-end-3" type="button" id="toggleConfirmPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                            <i class="bi bi-check-circle me-2"></i>Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Avatar Upload Modal -->
    <div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title fw-bold" id="avatarModalLabel" style="color: #2c3e50;">
                            <i class="bi bi-camera-fill text-primary me-2"></i>Change Profile Picture
                        </h5>
                        <p class="text-muted small mb-0">Upload a new profile picture</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data"
                    id="avatarForm">
                    @csrf
                    @method('POST')
                    <div class="modal-body py-4">
                        <div class="text-center mb-4">
                            <div id="avatarPreview"
                                class="rounded-circle mx-auto d-flex align-items-center justify-content-center overflow-hidden border-3 border-dashed border-primary bg-light"
                                style="width: 180px; height: 180px; cursor: pointer;">
                                <i class="bi bi-person-circle text-muted" style="font-size: 5rem;"></i>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="avatarInput" class="form-label fw-medium">Choose Image</label>
                            <input type="file" class="form-control form-control-lg rounded-3 @error('avatar') is-invalid @enderror"
                                id="avatarInput" name="avatar" accept="image/*">
                            <div class="form-text mt-2">
                                <i class="bi bi-info-circle me-1"></i>Max file size: 2MB. Allowed: JPG, PNG, GIF
                            </div>
                            @error('avatar')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        @if ($user->avatar)
                            <button type="button" class="btn btn-outline-danger rounded-pill px-4 me-auto" id="removeAvatarBtn">
                                <i class="bi bi-trash me-2"></i>Remove Picture
                            </button>
                        @endif
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                            <i class="bi bi-upload me-2"></i>Save Picture
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .avatar-lg {
            width: 140px;
            height: 140px;
            object-fit: cover;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
        }

        .badge {
            font-weight: 500;
        }

        .form-control-plaintext {
            padding: 0.375rem 0;
            min-height: 38px;
            border-bottom: 1px solid transparent;
        }

        .form-control-plaintext:hover {
            background-color: rgba(0, 0, 0, .02);
        }

        #avatarPreview {
            transition: all 0.3s ease;
        }

        #avatarPreview:hover {
            border-color: #667eea !important;
            border-style: solid !important;
        }

        .border-dashed {
            border-style: dashed !important;
        }

        /* Gradient text for initials */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .avatar-lg {
                width: 100px;
                height: 100px;
            }
            
            .display-5 {
                font-size: 2rem;
            }
            
            .card-header h5, .modal-title {
                font-size: 1.1rem;
            }
            
            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .avatar-lg {
                width: 80px;
                height: 80px;
            }
            
            .display-5 {
                font-size: 1.5rem;
            }
            
            .card-body {
                padding: 1rem !important;
            }
            
            .modal-dialog {
                margin: 0.5rem;
            }
        }

        /* Custom checkbox styling */
        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        /* Input focus effects */
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        /* Smooth transitions */
        * {
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Toggle between view and edit modes
            const editProfileBtn = document.getElementById('editProfileBtn');
            const cancelEditBtn = document.getElementById('cancelEditBtn');
            const viewMode = document.getElementById('viewMode');
            const editForm = document.getElementById('editForm');

            if (editProfileBtn) {
                editProfileBtn.addEventListener('click', function() {
                    viewMode.style.display = 'none';
                    editForm.style.display = 'block';
                    editProfileBtn.style.display = 'none';
                    
                    // Add animation
                    editForm.style.opacity = '0';
                    editForm.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        editForm.style.transition = 'all 0.3s ease';
                        editForm.style.opacity = '1';
                        editForm.style.transform = 'translateY(0)';
                    }, 10);
                });
            }

            if (cancelEditBtn) {
                cancelEditBtn.addEventListener('click', function() {
                    viewMode.style.display = 'block';
                    editForm.style.display = 'none';
                    editProfileBtn.style.display = 'block';
                    
                    // Add animation
                    viewMode.style.opacity = '0';
                    viewMode.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        viewMode.style.transition = 'all 0.3s ease';
                        viewMode.style.opacity = '1';
                        viewMode.style.transform = 'translateY(0)';
                    }, 10);
                });
            }

            // Avatar preview functionality
            const avatarInput = document.getElementById('avatarInput');
            const avatarPreview = document.getElementById('avatarPreview');
            const avatarForm = document.getElementById('avatarForm');

            // Click on preview to trigger file input
            if (avatarPreview) {
                avatarPreview.addEventListener('click', function() {
                    avatarInput.click();
                });
            }

            if (avatarInput) {
                avatarInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        // Validate file size
                        if (file.size > 2 * 1024 * 1024) { // 2MB
                            showAlert('File size must be less than 2MB', 'error');
                            this.value = '';
                            return;
                        }

                        // Validate file type
                        const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                        if (!validTypes.includes(file.type)) {
                            showAlert('Only JPG, PNG, and GIF files are allowed', 'error');
                            this.value = '';
                            return;
                        }

                        const reader = new FileReader();
                        reader.onload = function(e) {
                            avatarPreview.innerHTML =
                                `<img src="${e.target.result}" class="w-100 h-100" style="object-fit: cover;">`;
                            avatarPreview.classList.remove('border-dashed');
                            avatarPreview.style.border = '3px solid #28a745';
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Avatar modal form submission with AJAX
            if (avatarForm) {
                avatarForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    
                    // Show loading state
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Uploading...';
                    submitBtn.disabled = true;

                    fetch(this.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update avatar display
                                const avatarContainer = document.getElementById('avatarContainer');
                                if (data.avatar) {
                                    avatarContainer.innerHTML =
                                        `<img src="${data.avatar}" class="avatar-lg rounded-circle shadow border border-3 border-white" 
                                         id="avatarImage" alt="${data.name}">`;
                                } else {
                                    avatarContainer.innerHTML =
                                        `<div class="avatar-lg bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center text-white shadow"
                                            id="avatarInitials">
                                            <span class="display-5 fw-bold">${data.initials}</span>
                                        </div>`;
                                }

                                // Update display name if changed
                                if (data.name) {
                                    document.getElementById('displayName').textContent = data.name;
                                }

                                // Close modal
                                const modal = bootstrap.Modal.getInstance(document.getElementById('avatarModal'));
                                modal.hide();

                                // Reset form
                                avatarForm.reset();
                                avatarPreview.innerHTML = '<i class="bi bi-person-circle text-muted" style="font-size: 5rem;"></i>';
                                avatarPreview.classList.add('border-dashed');
                                avatarPreview.style.borderColor = '';

                                // Show success message
                                showAlert('Profile picture updated successfully!', 'success');
                            } else {
                                showAlert(data.message || 'Something went wrong', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showAlert('Failed to upload image', 'error');
                        })
                        .finally(() => {
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                        });
                });
            }

            // Remove avatar functionality
            const removeAvatarBtn = document.getElementById('removeAvatarBtn');
            if (removeAvatarBtn) {
                removeAvatarBtn.addEventListener('click', function() {
                    if (confirm('Are you sure you want to remove your profile picture?')) {
                        const btn = this;
                        const originalText = btn.innerHTML;
                        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Removing...';
                        btn.disabled = true;

                        fetch('{{ route('profile.avatar.remove') }}', {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Update avatar display
                                    document.getElementById('avatarContainer').innerHTML =
                                        `<div class="avatar-lg bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center text-white shadow"
                                            id="avatarInitials">
                                            <span class="display-5 fw-bold">${data.initials}</span>
                                        </div>`;

                                    // Close modal
                                    const modal = bootstrap.Modal.getInstance(document.getElementById('avatarModal'));
                                    modal.hide();

                                    // Reset form
                                    if (avatarForm) {
                                        avatarForm.reset();
                                        avatarPreview.innerHTML = '<i class="bi bi-person-circle text-muted" style="font-size: 5rem;"></i>';
                                        avatarPreview.classList.add('border-dashed');
                                        avatarPreview.style.borderColor = '';
                                    }

                                    // Show success message
                                    showAlert('Profile picture removed successfully!', 'success');
                                } else {
                                    showAlert(data.message || 'Something went wrong', 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showAlert('Failed to remove picture', 'error');
                            })
                            .finally(() => {
                                btn.innerHTML = originalText;
                                btn.disabled = false;
                            });
                    }
                });
            }

            // Password toggle visibility
            const toggleCurrentPassword = document.getElementById('toggleCurrentPassword');
            const toggleNewPassword = document.getElementById('toggleNewPassword');
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');

            function togglePasswordVisibility(inputId, button) {
                const input = document.getElementById(inputId);
                if (input.type === 'password') {
                    input.type = 'text';
                    button.innerHTML = '<i class="bi bi-eye-slash"></i>';
                } else {
                    input.type = 'password';
                    button.innerHTML = '<i class="bi bi-eye"></i>';
                }
            }

            if (toggleCurrentPassword) {
                toggleCurrentPassword.addEventListener('click', function() {
                    togglePasswordVisibility('current_password', this);
                });
            }

            if (toggleNewPassword) {
                toggleNewPassword.addEventListener('click', function() {
                    togglePasswordVisibility('new_password', this);
                });
            }

            if (toggleConfirmPassword) {
                toggleConfirmPassword.addEventListener('click', function() {
                    togglePasswordVisibility('new_password_confirmation', this);
                });
            }

            // Password form validation
            const passwordForm = document.getElementById('passwordForm');
            if (passwordForm) {
                passwordForm.addEventListener('submit', function(e) {
                    const newPassword = document.getElementById('new_password').value;
                    const confirmPassword = document.getElementById('new_password_confirmation').value;
                    const currentPassword = document.getElementById('current_password').value;

                    let isValid = true;
                    let errorMessage = '';

                    if (newPassword.length < 6) {
                        isValid = false;
                        errorMessage = 'Password must be at least 6 characters long.';
                    } else if (newPassword !== confirmPassword) {
                        isValid = false;
                        errorMessage = 'New password and confirmation do not match.';
                    }

                    if (!isValid) {
                        e.preventDefault();
                        showAlert(errorMessage, 'error');
                    }
                });
            }

            // Helper function to show alerts
            function showAlert(message, type = 'success') {
                // Remove existing alerts
                const existingAlerts = document.querySelectorAll('.custom-alert');
                existingAlerts.forEach(alert => alert.remove());

                const alertDiv = document.createElement('div');
                alertDiv.className = `custom-alert alert alert-${type} alert-dismissible fade show shadow-sm rounded-3 position-fixed`;
                alertDiv.style.top = '20px';
                alertDiv.style.right = '20px';
                alertDiv.style.zIndex = '9999';
                alertDiv.style.minWidth = '300px';
                alertDiv.style.maxWidth = '400px';

                const icon = type === 'success' ? 'bi-check-circle-fill' : 
                            type === 'error' ? 'bi-exclamation-circle-fill' : 
                            'bi-info-circle-fill';

                alertDiv.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="bi ${icon} me-3 fs-4"></i>
                        <div class="flex-grow-1">${message}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;

                document.body.appendChild(alertDiv);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 5000);
            }

            // Auto-hide alerts after 5 seconds
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert:not(.custom-alert)');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Add smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Mobile menu improvements
            const navbarToggler = document.querySelector('.navbar-toggler');
            if (navbarToggler) {
                navbarToggler.addEventListener('click', function() {
                    document.body.classList.toggle('navbar-open');
                });
            }
        });
    </script>
@endpush

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">