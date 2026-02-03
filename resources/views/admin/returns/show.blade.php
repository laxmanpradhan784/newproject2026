@extends('admin.layouts.app')

@section('title', 'Return Details')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <!-- Return Details Card -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">

                        <!-- Left -->
                        <h3 class="card-title mb-0">
                            Return Details: <span class="fw-semibold">{{ $return->return_number }}</span>
                        </h3>

                        <!-- Right -->
                        <div class="d-flex align-items-center gap-2">

                            <span class="badge badge-{{ $return->status_color }} px-3 py-2">
                                {{ $return->status_text }}
                            </span>

                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#statusHistoryModal">
                                <i class="bi bi-clock-history me-1"></i> History
                            </button>

                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">

                                <!-- Header Row -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">Customer Information</h5>

                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                        data-bs-target="#productDetailsModal">
                                        <i class="bi bi-box-seam me-1"></i> Product Details
                                    </button>
                                </div>

                                <table class="table table-sm">
                                    <tr>
                                        <th width="40%">Name:</th>
                                        <td>{{ $return->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $return->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone:</th>
                                        <td>{{ $return->order->shipping_phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address:</th>
                                        <td>{{ $return->order->shipping_address }}, {{ $return->order->shipping_city }},
                                            {{ $return->order->shipping_state }} - {{ $return->order->shipping_zip }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>Order Information</h5>
                                <table class="table table-sm">
                                    <tr>
                                        <th width="40%">Order Number:</th>
                                        <td>
                                            <a href="{{ route('admin.order.details', $return->order_id) }}">
                                                {{ $return->order->order_number }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Order Date:</th>
                                        <td>{{ $return->order->created_at->format('d M Y, h:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Order Status:</th>
                                        <td>
                                            <span class="badge badge-info">
                                                {{ ucfirst($return->order->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Payment Method:</th>
                                        <td>{{ strtoupper($return->order->payment_method) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <hr>

                        <div class="modal fade" id="productDetailsModal" tabindex="-1"
                            aria-labelledby="productDetailsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content rounded-4 shadow">

                                    <!-- Header -->
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="productDetailsModalLabel">Product Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <!-- Body -->
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table class="table align-middle" aria-label="Product Return Details">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Price</th>
                                                        <th>Qty</th>
                                                        <th>Total</th>
                                                        <th>Type</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-2">
                                                                @if ($return->product->image)
                                                                    <img src="{{ asset('uploads/products/' . $return->product->image) }}"
                                                                        alt="{{ $return->product->name }}"
                                                                        class="rounded border" width="55" height="55"
                                                                        style="object-fit:cover;">
                                                                @endif
                                                                <div>
                                                                    <strong>{{ $return->product->name }}</strong><br>
                                                                    <small class="text-muted">SKU:
                                                                        {{ $return->product->id }}</small>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td>₹{{ number_format($return->amount / $return->quantity, 2) }}
                                                        </td>
                                                        <td>{{ $return->quantity }}</td>
                                                        <td><strong>₹{{ number_format($return->amount, 2) }}</strong></td>

                                                        <td>
                                                            <span class="badge bg-info text-dark px-2 py-1">
                                                                {{ ucfirst($return->return_type) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <h5>Return Information</h5>
                                <table class="table table-sm">
                                    <tr>
                                        <th width="30%">Return Reason:</th>
                                        <td>{{ ucfirst(str_replace('_', ' ', $return->reason)) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Description:</th>
                                        <td>{{ $return->description ?? 'No description provided' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Requested Refund:</th>
                                        <td>₹{{ number_format($return->amount, 2) }}</td>
                                    </tr>
                                    @if ($return->refund_amount)
                                        <tr>
                                            <th>Refund Amount:</th>
                                            <td class="text-success">
                                                <strong>₹{{ number_format($return->refund_amount, 2) }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Refund Method:</th>
                                            <td>{{ ucfirst($return->refund_method) }}</td>
                                        </tr>
                                    @endif
                                    @if ($return->pickup_scheduled_date)
                                        <tr>
                                            <th>Pickup Scheduled:</th>
                                            <td>{{ $return->pickup_scheduled_date->format('d M Y') }}</td>
                                        </tr>
                                    @endif
                                    @if ($return->pickup_date)
                                        <tr>
                                            <th>Pickup Date:</th>
                                            <td>{{ $return->pickup_date->format('d M Y') }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>

                        <!-- Images -->
                        @if ($return->image1 || $return->image2 || $return->image3)
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Attached Images</h5>
                                    <div class="row">

                                        @if ($return->image1)
                                            <div class="col-md-4">
                                                <a href="{{ asset('uploads/products/' . $return->image1) }}"
                                                    target="_blank">
                                                    <img src="{{ asset('uploads/products/' . $return->image1) }}"
                                                        class="img-fluid img-thumbnail" alt="Image 1">
                                                </a>
                                            </div>
                                        @endif

                                        @if ($return->image2)
                                            <div class="col-md-4">
                                                <a href="{{ asset('uploads/products/' . $return->image2) }}"
                                                    target="_blank">
                                                    <img src="{{ asset('uploads/products/' . $return->image2) }}"
                                                        class="img-fluid img-thumbnail" alt="Image 2">
                                                </a>
                                            </div>
                                        @endif

                                        @if ($return->image3)
                                            <div class="col-md-4">
                                                <a href="{{ asset('uploads/products/' . $return->image3) }}"
                                                    target="_blank">
                                                    <img src="{{ asset('uploads/products/' . $return->image3) }}"
                                                        class="img-fluid img-thumbnail" alt="Image 3">
                                                </a>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>

                        @endif
                    </div>
                </div>




                <!-- Status Log -->
                @if ($return->statusLogs->count() > 0)

                    <div class="modal fade" id="statusHistoryModal" tabindex="-1" aria-labelledby="statusHistoryModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content rounded-4 shadow">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="statusHistoryModalLabel">Status History</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="timeline">

                                        @foreach ($return->statusLogs as $log)
                                            <div class="timeline-item mb-3 p-3 border rounded-3">

                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <strong>
                                                        {{ $log->to_status ? ucfirst(str_replace('_', ' ', $log->to_status)) : 'Created' }}
                                                    </strong>
                                                    <small class="text-muted">
                                                        {{ $log->created_at->format('d M Y, h:i A') }}
                                                    </small>
                                                </div>

                                                @if ($log->from_status)
                                                    <div class="small text-muted">
                                                        Changed from
                                                        <strong>{{ ucfirst(str_replace('_', ' ', $log->from_status)) }}</strong>
                                                        to
                                                        <strong>{{ ucfirst(str_replace('_', ' ', $log->to_status)) }}</strong>
                                                    </div>
                                                @endif

                                                @if ($log->notes)
                                                    <div class="mt-1">
                                                        <small class="text-muted">{{ $log->notes }}</small>
                                                    </div>
                                                @endif

                                                @if ($log->admin)
                                                    <div class="mt-1">
                                                        <small class="text-secondary">By: {{ $log->admin->name }}</small>
                                                    </div>
                                                @endif

                                            </div>
                                        @endforeach

                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>

                            </div>
                        </div>
                    </div>

                @endif

            </div>

            <div class="col-md-4">
                <!-- Actions Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Actions</h3>
                    </div>
                    <div class="card-body">
                        <!-- Update Status Form -->
                        <form action="{{ route('admin.returns.update-status', $return->id) }}" method="POST"
                            class="mb-3">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="status">Update Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="">Select Status</option>
                                    <option value="pending" {{ $return->status == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="approved" {{ $return->status == 'approved' ? 'selected' : '' }}>Approve
                                    </option>
                                    <option value="rejected" {{ $return->status == 'rejected' ? 'selected' : '' }}>Reject
                                    </option>
                                    <option value="pickup_scheduled"
                                        {{ $return->status == 'pickup_scheduled' ? 'selected' : '' }}>Schedule Pickup
                                    </option>
                                    <option value="picked_up" {{ $return->status == 'picked_up' ? 'selected' : '' }}>Mark
                                        as Picked Up</option>
                                    <option value="refunded" {{ $return->status == 'refunded' ? 'selected' : '' }}>Mark as
                                        Refunded</option>
                                    <option value="completed" {{ $return->status == 'completed' ? 'selected' : '' }}>Mark
                                        as Completed</option>
                                    <option value="cancelled" {{ $return->status == 'cancelled' ? 'selected' : '' }}>
                                        Cancel
                                    </option>
                                </select>
                            </div>

                            <!-- Conditional fields based on status -->
                            <div id="statusFields">
                                <!-- These fields will be shown/hidden based on selected status -->
                            </div>

                            <div class="form-group">
                                <label for="notes">Admin Notes</label>
                                <textarea name="notes" id="notes" class="form-control" rows="3"
                                    placeholder="Add notes about this status change..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Update Status</button>
                        </form>

                        <!-- Refund Form (show only for approved/picked up returns) -->
                        @if (in_array($return->status, ['approved', 'picked_up']) && $return->return_type == 'refund')
                            <hr>
                            <form action="{{ route('admin.returns.process-refund', $return->id) }}" method="POST">
                                @csrf
                                <h5>Process Refund</h5>
                                <div class="form-group">
                                    <label for="refund_amount">Refund Amount</label>
                                    <input type="number" name="refund_amount" id="refund_amount" class="form-control"
                                        step="0.01" min="0" max="{{ $return->amount }}"
                                        value="{{ $return->amount }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="refund_method">Refund Method</label>
                                    <select name="refund_method" id="refund_method" class="form-control" required>
                                        <option value="original">Original Payment Method</option>
                                        <option value="wallet">Store Credit/Wallet</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="credit_card">Credit Card Refund</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="transaction_id">Transaction ID (Optional)</label>
                                    <input type="text" name="transaction_id" id="transaction_id" class="form-control"
                                        placeholder="Refund transaction ID">
                                </div>
                                <div class="form-group mb-1">
                                    <label for="refund_notes">Refund Notes</label>
                                    <textarea name="notes" id="refund_notes" class="form-control" rows="2"
                                        placeholder="Notes about this refund..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-success btn-block">Process Refund</button>
                            </form>
                        @endif

                        <!-- Delete Button -->
                        <hr>
                        <form action="{{ route('admin.returns.destroy', $return->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this return request?');"
                            class="d-flex align-items-center gap-2">

                            @csrf
                            @method('DELETE')

                            <!-- Delete Button -->
                            <button type="submit" class="btn btn-danger d-flex align-items-center gap-2 px-3 rounded-3">
                                <i class="fas fa-trash"></i>
                                <span>Delete</span>
                            </button>

                            <!-- Policy Button -->
                            @if ($policy)
                                <button type="button"
                                    class="btn btn-outline-info d-flex align-items-center gap-2 px-3 rounded-3"
                                    data-bs-toggle="modal" data-bs-target="#returnPolicyModal">
                                    <i class="bi bi-file-text"></i>
                                    <span>Return Policy</span>
                                </button>
                            @endif

                        </form>

                    </div>
                </div>

                @if ($policy)
                    <div class="modal fade" id="returnPolicyModal" tabindex="-1"
                        aria-labelledby="returnPolicyModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content rounded-4 shadow">

                                <!-- Header -->
                                <div class="modal-header">
                                    <h5 class="modal-title" id="returnPolicyModalLabel">Return Policy</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <!-- Body -->
                                <div class="modal-body">

                                    <div class="mb-3">
                                        <h6 class="fw-semibold">{{ $policy->name }}</h6>
                                        <p class="text-muted small mb-2">{{ $policy->description }}</p>
                                    </div>

                                    <div class="border rounded-3 p-3 bg-light">
                                        <ul class="list-unstyled small mb-0">
                                            <li class="mb-2">
                                                <strong>Return Window:</strong> {{ $policy->return_window_days }} days
                                            </li>
                                            <li class="mb-2">
                                                <strong>Restocking Fee:</strong> {{ $policy->restocking_fee_percentage }}%
                                            </li>
                                            <li class="mb-2">
                                                <strong>Shipping Paid By:</strong>
                                                {{ ucfirst($policy->return_shipping_paid_by) }}
                                            </li>
                                            <li>
                                                <strong>Days Since Order:</strong>
                                                {{ $return->order->created_at->diffInDays() }} days
                                            </li>
                                        </ul>
                                    </div>

                                </div>

                                <!-- Footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Show/hide fields based on status selection
            $('#status').change(function() {
                var status = $(this).val();
                var html = '';

                if (status === 'approved') {
                    html = `
                <div class="form-group">
                    <label for="refund_amount">Approved Refund Amount</label>
                    <input type="number" name="refund_amount" class="form-control" 
                           step="0.01" min="0" max="{{ $return->amount }}"
                           value="{{ $return->amount }}">
                </div>
                <div class="form-group">
                    <label for="refund_method">Refund Method</label>
                    <select name="refund_method" class="form-control">
                        <option value="original">Original Payment Method</option>
                        <option value="wallet">Store Credit/Wallet</option>
                        <option value="bank_transfer">Bank Transfer</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="pickup_date">Pickup Scheduled Date</label>
                    <input type="date" name="pickup_date" class="form-control" 
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                </div>
            `;
                } else if (status === 'pickup_scheduled') {
                    html = `
                <div class="form-group">
                    <label for="pickup_date">Pickup Date</label>
                    <input type="date" name="pickup_date" class="form-control" 
                           min="{{ date('Y-m-d') }}" required>
                </div>
            `;
                }

                $('#statusFields').html(html);
            });
        });
    </script>
@endpush
