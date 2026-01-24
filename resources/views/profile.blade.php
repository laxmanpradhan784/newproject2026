@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<section class="py-5 bg-light">
    <div class="container pt-5">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h3 mb-0">My Profile</h2>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="editProfileBtn">
                            <i class="bi bi-pencil me-2"></i>Edit Profile
                        </button>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="bi bi-key me-2"></i>Change Password
                        </button>
                    </div>
                </div>

                <div class="row">
                    <!-- Left Column - Profile Overview -->
                    <div class="col-md-4 mb-4">
                        <!-- Profile Card -->
                        <div class="card shadow-sm h-20">
                            <div class="card-body text-center p-4">
                                <!-- Profile Avatar with Edit Option -->
                                <div class="position-relative d-inline-block mb-4">
                                    <div id="avatarContainer">
                                        @if($user->avatar)
                                            <img src="{{ asset('storage/avatars/' . $user->avatar) }}" 
                                                 class="avatar-lg rounded-circle" 
                                                 alt="{{ $user->name }}"
                                                 id="avatarImage">
                                        @else
                                            <div class="avatar-lg bg-primary rounded-circle d-flex align-items-center justify-content-center text-white" 
                                                 id="avatarInitials">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary position-absolute bottom-0 end-0 rounded-circle" 
                                            id="changeAvatarBtn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#avatarModal">
                                        <i class="bi bi-camera"></i>
                                    </button>
                                    @if($user->email_verified_at)
                                        <span class="position-absolute top-0 end-0 bg-success text-white rounded-circle p-2" 
                                              data-bs-toggle="tooltip" title="Verified Account">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </span>
                                    @endif
                                </div>
                                
                                <h4 class="mb-2" id="displayName">{{ $user->name }}</h4>
                                <p class="text-muted mb-3">
                                    <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                                </p>
                                
                                <!-- Email Verification Status -->
                                @if(!$user->email_verified_at)
                                    <div class="alert alert-warning py-2 small mb-3">
                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                        Email not verified. 
                                        <form action="{{ route('verification.resend') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-link p-0 text-decoration-none">
                                                Resend verification email
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Stats Card -->
                        <div class="card shadow-sm mt-4">
                            <div class="card-header bg-white">
                                <h6 class="mb-0">Account Info</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Member Since</span>
                                    <span class="fw-semibold">{{ $user->created_at->format('M Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Last Updated</span>
                                    <span class="fw-semibold">{{ $user->updated_at->format('d M Y') }}</span>
                                </div>
                                <hr>
                                <div class="text-center small">
                                    <span class="text-muted">Account ID:</span>
                                    <span class="text-primary">#{{ $user->id }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Detailed Information with Inline Edit -->
                    <div class="col-md-8">
                        <!-- Personal Information Card -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Personal Information</h5>
                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                    <i class="bi bi-person-badge me-1"></i>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                            <div class="card-body">
                                <!-- View Mode -->
                                <div id="viewMode">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted small">Full Name</label>
                                            <div class="form-control-plaintext fw-semibold">{{ $user->name }}</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted small">Email Address</label>
                                            <div class="d-flex align-items-center">
                                                <span class="form-control-plaintext fw-semibold me-2">{{ $user->email }}</span>
                                                @if($user->email_verified_at)
                                                    <span class="badge bg-success">Verified</span>
                                                @else
                                                    <span class="badge bg-warning">Not Verified</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted small">Phone Number</label>
                                            <div class="form-control-plaintext fw-semibold">
                                                {{ $user->phone ?? '<span class="text-muted fst-italic">Not provided</span>' }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted small">Account Status</label>
                                            <div>
                                                <span class="badge bg-success">Active</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Mode (Hidden by default) -->
                                <form id="editForm" action="{{ route('profile.update') }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('POST')
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="editName" class="form-label">Full Name *</label>
                                            <input type="text" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   id="editName" 
                                                   name="name" 
                                                   value="{{ old('name', $user->name) }}"
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" 
                                                   class="form-control" 
                                                   value="{{ $user->email }}"
                                                   readonly
                                                   disabled>
                                            <div class="form-text small">Email cannot be changed</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="editPhone" class="form-label">Phone Number</label>
                                            <input type="tel" 
                                                   class="form-control @error('phone') is-invalid @enderror" 
                                                   id="editPhone" 
                                                   name="phone" 
                                                   value="{{ old('phone', $user->phone) }}"
                                                   placeholder="+1 (123) 456-7890">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3 d-flex align-items-end">
                                            <div class="w-100">
                                                <label class="form-label">Role</label>
                                                <input type="text" 
                                                       class="form-control" 
                                                       value="{{ ucfirst($user->role) }}"
                                                       readonly
                                                       disabled>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-end gap-2 mt-3">
                                        <button type="button" class="btn btn-outline-secondary" id="cancelEditBtn">
                                            Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save me-2"></i>Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Contact Details Card -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Contact Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Email</label>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-envelope me-2 text-primary"></i>
                                            <a href="mailto:{{ $user->email }}" class="text-decoration-none">
                                                {{ $user->email }}
                                            </a>
                                        </div>
                                    </div>
                                    @if($user->phone)
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Phone</label>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-telephone me-2 text-primary"></i>
                                            <a href="tel:{{ $user->phone }}" class="text-decoration-none">
                                                {{ $user->phone }}
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Security Status Card -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Security Status</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <div>
                                            <i class="bi bi-envelope-check text-success me-2"></i>
                                            <span>Email Verification</span>
                                        </div>
                                        @if($user->email_verified_at)
                                            <span class="badge bg-success">Completed</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <div>
                                            <i class="bi bi-shield-check text-primary me-2"></i>
                                            <span>Account Security</span>
                                        </div>
                                        <span class="badge bg-success">Active</span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <div>
                                            <i class="bi bi-clock-history text-info me-2"></i>
                                            <span>Last Login</span>
                                        </div>
                                        <span class="text-muted small">
                                            {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                                        </span>
                                    </div>
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
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.password.update') }}" method="POST" id="passwordForm">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password *</label>
                        <input type="password" 
                               class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" 
                               name="current_password"
                               required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password *</label>
                        <input type="password" 
                               class="form-control @error('new_password') is-invalid @enderror" 
                               id="new_password" 
                               name="new_password"
                               required>
                        @error('new_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text small">
                            Password must be at least 6 characters long.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password *</label>
                        <input type="password" 
                               class="form-control" 
                               id="new_password_confirmation" 
                               name="new_password_confirmation"
                               required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Avatar Upload Modal -->
<div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="avatarModalLabel">Change Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div id="avatarPreview" class="rounded-circle bg-light mx-auto d-flex align-items-center justify-content-center" 
                             style="width: 150px; height: 150px; border: 2px dashed #dee2e6;">
                            <i class="bi bi-person-circle text-muted" style="font-size: 4rem;"></i>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="file" 
                               class="form-control @error('avatar') is-invalid @enderror" 
                               id="avatarInput" 
                               name="avatar"
                               accept="image/*">
                        <div class="form-text small">Max file size: 2MB. Allowed: JPG, PNG, GIF</div>
                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    @if($user->avatar)
                        <button type="button" class="btn btn-outline-danger me-auto" id="removeAvatarBtn">
                            Remove Picture
                        </button>
                    @endif
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Picture</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar-lg {
    width: 120px;
    height: 120px;
    object-fit: cover;
}
.card {
    border: none;
    border-radius: 12px;
}
.card-header {
    border-bottom: 1px solid rgba(0,0,0,.125);
    border-radius: 12px 12px 0 0 !important;
}
.form-control-plaintext {
    padding: 0.375rem 0;
    min-height: 38px;
    border-bottom: 1px solid transparent;
}
.form-control-plaintext:hover {
    background-color: rgba(0,0,0,.02);
}
.list-group-item {
    border: none;
    padding: 1rem 0;
}
.badge {
    padding: 0.5em 0.9em;
}
#avatarPreview {
    transition: all 0.3s ease;
}
#avatarPreview:hover {
    border-color: #667eea;
    cursor: pointer;
}
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
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
            });
        }
        
        if (cancelEditBtn) {
            cancelEditBtn.addEventListener('click', function() {
                viewMode.style.display = 'block';
                editForm.style.display = 'none';
                editProfileBtn.style.display = 'block';
            });
        }

        // Avatar preview functionality
        const avatarInput = document.getElementById('avatarInput');
        const avatarPreview = document.getElementById('avatarPreview');
        const avatarForm = document.getElementById('avatarForm');
        
        if (avatarInput) {
            avatarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarPreview.innerHTML = `<img src="${e.target.result}" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">`;
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
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update avatar display
                        if (data.avatar) {
                            document.getElementById('avatarContainer').innerHTML = 
                                `<img src="${data.avatar}" class="avatar-lg rounded-circle" id="avatarImage" alt="${data.name}">`;
                        } else {
                            document.getElementById('avatarContainer').innerHTML = 
                                `<div class="avatar-lg bg-primary rounded-circle d-flex align-items-center justify-content-center text-white" id="avatarInitials">
                                    ${data.initials}
                                </div>`;
                        }
                        
                        // Close modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('avatarModal'));
                        modal.hide();
                        
                        // Show success message
                        showAlert('Profile picture updated successfully!', 'success');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        }

        // Remove avatar functionality
        const removeAvatarBtn = document.getElementById('removeAvatarBtn');
        if (removeAvatarBtn) {
            removeAvatarBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to remove your profile picture?')) {
                    fetch('{{ route("profile.avatar.remove") }}', {
                        method: 'DELETE',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update avatar display
                            document.getElementById('avatarContainer').innerHTML = 
                                `<div class="avatar-lg bg-primary rounded-circle d-flex align-items-center justify-content-center text-white" id="avatarInitials">
                                    ${data.initials}
                                </div>`;
                            
                            // Close modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById('avatarModal'));
                            modal.hide();
                            
                            // Show success message
                            showAlert('Profile picture removed successfully!', 'success');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            });
        }

        // Password form validation
        const passwordForm = document.getElementById('passwordForm');
        if (passwordForm) {
            passwordForm.addEventListener('submit', function(e) {
                const newPassword = document.getElementById('new_password').value;
                const confirmPassword = document.getElementById('new_password_confirmation').value;
                
                if (newPassword !== confirmPassword) {
                    e.preventDefault();
                    alert('New password and confirmation do not match.');
                }
                
                if (newPassword.length < 6) {
                    e.preventDefault();
                    alert('Password must be at least 6 characters long.');
                }
            });
        }

        // Helper function to show alerts
        function showAlert(message, type = 'success') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
                <i class="bi ${type === 'success' ? 'bi-check-circle' : 'bi-exclamation-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            const container = document.querySelector('.container');
            container.insertBefore(alertDiv, container.firstChild);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endpush