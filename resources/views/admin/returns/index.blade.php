@extends('admin.layouts.app')

@section('title', 'Return Management')

@section('content')
    <div class="container-fluid">
        <!-- Header with Stats -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Return Requests</h1>
                <p class="text-muted mb-0">Manage and process customer returns</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.returns.reports') }}" class="btn btn-outline-info">
                    <i class="fas fa-chart-bar mr-2"></i>Analytics
                </a>
                <a href="{{ route('admin.returns.policies') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-cog mr-2"></i>Policies
                </a>
                <a href="{{ route('admin.returns.reasons') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-list mr-2"></i>Reasons
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-2 col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Returns</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exchange-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pending</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Approved</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['approved'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Completed</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['completed'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Rejected</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['rejected'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                    Processing</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['processing'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-truck fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Return Requests List</h6>

                <!-- Filters - All in One Line -->
                <form method="GET" class="form-inline">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <!-- Status Filter -->
                        <div class="input-group input-group-sm" style="width: 160px;">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-right-0">
                                    <i class="fas fa-filter text-muted"></i>
                                </span>
                            </div>
                            <select name="status" class="form-control custom-select border-left-0"
                                onchange="this.form.submit()">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status
                                </option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                                </option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                                </option>
                                <option value="pickup_scheduled"
                                    {{ request('status') == 'pickup_scheduled' ? 'selected' : '' }}>Pickup Scheduled
                                </option>
                                <option value="picked_up" {{ request('status') == 'picked_up' ? 'selected' : '' }}>Picked
                                    Up</option>
                                <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded
                                </option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                    Completed</option>
                            </select>
                        </div>

                        {{-- <!-- Date From -->
                        <div class="input-group input-group-sm" style="width: 140px;">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-right-0">
                                    <i class="fas fa-calendar text-muted"></i>
                                </span>
                            </div>
                            <input type="date" name="date_from" class="form-control border-left-0"
                                value="{{ request('date_from') }}" placeholder="From"
                                onchange="if(this.value && document.querySelector('input[name=\"date_to\"]').value) this.form.submit()">
                        </div>

                        <!-- Date To -->
                        <div class="input-group input-group-sm" style="width: 140px;">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-right-0">
                                    <i class="fas fa-calendar text-muted"></i>
                                </span>
                            </div>
                            <input type="date" name="date_to" class="form-control border-left-0"
                                value="{{ request('date_to') }}" placeholder="To"
                                onchange="if(this.value && document.querySelector('input[name=\"date_from\"]').value) this.form.submit()">
                        </div> --}}

                        <!-- Search -->
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                                placeholder="Search returns...">
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-sm" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Reset Button -->
                        <a href="{{ route('admin.returns.index') }}" class="btn btn-sm btn-outline-secondary ml-1">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </form>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light" style="position: sticky; top: 0; z-index: 1;">
                            <tr class="bg-light bg-gradient border-bottom border-3">
                                <th class="py-3 px-3 border-0 text-uppercase" style="letter-spacing: 0.5px;">
                                    <i class="fas fa-hashtag me-2"></i>Return #
                                </th>
                                <th class="py-3 px-3 border-0 text-uppercase" style="letter-spacing: 0.5px;">
                                    <i class="fas fa-shopping-cart me-2"></i>Order #
                                </th>
                                <th class="py-3 px-3 border-0 text-uppercase" style="letter-spacing: 0.5px;">
                                    <i class="fas fa-user me-2"></i>Customer
                                </th>
                                <th class="py-3 px-3 border-0 text-uppercase" style="letter-spacing: 0.5px;">
                                    <i class="fas fa-box me-2"></i>Product
                                </th>
                                <th class="py-3 px-3 border-0 text-uppercase" style="letter-spacing: 0.5px;">
                                    <i class="fas fa-exclamation-circle me-2"></i>Reason
                                </th>
                                <th class="py-3 px-3 border-0 text-uppercase" style="letter-spacing: 0.5px;">
                                    <i class="fas fa-money-bill-wave me-2"></i>Amount
                                </th>
                                <th class="py-3 px-3 border-0 text-uppercase" style="letter-spacing: 0.5px;">
                                    <i class="fas fa-tasks me-2"></i>Status
                                </th>
                                <th class="py-3 px-3 border-0 text-uppercase" style="letter-spacing: 0.5px;">
                                    <i class="fas fa-calendar me-2"></i>Created
                                </th>
                                <th class="py-3 px-3 border-0 text-center text-uppercase" style="letter-spacing: 0.5px;">
                                    <i class="fas fa-cog me-2"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($returns as $return)
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span
                                                class="badge bg-primary bg-opacity-10 text-primary fw-bold mb-1 px-2 py-1 rounded">
                                                <i class="fas fa-hashtag me-1"></i>{{ $return->return_number }}
                                            </span>
                                            <small class="text-muted">
                                                <i class="fas fa-fingerprint me-1"></i>ID: {{ $return->id }}
                                            </small>
                                        </div>
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.order.details', $return->order_id) }}"
                                            class="text-decoration-none hover-card">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded p-2 me-2">
                                                    <i class="fas fa-shopping-cart text-primary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $return->order->order_number }}
                                                    </div>
                                                    <small class="text-primary">
                                                        <i class="fas fa-external-link-alt me-1"></i>View Order
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2">
                                                <div
                                                    class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center">
                                                    <span
                                                        class="text-muted">{{ substr($return->user->name, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-weight-bold">{{ $return->user->name }}</div>
                                                <small class="text-muted">{{ $return->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ Str::limit($return->product->name, 20) }}</div>
                                        <div class="text-muted small">
                                            <span class="badge badge-light text-primary">Qty:
                                                {{ $return->quantity }}</span>
                                            @if ($return->product->image)
                                                <img src="{{ asset('storage/returns' . $return->product->image) }}"
                                                    alt="{{ $return->product->name }}" class="img-thumbnail ml-1"
                                                    width="30">
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">
                                            {{ ucfirst(str_replace('_', ' ', $return->reason)) }}</div>
                                        @if ($return->description)
                                            <small class="text-muted" data-toggle="tooltip"
                                                title="{{ $return->description }}">
                                                {{ Str::limit($return->description, 20) }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="font-weight-bold text-success">
                                            ₹{{ number_format($return->amount, 2) }}</div>
                                        @if ($return->refund_amount)
                                            <small class="text-muted">Refund:
                                                ₹{{ number_format($return->refund_amount, 2) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="status-indicator status-{{ $return->status }}">
                                            <div class="status-dot bg-{{ $return->status_color }}"></div>
                                            <div class="status-text fw-bold text-{{ $return->status_color }}">
                                                {{ $return->status_text }}
                                            </div>
                                            @if ($return->refund_method)
                                                <div class="status-meta text-muted small mt-1">
                                                    <i class="fas fa-hand-holding-usd me-1"></i>
                                                    {{ ucfirst($return->refund_method) }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>{{ $return->created_at->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $return->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <!-- View Button -->
                                            <a href="{{ route('admin.returns.show', $return->id) }}"
                                                class="btn btn-sm btn-outline-primary"> <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Delete Form -->
                                            <form action="{{ route('admin.returns.destroy', $return->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete return #{{ $return->return_number }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-exchange-alt fa-3x text-gray-300 mb-3"></i>
                                            <h4 class="text-gray-500">No return requests found</h4>
                                            <p class="text-muted">When customers request returns, they'll appear here.</p>
                                            <a href="{{ route('admin.orders') }}" class="btn btn-primary mt-2">
                                                <i class="fas fa-shopping-cart mr-2"></i>View Orders
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($returns->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Showing {{ $returns->firstItem() }} to {{ $returns->lastItem() }} of {{ $returns->total() }}
                            entries
                        </div>
                        <nav aria-label="Page navigation">
                            {{ $returns->links() }}
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Confirm Delete
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-3">
                        <i class="fas fa-trash-alt fa-3x text-danger"></i>
                    </div>
                    <h5 class="mb-3">Delete Return Request?</h5>
                    <p class="text-muted mb-0">
                        Are you sure you want to delete return request
                        <strong id="returnNumber"></strong>? This action cannot be undone.
                    </p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4">
                            <i class="fas fa-trash mr-1"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-primary">Update Return Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="statusForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" id="statusValue">

                        <div class="form-group">
                            <label for="statusNotes">Admin Notes (Optional)</label>
                            <textarea name="notes" id="statusNotes" class="form-control" rows="3"
                                placeholder="Add notes about this status change..."></textarea>
                        </div>

                        <div class="form-group refund-fields" style="display: none;">
                            <label for="refundAmount">Refund Amount</label>
                            <input type="number" name="refund_amount" id="refundAmount" class="form-control"
                                step="0.01" min="0">
                        </div>

                        <div class="form-group refund-fields" style="display: none;">
                            <label for="refundMethod">Refund Method</label>
                            <select name="refund_method" id="refundMethod" class="form-control">
                                <option value="original">Original Payment Method</option>
                                <option value="wallet">Store Credit/Wallet</option>
                                <option value="bank_transfer">Bank Transfer</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="submitStatusForm()">Update Status</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .avatar-sm {
            width: 32px;
            height: 32px;
            font-size: 14px;
            font-weight: 500;
        }

        .empty-state {
            padding: 2rem;
            text-align: center;
        }

        .badge-pill {
            border-radius: 50rem;
        }

        .card-header {
            background: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }

        .table thead th {
            border-top: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .dropdown-menu {
            min-width: 180px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border: 1px solid #e3e6f0;
        }
    </style>
    <style>
        .status-indicator {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .status-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-bottom: 5px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Delete confirmation
        function confirmDelete(id, returnNumber) {
            $('#returnNumber').text('#' + returnNumber);
            $('#deleteForm').attr('action', '/admin/returns/' + id);
            $('#deleteModal').modal('show');
        }

        // Status update
        function updateStatus(returnId, status) {
            $('#statusForm').attr('action', '/admin/returns/' + returnId + '/status');
            $('#statusValue').val(status);

            // Show/hide refund fields based on status
            if (status === 'approved') {
                $('.refund-fields').show();
            } else {
                $('.refund-fields').hide();
            }

            $('#statusModal').modal('show');
        }

        // Process refund
        function processRefund(returnId) {
            $('#statusForm').attr('action', '/admin/returns/' + returnId + '/refund');
            $('#statusValue').val('refunded');
            $('.refund-fields').show();
            $('#statusModal').modal('show');
        }

        // Submit status form
        function submitStatusForm() {
            $('#statusForm').submit();
        }

        // Initialize tooltips
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        // Auto-submit date filters when both are filled
        $('input[name="date_from"], input[name="date_to"]').on('change', function() {
            if ($('input[name="date_from"]').val() && $('input[name="date_to"]').val()) {
                $(this).closest('form').submit();
            }
        });
    </script>
@endpush
