@extends('admin.layouts.app')

@section('title', 'Order Details')

@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Order Details</h1>
                <nav style="--bs-breadcrumb-divider: '›';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.orders') }}">Orders</a></li>
                        <li class="breadcrumb-item active">#{{ $order->order_number }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-3">
                <a href="{{ route('admin.orders') }}" class="btn btn-outline-secondary d-flex align-items-center">
                    <i class="fas fa-arrow-left me-2"></i>
                    <span>Back to Orders</span>
                </a>

                <a href="{{ route('admin.order.export', $order->id) }}" class="btn btn-success d-flex align-items-center">
                    <i class="fas fa-file-excel me-2"></i>
                    <span>Export to Excel</span>
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Order Summary -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow border-0 h-100">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-6">
                                <p class="mb-1 text-muted small">Order Number</p>
                                <p class="fw-bold">{{ $order->order_number }}</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1 text-muted small">Order Date</p>
                                <p class="fw-bold">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <p class="mb-1 text-muted small">Payment Method</p>
                                <span class="badge bg-info text-capitalize">{{ $order->payment_method }}</span>
                            </div>
                            <div class="col-6">
                                <p class="mb-1 text-muted small">Payment Status</p>
                                <span
                                    class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }} text-capitalize">
                                    {{ $order->payment_status }}
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <p class="mb-1 text-muted small">Shipping Method</p>
                                <p class="fw-bold text-capitalize">{{ $order->shipping_method }} Delivery</p>
                            </div>
                        </div>

                        <hr>

                        <div class="price-summary">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span>₹{{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping</span>
                                <span>₹{{ number_format($order->shipping, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax</span>
                                <span>₹{{ number_format($order->tax, 2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Total</h5>
                                <h4 class="mb-0 text-primary">₹{{ number_format($order->total, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow border-0 h-100">
                    <div class="card-header bg-info text-white py-3">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i> Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="customer-info">
                            <div class="d-flex align-items-center mb-3">
                                @if ($order->user->profile_image)
                                    <img src="{{ asset('storage/profile-images/' . $order->user->profile_image) }}"
                                        alt="{{ $order->user->name }}" class="rounded-circle me-3"
                                        style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 60px; height: 60px; font-size: 20px;">
                                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <h5 class="mb-0">{{ $order->user->name }}</h5>
                                    <p class="text-muted mb-0">{{ $order->user->email }}</p>
                                    <p class="text-muted mb-0">{{ $order->user->phone ?? 'No phone' }}</p>
                                </div>
                            </div>

                            <h6 class="fw-bold mt-4 mb-3">Shipping Address</h6>
                            <div class="bg-light p-3 rounded">
                                <p class="mb-1"><strong>{{ $order->shipping_name }}</strong></p>
                                <p class="mb-1">{{ $order->shipping_address }}</p>
                                <p class="mb-1">{{ $order->shipping_city }}, {{ $order->shipping_state }}</p>
                                <p class="mb-1">{{ $order->shipping_zip }}, {{ $order->shipping_country }}</p>
                                <p class="mb-1"><i class="fas fa-phone me-2"></i>{{ $order->shipping_phone }}</p>
                                <p class="mb-0"><i class="fas fa-envelope me-2"></i>{{ $order->shipping_email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Status & Actions -->
            <!-- Order Status & Actions -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow border-0 h-100">
                    <div class="card-header bg-warning text-dark py-3">
                        <h5 class="mb-0"><i class="fas fa-cog me-2"></i> Order Actions</h5>
                    </div>
                    <div class="card-body">
                        <!-- Current Status -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Current Status</h6>
                            <div class="text-center">
                                @php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'processing' => 'info',
                                        'shipped' => 'primary',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger',
                                    ];
                                @endphp
                                <span class="badge bg-{{ $statusColors[$order->status] }} px-4 py-2 fs-6">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Update Status -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Update Status</h6>
                            <div class="row g-2">
                                <!-- Column 1 -->
                                <div class="col-6">
                                    <form action="{{ route('admin.order.status.update', $order->id) }}" method="POST"
                                        class="d-inline w-100">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="pending">
                                        <button type="submit" class="btn btn-outline-warning w-100">
                                            <i class="fas fa-clock me-2"></i> Pending
                                        </button>
                                    </form>
                                </div>

                                <!-- Column 2 -->
                                <div class="col-6">
                                    <form action="{{ route('admin.order.status.update', $order->id) }}" method="POST"
                                        class="d-inline w-100">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="processing">
                                        <button type="submit" class="btn btn-outline-info w-100">
                                            <i class="fas fa-cog me-2"></i> Processing
                                        </button>
                                    </form>
                                </div>

                                <!-- Column 1 -->
                                <div class="col-6">
                                    <form action="{{ route('admin.order.status.update', $order->id) }}" method="POST"
                                        class="d-inline w-100">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="shipped">
                                        <button type="submit" class="btn btn-outline-primary w-100">
                                            <i class="fas fa-truck me-2"></i> Shipped
                                        </button>
                                    </form>
                                </div>

                                <!-- Column 2 -->
                                <div class="col-6">
                                    <form action="{{ route('admin.order.status.update', $order->id) }}" method="POST"
                                        class="d-inline w-100">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="delivered">
                                        <button type="submit" class="btn btn-outline-success w-100">
                                            <i class="fas fa-check-circle me-2"></i> Delivered
                                        </button>
                                    </form>
                                </div>

                                <!-- Full width for Cancel -->
                                <div class="col-12">
                                    <form action="{{ route('admin.order.status.update', $order->id) }}" method="POST"
                                        class="d-inline w-100">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="btn btn-outline-danger w-100 mt-2">
                                            <i class="fas fa-times-circle me-2"></i> Cancel Order
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div>
                            <h6 class="fw-bold mb-3">Quick Actions</h6>
                            <div class="d-grid gap-2">
                                <button class="btn btn-success" onclick="sendEmail('{{ $order->id }}')">
                                    <i class="fas fa-envelope me-2"></i> Send Email Update
                                </button>
                                <a href="{{ route('admin.order.invoice', $order->id) }}" class="btn btn-primary">
                                    <i class="fas fa-file-invoice me-2"></i> Download Invoice
                                </a>
                                <button class="btn btn-info" onclick="addNote('{{ $order->id }}')">
                                    <i class="fas fa-sticky-note me-2"></i> Add Note
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-boxes me-2"></i> Order Items ({{ $order->items->count() }})
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr class="bg-light bg-gradient border-bottom border-3">
                                        <th class="ps-5 py-3 align-middle fw-semibold text-dark" width="5%">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                                    <i class="bi  text-primary fs-6">Sr</i>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold"></span>
                                                    <small class="text-muted"> No</small>
                                                </div>
                                            </div>
                                        </th>
                                        <th class="py-3 align-middle fw-semibold text-dark" width="15%">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                                    <i class="bi bi-image text-primary fs-6"></i>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold">Image</span>
                                                    <small class="text-muted">Preview</small>
                                                </div>
                                            </div>
                                        </th>
                                        <th class="py-3 align-middle fw-semibold text-dark">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                                    <i class="bi bi-box-seam text-primary fs-6"></i>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold">Product</span>
                                                    <small class="text-muted">Details</small>
                                                </div>
                                            </div>
                                        </th>
                                        <th class="py-3 align-middle fw-semibold text-dark" width="15%">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                                    <i class="bi bi-tags text-primary fs-6"></i>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold">Category</span>
                                                    <small class="text-muted">Type</small>
                                                </div>
                                            </div>
                                        </th>
                                        <th class="py-3 align-middle fw-semibold text-dark" width="10%">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                                    <i class="bi bi-currency-rupee text-primary fs-6"></i>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold">Price</span>
                                                    <small class="text-muted">Unit</small>
                                                </div>
                                            </div>
                                        </th>
                                        <th class="py-3 align-middle fw-semibold text-dark" width="10%">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                                    <i class="bi bi-box text-primary fs-6"></i>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold">Quantity</span>
                                                    <small class="text-muted">Qty</small>
                                                </div>
                                            </div>
                                        </th>
                                        <th class="py-3 align-middle fw-semibold text-dark" width="15%">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                                    <i class="bi bi-calculator text-primary fs-6"></i>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold">Total</span>
                                                    <small class="text-muted">Amount</small>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td class="ps-4 py-3 align-middle">
                                                <span
                                                    class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-3 py-1 fw-medium">
                                                    {{ $loop->iteration }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($item->product->image)
                                                    <img src="{{ asset('uploads/products/' . $item->product->image) }}"
                                                        alt="{{ $item->product_name }}" class="img-fluid rounded"
                                                        style="width: 60px; height: 60px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                        style="width: 60px; height: 60px;">
                                                        <i class="fas fa-box text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="py-3 align-middle">
                                                <div>
                                                    <h6 class="fw-semibold text-dark mb-1">{{ $item->product_name }}</h6>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <small class="text-muted">
                                                            <i class="bi bi-upc-scan me-1"></i>
                                                            SKU: {{ $item->product->id ?? 'N/A' }}
                                                        </small>
                                                        @if ($item->product->description ?? false)
                                                            <small class="text-muted">
                                                                <i class="bi bi-text-paragraph me-1"></i>
                                                                {{ Str::limit($item->product->description, 30) }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <!-- Category -->
                                            <td class="py-3 align-middle">
                                                <span
                                                    class="badge bg-primary bg-opacity-10 text-primary border border-primary py-2 px-3">
                                                    <i class="bi bi-tag me-1"></i>
                                                    {{ $item->category_name }}
                                                </span>
                                            </td>

                                            <!-- Price -->
                                            <td class="py-3 align-middle">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-currency-rupee text-success"></i>
                                                    <span
                                                        class="fw-semibold text-dark">{{ number_format($item->price, 2) }}</span>
                                                </div>
                                            </td>

                                            <!-- Quantity -->
                                            <td class="py-3 align-middle text-center">
                                                <span
                                                    class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary py-2 px-3 fw-medium">
                                                    {{ $item->quantity }}
                                                </span>
                                            </td>

                                            <!-- Total -->
                                            <td class="py-3 align-middle">
                                                <div class="d-flex align-items-center gap-2 justify-content-end">
                                                    <i class="bi bi-currency-rupee text-primary"></i>
                                                    <span
                                                        class="fw-bold text-primary fs-5">{{ number_format($item->total, 2) }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function printInvoice() {
            window.open('{{ route('admin.order.invoice', $order->id) }}?print=true', '_blank');
        }

        function updateStatus(orderId, status) {
            if (confirm('Are you sure you want to update the order status?')) {
                fetch(`/admin/orders/${orderId}/status`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            status: status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Error updating status');
                        }
                    });
            }
        }

        function sendEmail(orderId) {
            const message = prompt('Enter email message:');
            if (message) {
                fetch(`/admin/orders/${orderId}/email`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message: message
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Email sent successfully');
                        }
                    });
            }
        }

        function addNote(orderId) {
            const note = prompt('Add a note for this order:');
            if (note) {
                fetch(`/admin/orders/${orderId}/note`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            note: note
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Note added successfully');
                        }
                    });
            }
        }
    </script>
@endpush
