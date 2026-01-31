@extends('admin.layouts.app')

@section('title', 'Manage Coupons')
@section('page-title', 'Coupon Management')

@section('actions')
    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle"></i> Create Coupon
    </a>
@endsection

@section('content')
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Coupons</h5>
                    <h2>{{ $stats['total'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Active</h5>
                    <h2>{{ $stats['active'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Inactive</h5>
                    <h2>{{ $stats['inactive'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Expired</h5>
                    <h2>{{ $stats['expired'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Header + Actions -->
    <div class="card mb-2">
        <div class="card-body py-2">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <!-- Title -->
                <div>
                    <h2 class="mb-0 fw-bold">Coupon Manager</h2>
                    <small class="text-muted">Manage all discount coupons</small>
                </div>

                <!-- Actions -->
                <form method="GET" class="d-flex align-items-center gap-2">

                    <!-- Search Input -->
                    <input type="text" class="form-control form-control-sm" name="search"
                        placeholder="Search code or name..." value="{{ request('search') }}" style="width: 200px;">

                    <!-- Search Button -->
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-search"></i>
                    </button>

                    <!-- Add Coupon Button -->
                    <a href="{{ route('admin.coupons.create') }}" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Add New Coupon
                    </a>
                </form>
            </div>
        </div>
    </div>



    <!-- Coupons Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light" style="position: sticky; top: 0; z-index: 1;">
                        <tr class="align-middle text-nowrap">
                            <th class="fw-semibold">Code</th>
                            <th class="fw-semibold">Name</th>
                            <th class="fw-semibold">Type</th>
                            <th class="fw-semibold text-center">Discount</th>
                            <th class="fw-semibold text-center">Validity</th>
                            <th class="fw-semibold text-center">Usage</th>
                            <th class="fw-semibold text-center">Status</th>
                            <th class="fw-semibold text-center">Actions</th>
                        </tr>
                    </thead>

                    </thead>
                    <tbody>
                        @forelse($coupons as $coupon)
                            <tr>
                                <td class="align-middle">
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold text-dark">{{ $coupon->code }}</span>
                                        <span class="text-muted small">#{{ $coupon->id }}</span>
                                    </div>
                                </td>

                                <td class="align-middle">
                                    <span class="fw-semibold text-dark">{{ $coupon->name }}</span>
                                </td>

                                <td class="align-middle text-center">
                                    <span class="badge rounded-pill bg-info-subtle text-info border">
                                        {{ ucfirst(str_replace('_', ' ', $coupon->discount_type)) }}
                                    </span>
                                </td>

                                <td class="align-middle text-center">
                                    <div class="fw-semibold">
                                        @if ($coupon->discount_type == 'percentage')
                                            {{ $coupon->discount_value }}%
                                        @else
                                            ₹{{ number_format($coupon->discount_value, 2) }}
                                        @endif
                                    </div>

                                    @if ($coupon->max_discount_amount)
                                        <small class="text-muted d-block">
                                            Max ₹{{ number_format($coupon->max_discount_amount, 2) }}
                                        </small>
                                    @endif
                                </td>

                                <td class="align-middle text-center">
                                    <div class="small">
                                        <span class="fw-semibold">{{ $coupon->start_date->format('d M Y') }}</span>
                                        <br>
                                        <span class="text-muted">to</span>
                                        <br>
                                        <span class="fw-semibold">{{ $coupon->end_date->format('d M Y') }}</span>
                                    </div>

                                    @if ($coupon->end_date < now())
                                        <span class="badge rounded-pill bg-danger-subtle text-danger border mt-1">
                                            Expired
                                        </span>
                                    @endif
                                </td>

                                <td class="align-middle" style="min-width:140px;">
                                    @php
                                        $usagePercentage = $coupon->usage_limit
                                            ? min(100, ($coupon->usages_count / $coupon->usage_limit) * 100)
                                            : 0;
                                    @endphp

                                    <div class="progress rounded-pill mb-1" style="height: 6px;">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: {{ $usagePercentage }}%">
                                        </div>
                                    </div>

                                    <small class="text-muted">
                                        {{ $coupon->usages_count }}
                                        @if ($coupon->usage_limit)
                                            / {{ $coupon->usage_limit }}
                                        @endif
                                        uses
                                    </small>
                                </td>

                                <td class="align-middle text-center">
                                    @php
                                        $statusMap = [
                                            'active' => 'bg-success-subtle text-success border',
                                            'inactive' => 'bg-warning-subtle text-warning border',
                                            'expired' => 'bg-danger-subtle text-danger border',
                                        ];
                                    @endphp

                                    <span class="badge rounded-pill {{ $statusMap[$coupon->status] }}">
                                        {{ ucfirst($coupon->status) }}
                                    </span>
                                </td>

                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center gap-1">

                                        <a href="{{ route('admin.coupons.show', $coupon) }}"
                                            class="btn btn-sm btn-light border" title="View">
                                            <i class="fas fa-eye text-info"></i>
                                        </a>

                                        <a href="{{ route('admin.coupons.edit', $coupon) }}"
                                            class="btn btn-sm btn-light border" title="Edit">
                                            <i class="fas fa-edit text-warning"></i>
                                        </a>

                                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light border"
                                                onclick="return confirm('Are you sure you want to delete this coupon?')"
                                                title="Delete">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-tag fa-3x text-muted"></i>
                                    <h5 class="mt-3">No coupons found</h5>
                                    <p class="text-muted">Create your first coupon to get started</p>
                                    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus-circle"></i> Create Coupon
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($coupons->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $coupons->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Coupon Modal -->
    <div class="modal fade" id="deleteCouponModal" tabindex="-1" aria-labelledby="deleteCouponModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteCouponModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-trash-alt fa-4x text-danger mb-3"></i>
                        <h5>Delete Coupon: <span class="text-primary" id="modalCouponCode"></span></h5>
                        <p class="text-muted small" id="modalCouponName"></p>
                    </div>

                    <div class="alert alert-warning">
                        <h6 class="alert-heading"><i class="fas fa-exclamation-circle"></i> Warning</h6>
                        <p class="mb-2">This action cannot be undone. The following data will be permanently deleted:</p>
                        <ul class="mb-0">
                            <li>Coupon record: <strong id="modalCouponNameText"></strong></li>
                            <li>Usage history: <strong id="modalCouponUses">0</strong> records</li>
                            <li>Associated data with orders</li>
                        </ul>
                    </div>

                    <div id="usageRestriction" style="display: none;">
                        <div class="alert alert-danger">
                            <h6 class="alert-heading"><i class="fas fa-ban"></i> Restrictions</h6>
                            <p class="mb-0">This coupon has been used <strong id="modalCouponUsesText">0</strong> times.
                                Deleting it may affect order history and reporting.</p>
                        </div>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="confirmDelete">
                        <label class="form-check-label" for="confirmDelete">
                            I understand this action is irreversible and I want to proceed
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="" method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" id="deleteButton" disabled>
                            <i class="fas fa-trash"></i> Delete Permanently
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteModal = document.getElementById('deleteCouponModal');
            const deleteForm = document.getElementById('deleteForm');
            const confirmCheckbox = document.getElementById('confirmDelete');
            const deleteButton = document.getElementById('deleteButton');

            // Store all delete buttons
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const couponId = this.getAttribute('data-coupon-id');
                    const couponName = this.getAttribute('data-coupon-name');
                    const couponCode = this.getAttribute('data-coupon-code');
                    const couponUses = this.getAttribute('data-coupon-uses');

                    // Find the original form for this coupon
                    const originalForm = this.closest('.delete-form');

                    // Update modal content
                    document.getElementById('modalCouponCode').textContent = couponCode;
                    document.getElementById('modalCouponName').textContent = couponName;
                    document.getElementById('modalCouponNameText').textContent = couponName;
                    document.getElementById('modalCouponUses').textContent = couponUses;
                    document.getElementById('modalCouponUsesText').textContent = couponUses;

                    // Show/hide restriction warning
                    const usageRestriction = document.getElementById('usageRestriction');
                    if (parseInt(couponUses) > 0) {
                        usageRestriction.style.display = 'block';
                    } else {
                        usageRestriction.style.display = 'none';
                    }

                    // Update delete form action
                    if (originalForm) {
                        const action = originalForm.getAttribute('action');
                        deleteForm.setAttribute('action', action);
                    } else {
                        // Fallback URL
                        deleteForm.setAttribute('action',
                        `{{ url('admin/coupons') }}/${couponId}`);
                    }

                    // Reset checkbox
                    confirmCheckbox.checked = false;
                    deleteButton.disabled = true;
                });
            });

            // Confirm checkbox logic
            if (confirmCheckbox && deleteButton) {
                confirmCheckbox.addEventListener('change', function() {
                    deleteButton.disabled = !this.checked;
                });

                // Reset on modal close
                if (deleteModal) {
                    deleteModal.addEventListener('hidden.bs.modal', function() {
                        confirmCheckbox.checked = false;
                        deleteButton.disabled = true;
                    });
                }
            }

            // Handle form submission
            if (deleteForm) {
                deleteForm.addEventListener('submit', function(e) {
                    if (!confirmCheckbox.checked) {
                        e.preventDefault();
                        alert('Please confirm by checking the checkbox.');
                    }
                });
            }
        });
    </script>
@endpush
