@extends('admin.layouts.app')

@section('title', 'Order Details')

@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-primary">Order Details</h1>
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
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-boxes me-2"></i> Order Items ({{ $order->items->count() }})
                        </h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#orderItemsModal">
                            <i class="fas fa-expand-alt me-2"></i> View Details
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items Modal -->
        <div class="modal fade" id="orderItemsModal" tabindex="-1" aria-labelledby="orderItemsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content border-0">
                    <!-- Modal Header -->
                    <div class="modal-header bg-primary text-white px-4 py-3 border-0">
                        <div class="d-flex align-items-center w-100">
                            <div class="flex-grow-1">
                                <h5 class="modal-title mb-0" id="orderItemsModalLabel">
                                    <i class="fas fa-boxes me-2"></i> Order Items Details
                                    <span class="badge bg-white text-primary ms-2">{{ $order->items->count() }}
                                        items</span>
                                </h5>
                            </div>
                            <button type="button" class="btn-close btn-close-white m-0" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body p-4">
                        <!-- Order Summary -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                                <i class="bi bi-receipt text-primary fs-4"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 text-muted">Order Reference</h6>
                                                <p class="fw-bold text-dark mb-0 fs-5">{{ $order->order_number ?? 'N/A' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 p-3 rounded-3 me-3">
                                                <i class="bi bi-currency-rupee text-success fs-4"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 text-muted">Grand Total</h6>
                                                <p class="fw-bold text-success mb-0 fs-5">
                                                    ₹{{ number_format($order->items->sum('total'), 2) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Scrollable Table Container -->
                        <div class="border rounded-3 shadow-sm overflow-hidden">
                            <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light sticky-top" style="top: 0; z-index: 1;">
                                        <tr>
                                            <th class="ps-4 py-3 align-middle fw-semibold text-dark border-bottom"
                                                width="5%">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                                        <i class="bi bi-hash text-primary fs-6"></i>
                                                    </div>
                                                    <span>Sr</span>
                                                </div>
                                            </th>
                                            <th class="py-3 align-middle fw-semibold text-dark border-bottom"
                                                width="15%">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                                        <i class="bi bi-image text-primary fs-6"></i>
                                                    </div>
                                                    <span>Image</span>
                                                </div>
                                            </th>
                                            <th class="py-3 align-middle fw-semibold text-dark border-bottom"
                                                width="25%">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                                        <i class="bi bi-box-seam text-primary fs-6"></i>
                                                    </div>
                                                    <span>Product Details</span>
                                                </div>
                                            </th>
                                            <th class="py-3 align-middle fw-semibold text-dark border-bottom"
                                                width="15%">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                                        <i class="bi bi-tags text-primary fs-6"></i>
                                                    </div>
                                                    <span>Category</span>
                                                </div>
                                            </th>
                                            <th class="py-3 align-middle fw-semibold text-dark border-bottom"
                                                width="10%">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                                        <i class="bi bi-currency-rupee text-primary fs-6"></i>
                                                    </div>
                                                    <span>Price</span>
                                                </div>
                                            </th>
                                            <th class="py-3 align-middle fw-semibold text-dark border-bottom text-center"
                                                width="10%">
                                                <div class="d-flex align-items-center gap-2 justify-content-center">
                                                    <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                                        <i class="bi bi-box text-primary fs-6"></i>
                                                    </div>
                                                    <span>Qty</span>
                                                </div>
                                            </th>
                                            <th class="py-3 align-middle fw-semibold text-dark border-bottom text-end pe-4"
                                                width="15%">
                                                <div class="d-flex align-items-center gap-2 justify-content-end">
                                                    <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                                                        <i class="bi bi-calculator text-primary fs-6"></i>
                                                    </div>
                                                    <span>Total</span>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->items as $item)
                                            <tr class="border-bottom">
                                                <!-- Serial Number -->
                                                <td class="ps-4 py-3 align-middle">
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <span
                                                            class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-circle d-flex align-items-center justify-content-center"
                                                            style="width: 36px; height: 36px;">
                                                            {{ $loop->iteration }}
                                                        </span>
                                                    </div>
                                                </td>

                                                <!-- Image -->
                                                <td class="py-3 align-middle">
                                                    <div class="d-flex justify-content-center">
                                                        @if ($item->product->image)
                                                            <div class="position-relative">
                                                                <img src="{{ asset('uploads/products/' . $item->product->image) }}"
                                                                    alt="{{ $item->product_name }}"
                                                                    class="img-fluid rounded-3 shadow-sm"
                                                                    style="width: 70px; height: 70px; object-fit: cover;">
                                                                <span
                                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                                                    {{ $item->quantity }}
                                                                </span>
                                                            </div>
                                                        @else
                                                            <div class="bg-light rounded-3 d-flex flex-column align-items-center justify-content-center shadow-sm p-2"
                                                                style="width: 70px; height: 70px;">
                                                                <i class="fas fa-box text-muted fs-4 mb-1"></i>
                                                                <small class="text-muted">Qty:
                                                                    {{ $item->quantity }}</small>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>

                                                <!-- Product Details -->
                                                <td class="py-3 align-middle">
                                                    <div class="d-flex flex-column">
                                                        <h6 class="fw-bold text-dark mb-1">{{ $item->product_name }}</h6>
                                                        <div class="d-flex align-items-center gap-3 mb-2">
                                                            <small class="text-muted">
                                                                <i class="bi bi-upc-scan me-1"></i>
                                                                <strong>SKU:</strong> {{ $item->product->id ?? 'N/A' }}
                                                            </small>
                                                            @if ($item->product->brand ?? false)
                                                                <small class="text-muted">
                                                                    <i class="bi bi-tag me-1"></i>
                                                                    <strong>Brand:</strong> {{ $item->product->brand }}
                                                                </small>
                                                            @endif
                                                        </div>
                                                        @if ($item->product->description ?? false)
                                                            <div class="mt-1">
                                                                <small class="text-muted">
                                                                    <i class="bi bi-text-paragraph me-1"></i>
                                                                    {{ Str::limit($item->product->description, 80) }}
                                                                </small>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>

                                                <!-- Category -->
                                                <td class="py-3 align-middle">
                                                    <div class="d-flex justify-content-center">
                                                        <span
                                                            class="badge bg-primary bg-opacity-10 text-primary border border-primary py-2 px-3 rounded-pill">
                                                            <i class="bi bi-tag me-1"></i>
                                                            {{ $item->category_name }}
                                                        </span>
                                                    </div>
                                                </td>

                                                <!-- Price -->
                                                <td class="py-3 align-middle">
                                                    <div class="d-flex flex-column align-items-start">
                                                        <div class="d-flex align-items-center gap-1">
                                                            <i class="bi bi-currency-rupee text-success fs-6"></i>
                                                            <span
                                                                class="fw-bold text-dark fs-5">{{ number_format($item->price, 2) }}</span>
                                                        </div>
                                                        <small class="text-muted">per unit</small>
                                                    </div>
                                                </td>

                                                <!-- Quantity -->
                                                <td class="py-3 align-middle text-center">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <span
                                                            class="badge bg-secondary bg-opacity-25 text-secondary border border-secondary py-2 px-3 fw-bold fs-6 rounded-pill">
                                                            {{ $item->quantity }}
                                                        </span>
                                                        <small class="text-muted mt-1">units</small>
                                                    </div>
                                                </td>

                                                <!-- Total -->
                                                <td class="py-3 align-middle text-end pe-4">
                                                    <div class="d-flex flex-column align-items-end">
                                                        <div class="d-flex align-items-center gap-1">
                                                            <i class="bi bi-currency-rupee text-primary fs-5"></i>
                                                            <span
                                                                class="fw-bold text-primary fs-4">{{ number_format($item->total, 2) }}</span>
                                                        </div>
                                                        <small class="text-muted">item total</small>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Summary Card -->
                        {{-- <div class="card border-0 shadow-sm bg-light mt-4">
                            <div class="card-body p-3">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                                                <i class="bi bi-box-seam text-primary fs-4"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-muted">Total Items</h6>
                                                <p class="fw-bold text-dark mb-0 fs-4">{{ $order->items->count() }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <div class="me-3 text-end">
                                                <h6 class="mb-1 text-muted">Grand Total</h6>
                                                <p class="fw-bold text-success mb-0 fs-3">
                                                    ₹{{ number_format($order->items->sum('total'), 2) }}
                                                </p>
                                            </div>
                                            <div class="bg-success bg-opacity-10 p-3 rounded-3">
                                                <i class="bi bi-currency-rupee text-success fs-3"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer bg-light px-4 py-3 border-top">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            /* Custom scrollbar for table */
            .table-responsive::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }

            .table-responsive::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }

            .table-responsive::-webkit-scrollbar-thumb {
                background: #c1c1c1;
                border-radius: 10px;
            }

            .table-responsive::-webkit-scrollbar-thumb:hover {
                background: #a1a1a1;
            }

            /* Sticky header styles */
            .sticky-top {
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            /* Smooth hover effect */
            .table-hover tbody tr:hover {
                background-color: rgba(13, 110, 253, 0.04) !important;
                transition: background-color 0.2s ease;
            }
        </style>

        <script>
            function printOrderItems() {
                // You can implement print functionality here
                window.print();
            }
        </script>
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
