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
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light" style="position: sticky; top: 0; z-index: 1;">
                            <tr class="bg-light bg-gradient border-bottom border-3">
                                <th class="ps-4 py-3 align-middle" style="width: 90px;">
                                    <span class="bg-primary bg-opacity-10 p-1 rounded-2">
                                        <i class="bi text-primary fs-6">No</i>
                                    </span>
                                </th>
                                <th class="py-3 align-middle fw-semibold text-dark" style="width: 25%;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-person-circle text-primary fs-6"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">User</span>
                                            <small class="text-muted">Profile</small>
                                        </div>
                                    </div>
                                </th>
                                <th class="py-3 align-middle fw-semibold text-dark" style="width: 20%;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-telephone text-primary fs-6"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">Contact</span>
                                            <small class="text-muted">Email & Phone</small>
                                        </div>
                                    </div>
                                </th>
                                <th class="py-3 align-middle fw-semibold text-dark" style="width: 10%;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-shield-check text-primary fs-6"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">Role</span>
                                            <small class="text-muted">Permission</small>
                                        </div>
                                    </div>
                                </th>
                                <th class="py-3 align-middle fw-semibold text-dark" style="width: 15%;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-toggle-on text-primary fs-6"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">Status</span>
                                            <small class="text-muted">Active/Inactive</small>
                                        </div>
                                    </div>
                                </th>
                                <th class="py-3 align-middle fw-semibold text-dark" style="width: 15%;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-calendar-plus text-primary fs-6"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">Registered</span>
                                            <small class="text-muted">Join Date</small>
                                        </div>
                                    </div>
                                </th>
                                <th class="pe-4 py-3 align-middle fw-semibold text-dark text-end" style="width: 10%;">
                                    <div class="d-flex align-items-center justify-content-end gap-2">
                                        <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                            <i class="bi bi-sliders text-primary fs-6"></i>
                                        </div>
                                        <div class="d-flex flex-column text-end">
                                            <span class="fw-semibold">Actions</span>
                                            <small class="text-muted">Manage</small>
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
                                <tr class="table-info">
                                    <td class="ps-4 py-3 align-middle">
                                        <span
                                            class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-3 py-1">
                                            #{{ $user->id }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                                style="width: 40px; height: 40px;">
                                                <i class="bi bi-person-badge"></i>
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $user->name }}</div>
                                                <small class="text-muted">Admin Account</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 align-middle">
                                        <div class="d-flex flex-column gap-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                                    style="width: 36px; height: 36px;">
                                                    <i class="bi bi-envelope"></i>
                                                </div>
                                                <div class="fw-medium">{{ $user->email }}</div>
                                            </div>
                                            @if ($user->phone)
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                                        style="width: 36px; height: 36px;">
                                                        <i class="bi bi-phone"></i>
                                                    </div>
                                                    <div class="text-muted">{{ $user->phone }}</div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">Admin</span>
                                    </td>
                                    <td>
                                        @if ($user->email_verified_at)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Verified
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="bi bi-clock me-1"></i>Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $user->created_at->format('d M Y') }}</small>
                                        <br>
                                        <small class="text-muted">{{ $user->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-warning"
                                                data-bs-toggle="modal" data-bs-target="#editRoleModal"
                                                onclick="editRole({{ json_encode($user) }})">
                                                <i class="bi bi-person-gear"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" data-bs-target="#deleteUserModal"
                                                onclick="setDeleteId({{ $user->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            <!-- Regular Users -->
                            @foreach ($regularUsers as $user)
                                <tr>
                                    <td class="ps-4 py-3 align-middle">
                                        <span
                                            class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-3 py-1">
                                            #{{ $user->id }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center me-3"
                                                style="width: 40px; height: 40px;">
                                                <i class="bi bi-person"></i>
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $user->name }}</div>
                                                <small class="text-muted">Customer</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div><i class="bi bi-envelope me-1"></i>{{ $user->email }}</div>
                                        @if ($user->phone)
                                            <div class="small text-muted"><i
                                                    class="bi bi-phone me-1"></i>{{ $user->phone }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">User</span>
                                    </td>
                                    <td>
                                        @if ($user->email_verified_at)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Verified
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="bi bi-clock me-1"></i>Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $user->created_at->format('d M Y') }}</small>
                                        <br>
                                        <small class="text-muted">{{ $user->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-warning"
                                                data-bs-toggle="modal" data-bs-target="#editRoleModal"
                                                onclick="editRole({{ json_encode($user) }})">
                                                <i class="bi bi-person-gear"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" data-bs-target="#deleteUserModal"
                                                onclick="setDeleteId({{ $user->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if ($users->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="py-5">
                                            <i class="bi bi-people text-muted" style="font-size: 48px;"></i>
                                            <p class="text-muted mt-3">No users found</p>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.users.update-role') }}">
                    @csrf
                    <input type="hidden" name="id" id="editUserId">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRoleModalLabel">
                            <i class="bi bi-person-gear me-2"></i>
                            Change User Role
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">User Name</label>
                            <input type="text" id="userName" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" id="userEmail" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Current Role</label>
                            <input type="text" id="currentRole" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Change Role To *</label>
                            <select name="role" class="form-select" required>
                                <option value="user">Regular User</option>
                                <option value="admin">Administrator</option>
                            </select>
                            <small class="text-muted">Admins have full access to the admin panel.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>
                            Update Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="GET" action="{{ route('admin.users.delete', ':id') }}" id="deleteUserForm">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="deleteUserModalLabel">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Confirm Delete
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="bi bi-person-x-fill text-danger" style="font-size: 64px;"></i>
                            <h5 class="mt-3">Delete User Account?</h5>
                            <p class="text-muted">This user account will be permanently deleted. All associated data will
                                be lost.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <a href="#" class="btn btn-danger" onclick="confirmDeleteUser()">
                            <i class="bi bi-trash me-1"></i>
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
        .table-info {
            background-color: rgba(13, 110, 253, 0.05) !important;
        }

        .badge.bg-opacity-10 {
            --bs-bg-opacity: 0.1;
        }
    </style>

@endsection
