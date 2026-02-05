@extends('layouts.app')

@section('title', 'Order #' . $order->order_number)

@section('content')
    <section class="order-details-page">
        <div class="container">
            <!-- Header Section -->
            <div class="row">
                <div class="col-12">
                    <div class="d-flex flex-column gap-3">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb" class="mb-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home') }}" class="text-decoration-none text-muted">
                                        <i class="fas fa-home me-1"></i>Home
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('orders') }}" class="text-decoration-none text-muted">My Orders</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Order #{{ $order->order_number }}
                                </li>
                            </ol>
                        </nav>

                        <!-- Order Header -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-receipt text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h1 class="fw-bold mb-1">Order #{{ $order->order_number }}</h1>
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="text-muted">
                                                <i class="far fa-calendar me-1"></i>
                                                {{ $order->created_at->format('F d, Y') }}
                                            </span>
                                            <span class="text-muted">
                                                <i class="far fa-clock me-1"></i>
                                                {{ $order->created_at->format('h:i A') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="text-end">
                                    <div class="text-muted small mb-1">Total Amount</div>
                                    <div class="h3 fw-bold text-primary mb-0">₹{{ number_format($order->total, 2) }}</div>
                                </div>
                                <span
                                    class="badge bg-{{ $order->status_badge }} bg-opacity-25 text-dark border border-{{ $order->status_badge }} rounded-pill px-4 py-3 fs-6">
                                    <i class="fas fa-circle-small me-2"></i>
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Left Column: Order Summary -->
                <div class="col-lg-8">
                    <!-- Order Summary Card -->
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                        <div class="card-header bg-white border-0 py-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0 fw-semibold">
                                    <i class="fas fa-file-invoice-dollar me-2 text-primary"></i>
                                    Order Summary
                                </h4>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill"
                                    onclick="window.print()">
                                    <i class="fas fa-print me-1"></i>Print Invoice
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="price-breakdown">
                                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                    <span class="text-muted">Subtotal ({{ $order->items->count() }} items)</span>
                                    <span class="fw-medium">₹{{ number_format($order->subtotal, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                    <span class="text-muted">Shipping & Handling</span>
                                    <span class="fw-medium">₹{{ number_format($order->shipping, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                    <span class="text-muted">Tax (GST 18%)</span>
                                    <span class="fw-medium">₹{{ number_format($order->tax, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-3">
                                    <span class="h5 fw-bold text-dark">Total Amount</span>
                                    <span class="h4 fw-bold text-primary">₹{{ number_format($order->total, 2) }}</span>
                                </div>
                            </div>

                            <!-- Quick Info Cards -->
                            <div class="row g-3 mt-4">
                                <div class="col-md-6">
                                    <div class="card border-0 bg-light bg-opacity-50 h-100 cursor-pointer"
                                        data-bs-toggle="modal" data-bs-target="#shippingModal">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                                    <i class="fas fa-truck text-primary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 fw-semibold">Shipping Info</h6>
                                                    <p class="text-muted small mb-0">View shipping details</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 bg-light bg-opacity-50 h-100 cursor-pointer"
                                        data-bs-toggle="modal" data-bs-target="#paymentModal">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="bg-success bg-opacity-10 rounded-circle p-2">
                                                    <i class="fas fa-credit-card text-success"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 fw-semibold">Payment Info</h6>
                                                    <p class="text-muted small mb-0">View payment details</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-0 py-4">
                            <h4 class="mb-0 fw-semibold">
                                <i class="fas fa-bolt me-2 text-primary"></i>
                                Quick Actions
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <button class="btn btn-outline-primary w-100 py-3 rounded-3" data-bs-toggle="modal"
                                        data-bs-target="#orderItemsModal">
                                        <i class="fas fa-shopping-bag me-2"></i>
                                        View All Items ({{ $order->items->count() }})
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('products') }}" class="btn btn-outline-dark w-100 py-3 rounded-3">
                                        <i class="fas fa-shopping-cart me-2"></i>
                                        Buy Again
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-outline-secondary w-100 py-3 rounded-3" onclick="window.print()">
                                        <i class="fas fa-print me-2"></i>
                                        Print Invoice
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Order Items Preview -->
                <div class="col-lg-4">
                    <!-- Order Items Preview Card -->
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-0 py-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0 fw-semibold">
                                    <i class="fas fa-boxes me-2 text-primary"></i>
                                    Order Items Preview
                                </h4>
                                <span class="badge bg-primary rounded-pill">{{ $order->items->count() }} items</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                @foreach ($order->items->take(6) as $item)
                                    <div class="col-6 col-md-4">
                                        <div class="product-card position-relative cursor-pointer" data-bs-toggle="modal"
                                            data-bs-target="#orderItemsModal">
                                            <div class="position-relative">
                                                @if ($item->product->image)
                                                    <img src="{{ asset('uploads/products/' . $item->product->image) }}"
                                                        alt="{{ $item->product_name }}" class="img-fluid rounded-3"
                                                        style="width: 100%; height: 100px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light bg-opacity-50 rounded-3 d-flex align-items-center justify-content-center"
                                                        style="height: 100px;">
                                                        <i class="fas fa-box text-muted fa-2x"></i>
                                                    </div>
                                                @endif
                                                <span
                                                    class="position-absolute top-0 end-0 translate-middle badge bg-primary rounded-circle px-2 py-1 m-1">
                                                    {{ $item->quantity }}
                                                </span>
                                            </div>
                                            <div class="mt-2">
                                                <h6 class="small fw-semibold mb-1 text-truncate">{{ $item->product_name }}
                                                </h6>
                                                <div class="small text-primary fw-bold">
                                                    ₹{{ number_format($item->total, 2) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                @if ($order->items->count() > 6)
                                    <div class="col-6 col-md-4">
                                        <div class="d-flex flex-column align-items-center justify-content-center border rounded-3 h-100 cursor-pointer"
                                            data-bs-toggle="modal" data-bs-target="#orderItemsModal"
                                            style="height: 140px;">
                                            <div class="bg-light bg-opacity-50 rounded-circle d-flex align-items-center justify-content-center mb-2"
                                                style="width: 60px; height: 60px;">
                                                <i class="fas fa-plus fa-lg text-muted"></i>
                                            </div>
                                            <span class="small text-muted">
                                                +{{ $order->items->count() - 6 }} more
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-4 pt-3 border-top">
                                <button class="btn btn-primary w-100 py-3 rounded-3 fw-semibold" data-bs-toggle="modal"
                                    data-bs-target="#orderItemsModal">
                                    <i class="fas fa-eye me-2"></i>
                                    View All Order Items
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Shipping Information Modal -->
    <div class="modal fade" id="shippingModal" tabindex="-1" aria-labelledby="shippingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4">
                <div class="modal-header border-0 pb-0">
                    <div class="w-100">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-truck text-primary fs-4"></i>
                            </div>
                            <div>
                                <h4 class="modal-title fw-bold" id="shippingModalLabel">Shipping Information</h4>
                                <p class="text-muted small mb-0">Order #{{ $order->order_number }}</p>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="shipping-info">
                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 mt-1">
                                <i class="fas fa-user text-primary"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">{{ $order->shipping_name }}</h6>
                                <p class="text-muted small mb-0">Recipient</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 mt-1">
                                <i class="fas fa-map-marker-alt text-primary"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-2">Shipping Address</h6>
                                <p class="mb-1">{{ $order->shipping_address }}</p>
                                <p class="mb-1">{{ $order->shipping_city }}, {{ $order->shipping_state }}</p>
                                <p class="mb-1">{{ $order->shipping_zip }}, {{ $order->shipping_country }}</p>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                        <i class="fas fa-phone text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="small text-muted">Phone Number</div>
                                        <div class="fw-medium">{{ $order->shipping_phone }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                        <i class="fas fa-envelope text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="small text-muted">Email Address</div>
                                        <div class="fw-medium">{{ $order->shipping_email }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-top pt-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                                        <i class="fas fa-shipping-fast text-warning"></i>
                                    </div>
                                    <div>
                                        <div class="small text-muted">Delivery Method</div>
                                        <div class="fw-medium">{{ ucfirst($order->shipping_method) }}</div>
                                    </div>
                                </div>
                                @if ($order->tracking_number)
                                    <div class="text-end">
                                        <div class="small text-muted mb-1">Tracking Number</div>
                                        <span class="badge bg-info bg-opacity-10 text-info border border-info px-3 py-2">
                                            {{ $order->tracking_number }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary px-4 rounded-3"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary px-4 rounded-3" onclick="window.print()">
                        <i class="fas fa-print me-2"></i>Print
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Information Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4">
                <div class="modal-header border-0 pb-0">
                    <div class="w-100">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-credit-card text-success fs-4"></i>
                            </div>
                            <div>
                                <h4 class="modal-title fw-bold" id="paymentModalLabel">Payment Information</h4>
                                <p class="text-muted small mb-0">Order #{{ $order->order_number }}</p>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="payment-info">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <div class="small text-muted mb-1">Payment Method</div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                        @if ($order->payment_method == 'credit_card')
                                            <i class="fas fa-credit-card text-primary"></i>
                                        @elseif($order->payment_method == 'paypal')
                                            <i class="fab fa-paypal text-primary"></i>
                                        @elseif($order->payment_method == 'cod')
                                            <i class="fas fa-money-bill-wave text-primary"></i>
                                        @else
                                            <i class="fas fa-wallet text-primary"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="h5 fw-bold mb-0 text-capitalize">{{ $order->payment_method }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-top pt-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div>
                                    <div class="small text-muted mb-1">Payment Status</div>
                                    <div class="d-flex align-items-center gap-2">
                                        <div
                                            class="bullet bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                        </div>
                                        <span class="fw-medium text-capitalize">{{ $order->payment_status }}</span>
                                    </div>
                                </div>
                                <span
                                    class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }} bg-opacity-25 text-dark border border-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }} rounded-pill px-3 py-2">
                                    <i
                                        class="fas fa-{{ $order->payment_status == 'paid' ? 'check-circle' : 'clock' }} me-1"></i>
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>

                            @if ($order->payment_status == 'paid')
                                <div class="bg-success bg-opacity-10 rounded-3 p-4 mb-4">
                                    <div class="text-center">
                                        <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                                            <i class="fas fa-check-circle text-success fs-3"></i>
                                            <span class="fw-bold">Payment Successful</span>
                                        </div>
                                        <p class="text-muted small mb-0">
                                            Your payment was completed on {{ $order->updated_at->format('F d, Y') }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <div class="bg-light bg-opacity-50 rounded-3 p-4">
                                <h6 class="fw-bold mb-3">Payment Summary</h6>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Order Amount</span>
                                    <span class="fw-medium">₹{{ number_format($order->subtotal, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Shipping & Tax</span>
                                    <span class="fw-medium">₹{{ number_format($order->shipping + $order->tax, 2) }}</span>
                                </div>
                                <hr class="my-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Total Paid</span>
                                    <span class="h5 fw-bold text-success">₹{{ number_format($order->total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary px-4 rounded-3"
                        data-bs-dismiss="modal">Close</button>
                    @if ($order->payment_status != 'paid')
                        <button type="button" class="btn btn-primary px-4 rounded-3">
                            <i class="fas fa-lock me-2"></i>Complete Payment
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items Modal -->
    <div class="modal fade" id="orderItemsModal" tabindex="-1" aria-labelledby="orderItemsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4">
                <div class="modal-body py-4">
                    <div class="card border-0 shadow-sm">
                        <!-- Modified header with flex layout -->
                        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-shopping-bag me-2 text-primary"></i>Order Items</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4 py-3" style="min-width: 300px;">PRODUCT</th>
                                            <th class="py-3 text-center">PRICE</th>
                                            <th class="py-3 text-center">QTY</th>
                                            <th class="py-3 text-center">TOTAL</th>
                                            <th class="pe-4 py-3 text-center" style="min-width: 150px;">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->items as $item)
                                            <tr class="border-bottom">
                                                <!-- Product Column -->
                                                <td class="ps-4 py-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-3">
                                                            @if ($item->product->image)
                                                                <img src="{{ asset('uploads/products/' . $item->product->image) }}"
                                                                    alt="{{ $item->product_name }}"
                                                                    class="rounded-3 border"
                                                                    style="width: 80px; height: 80px; object-fit: cover;">
                                                            @else
                                                                <div class="bg-light bg-opacity-50 rounded-3 border d-flex align-items-center justify-content-center"
                                                                    style="width: 80px; height: 80px;">
                                                                    <i class="fas fa-box text-muted"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="fw-bold mb-1">{{ $item->product_name }}</h6>
                                                            <div class="text-muted small mb-1">
                                                                <i class="fas fa-tag me-1"></i>
                                                                {{ $item->category_name }}
                                                            </div>
                                                            @if ($item->product->sku)
                                                                <div class="text-muted small">
                                                                    <i class="fas fa-barcode me-1"></i>
                                                                    SKU: {{ $item->product->sku }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>

                                                <!-- Price Column -->
                                                <td class="text-center py-4">
                                                    <div class="fw-medium">₹{{ number_format($item->price, 2) }}</div>
                                                    <div class="text-muted small">Unit Price</div>
                                                </td>

                                                <!-- Quantity Column -->
                                                <td class="text-center py-4">
                                                    <div
                                                        class="quantity-badge d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1">
                                                        <i class="fas fa-times me-1 small"></i>
                                                        <span class="fw-bold">{{ $item->quantity }}</span>
                                                    </div>
                                                </td>

                                                <!-- Total Column -->
                                                <td class="text-center py-4">
                                                    <div class="h5 fw-bold text-primary mb-0">
                                                        ₹{{ number_format($item->total, 2) }}</div>
                                                    <div class="text-muted small">Item Total</div>
                                                </td>

                                                <!-- Actions Column -->
                                                <td class="pe-4 py-4 text-center">
                                                    @if ($item->product->stock_status == 'in_stock')
                                                        <a href="{{ route('product.show', $item->product_id) }}"
                                                            class="btn btn-sm btn-outline-primary d-inline-flex align-items-center">
                                                            <i class="fas fa-shopping-cart me-1"></i>
                                                            <span>Buy Again</span>
                                                        </a>
                                                    @else
                                                        <span
                                                            class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2">
                                                            <i class="fas fa-ban me-1"></i>Out of Stock
                                                        </span>
                                                    @endif
                                                    <div class="mt-2">
                                                        <a href="{{ route('product.show', $item->product_id) }}"
                                                            class="btn btn-sm btn-outline-secondary">
                                                            <i class="fas fa-eye me-1"></i>View
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        @if ($order->items->count() > 0)
                                            <tr class="bg-light">
                                                <td colspan="3" class="text-end ps-4 py-3">
                                                    <div class="fw-bold">Order Total:</div>
                                                </td>
                                                <td class="text-end pe-4 py-3">
                                                    <div class="fw-bold"> ₹{{ number_format($order->total, 2) }}</div>
                                                </td>
                                                <td class="pe-4 py-3"></td>
                                            </tr>
                                        @endif
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .order-details-page {
                min-height: calc(100vh - 200px);
            }

            .bullet {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                display: inline-block;
            }

            .cursor-pointer {
                cursor: pointer;
            }

            .product-card:hover {
                transform: translateY(-3px);
                transition: transform 0.2s ease;
            }

            .card {
                transition: transform 0.3s ease;
            }

            .card:hover {
                transform: translateY(-2px);
            }

            .rounded-4 {
                border-radius: 1rem !important;
            }

            .btn-outline-dark:hover {
                background-color: #212529;
                color: white;
            }

            .modal-content {
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            }

            .modal-header .btn-close {
                margin: 0;
            }

            .order-items-grid {
                max-height: 60vh;
                overflow-y: auto;
                padding-right: 10px;
            }

            .order-items-grid::-webkit-scrollbar {
                width: 6px;
            }

            .order-items-grid::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }

            .order-items-grid::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 10px;
            }

            .order-items-grid::-webkit-scrollbar-thumb:hover {
                background: #555;
            }
        </style>
    @endpush
@endsection
