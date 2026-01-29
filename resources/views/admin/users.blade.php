@extends('admin.layouts.app')

@section('title', 'Users Management')

@section('content')

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-1">Users Management</h3>
            <p class="text-muted mb-0">Manage system users and their roles</p>
        </div>
        <div class="d-flex align-items-center">
            <span class="badge bg-primary me-2">
                <i class="bi bi-people me-1"></i>
                {{ $users->count() }} Users
            </span>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light sticky-top" style="top: 0; z-index: 10;">
                        <tr class="border-bottom border-2 border-light">
                            <th class="ps-4 py-3 align-middle fw-semibold text-dark" style="width: 80px;">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded-2">
                                        <i class="bi bi-hash text-primary"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">ID</span>
                                    </div>
                                </div>
                            </th>
                            <th class="py-3 align-middle fw-semibold text-dark" style="min-width: 250px;">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded-2">
                                        <i class="bi bi-person-circle text-primary"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">User Profile</span>
                                        <small class="text-muted fw-normal">Name & Status</small>
                                    </div>
                                </div>
                            </th>
                            <th class="py-3 align-middle fw-semibold text-dark" style="min-width: 220px;">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded-2">
                                        <i class="bi bi-telephone text-primary"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">Contact Info</span>
                                        <small class="text-muted fw-normal">Email & Phone</small>
                                    </div>
                                </div>
                            </th>
                            <th class="py-3 align-middle fw-semibold text-dark" style="width: 120px;">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded-2">
                                        <i class="bi bi-shield-check text-primary"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">Role</span>
                                        <small class="text-muted fw-normal">Permission</small>
                                    </div>
                                </div>
                            </th>
                            <th class="py-3 align-middle fw-semibold text-dark" style="width: 140px;">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded-2">
                                        <i class="bi bi-calendar-plus text-primary"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">Registered</span>
                                        <small class="text-muted fw-normal">Join Date</small>
                                    </div>
                                </div>
                            </th>
                            <th class="pe-4 py-3 align-middle fw-semibold text-dark text-end" style="width: 130px;">
                                <div class="d-flex align-items-center justify-content-end gap-2">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded-2">
                                        <i class="bi bi-sliders text-primary"></i>
                                    </div>
                                    <div class="d-flex flex-column text-end">
                                        <span class="fw-semibold">Actions</span>
                                        <small class="text-muted fw-normal">Manage</small>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $admins = $users->where('role', 'admin');
                            $regularUsers = $users->where('role', 'user');
                        @endphp

                        <!-- Admin Users First -->
                        @foreach ($admins as $user)
                            <tr class="table-primary bg-opacity-10 border-bottom border-light">
                                <td class="ps-4 py-3 align-middle">
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-3 py-2">
                                        #{{ $user->id }}
                                    </span>
                                </td>
                                <td class="py-3 align-middle">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="position-relative">
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 42px; height: 42px;">
                                                <i class="bi bi-person-badge fs-5"></i>
                                            </div>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white" style="font-size: 8px; padding: 3px 5px;">
                                                ADMIN
                                            </span>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-primary">{{ $user->name }}</div>
                                            <small class="text-muted d-flex align-items-center gap-1">
                                                <i class="bi bi-check-circle-fill text-success" style="font-size: 10px;"></i>
                                                <span>Administrator Account</span>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 align-middle">
                                    <div class="d-flex flex-column gap-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                                style="width: 32px; height: 32px;">
                                                <i class="bi bi-envelope"></i>
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $user->email }}</div>
                                                <small class="text-muted">Email</small>
                                            </div>
                                        </div>
                                        @if ($user->phone)
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                                    style="width: 32px; height: 32px;">
                                                    <i class="bi bi-phone"></i>
                                                </div>
                                                <div>
                                                    <div class="text-dark">{{ $user->phone }}</div>
                                                    <small class="text-muted">Phone</small>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 align-middle">
                                    <span class="badge bg-danger px-3 py-2 d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-shield-check"></i>
                                        Admin
                                    </span>
                                </td>
                                <td class="py-3 align-middle">
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium">{{ $user->created_at->format('d M Y') }}</span>
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i>
                                            {{ $user->created_at->format('h:i A') }}
                                        </small>
                                    </div>
                                </td>
                                <td class="pe-4 py-3 align-middle text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-warning border-2 d-flex align-items-center gap-1"
                                            data-bs-toggle="modal" data-bs-target="#editRoleModal"
                                            onclick="editRole({{ json_encode($user) }})">
                                            <i class="bi bi-person-gear"></i>
                                            <span>Edit</span>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger border-2 d-flex align-items-center gap-1"
                                            data-bs-toggle="modal" data-bs-target="#deleteUserModal"
                                            onclick="setDeleteId({{ $user->id }})">
                                            <i class="bi bi-trash"></i>
                                            <span>Delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        <!-- Regular Users -->
                        @foreach ($regularUsers as $user)
                            <tr class="border-bottom border-light">
                                <td class="ps-4 py-3 align-middle">
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary rounded-pill px-3 py-2">
                                        #{{ $user->id }}
                                    </span>
                                </td>
                                <td class="py-3 align-middle">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 42px; height: 42px;">
                                            <i class="bi bi-person fs-5"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $user->name }}</div>
                                            <small class="text-muted d-flex align-items-center gap-1">
                                                <i class="bi bi-person-fill text-secondary" style="font-size: 10px;"></i>
                                                <span>Customer Account</span>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 align-middle">
                                    <div class="d-flex flex-column gap-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                                style="width: 32px; height: 32px;">
                                                <i class="bi bi-envelope"></i>
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $user->email }}</div>
                                                <small class="text-muted">Email</small>
                                            </div>
                                        </div>
                                        @if ($user->phone)
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                                    style="width: 32px; height: 32px;">
                                                    <i class="bi bi-phone"></i>
                                                </div>
                                                <div>
                                                    <div class="text-dark">{{ $user->phone }}</div>
                                                    <small class="text-muted">Phone</small>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 align-middle">
                                    <span class="badge bg-secondary px-3 py-2 d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-person"></i>
                                        User
                                    </span>
                                </td>
                                <td class="py-3 align-middle">
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium">{{ $user->created_at->format('d M Y') }}</span>
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i>
                                            {{ $user->created_at->format('h:i A') }}
                                        </small>
                                    </div>
                                </td>
                                <td class="pe-4 py-3 align-middle text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-warning border-2 d-flex align-items-center gap-1"
                                            data-bs-toggle="modal" data-bs-target="#editRoleModal"
                                            onclick="editRole({{ json_encode($user) }})">
                                            <i class="bi bi-person-gear"></i>
                                            <span>Edit</span>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger border-2 d-flex align-items-center gap-1"
                                            data-bs-toggle="modal" data-bs-target="#deleteUserModal"
                                            onclick="setDeleteId({{ $user->id }})">
                                            <i class="bi bi-trash"></i>
                                            <span>Delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if ($users->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-5">
                                        <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                                            <i class="bi bi-people text-muted" style="font-size: 48px;"></i>
                                        </div>
                                        <h5 class="text-muted mb-2">No users found</h5>
                                        <p class="text-muted">There are no users registered in the system yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <form method="POST" action="{{ route('admin.users.update-role') }}">
                @csrf
                <input type="hidden" name="id" id="editUserId">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title d-flex align-items-center gap-2" id="editRoleModalLabel">
                        <i class="bi bi-person-gear"></i>
                        Change User Role
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-medium text-muted mb-2">User Name</label>
                        <input type="text" id="userName" class="form-control form-control-lg bg-light border-2" readonly>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium text-muted mb-2">Email Address</label>
                        <input type="text" id="userEmail" class="form-control form-control-lg bg-light border-2" readonly>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium text-muted mb-2">Current Role</label>
                        <input type="text" id="currentRole" class="form-control form-control-lg bg-light border-2" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted mb-2">Change Role To</label>
                        <select name="role" class="form-select form-select-lg border-2" required>
                            <option value="user">Regular User</option>
                            <option value="admin">Administrator</option>
                        </select>
                        <div class="form-text mt-2">
                            <i class="bi bi-info-circle me-1"></i>
                            Admins have full access to the admin panel with all permissions.
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light border-2 px-4 py-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 py-2">
                        <i class="bi bi-save me-2"></i>
                        Update Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <form method="GET" action="{{ route('admin.users.delete', ':id') }}" id="deleteUserForm">
                <div class="modal-header bg-danger text-white border-0">
                    <h5 class="modal-title d-flex align-items-center gap-2" id="deleteUserModalLabel">
                        <i class="bi bi-exclamation-triangle"></i>
                        Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex p-4 mb-4">
                        <i class="bi bi-person-x-fill text-danger" style="font-size: 64px;"></i>
                    </div>
                    <h5 class="mb-3">Delete User Account?</h5>
                    <p class="text-muted mb-4">
                        This action cannot be undone. The user account will be permanently deleted along with all associated data including orders and profile information.
                    </p>
                    <div class="alert alert-warning border-2 d-flex align-items-start gap-2">
                        <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                        <div>
                            <strong>Warning:</strong> This is a permanent action. Please make sure you want to proceed.
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light border-2 px-4 py-2" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" class="btn btn-danger px-4 py-2" onclick="confirmDeleteUser()">
                        <i class="bi bi-trash me-2"></i>
                        Delete User
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editRole(user) {
        document.getElementById('editUserId').value = user.id;
        document.getElementById('userName').value = user.name;
        document.getElementById('userEmail').value = user.email;
        document.getElementById('currentRole').value = user.role === 'admin' ? 'Administrator' : 'Regular User';

        // Set the select option to current role
        const roleSelect = document.querySelector('select[name="role"]');
        roleSelect.value = user.role;
    }

    function setDeleteId(id) {
        const form = document.getElementById('deleteUserForm');
        form.action = '{{ route('admin.users.delete', ':id') }}'.replace(':id', id);
    }

    function confirmDeleteUser() {
        const form = document.getElementById('deleteUserForm');
        window.location.href = form.action;
    }
</script>

<style>
    .table-primary {
        --bs-table-bg: rgba(13, 110, 253, 0.05);
        --bs-table-border-color: rgba(13, 110, 253, 0.1);
    }
    
    .table th {
        border-bottom: 2px solid #e9ecef;
    }
    
    .table td {
        border-bottom: 1px solid #f8f9fa;
    }
    
    .table tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.02);
    }
    
    .badge.bg-opacity-10 {
        --bs-bg-opacity: 0.1;
    }
    
    .form-control:read-only {
        background-color: #f8f9fa;
        cursor: not-allowed;
    }
    
    .border-2 {
        border-width: 2px !important;
    }
    
    /* Scrollbar styling */
    .table-responsive::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>

@endsection