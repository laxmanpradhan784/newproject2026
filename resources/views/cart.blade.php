{{-- resources/views/user/cart.blade.php --}}
@extends('layouts.app')

@section('title', 'My Cart')

@section('content')
    <!-- Flipkart Style Cart Page -->
    <section class="cart-page py-4 bg-light">
        <div class="container pt-5">
            <!-- Breadcrumb -->
            <div class="row mb-4">
                <div class="col-12">
                    <nav style="--bs-breadcrumb-divider: '›';" aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                        </ol>
                        <h2 class="fw-bold mb-0">My Cart @if ($cartCount > 0)
                                <span class="text-muted fs-6">({{ $cartCount }} items)</span>
                            @endif
                        </h2>
                    </nav>
                </div>
            </div>

            <!-- Guest User Notification -->
            @if (!auth()->check() && $cartCount > 0)
                <div class="alert alert-info border-0 rounded-3 mb-3 py-2 px-3 mx-auto text-center auto-dismiss"
                    role="alert" style="max-width: 400px; background-color: rgba(13, 202, 240, 0.1);"
                    data-dismiss-delay="4000">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center justify-content-center w-100">
                            <i class="fas fa-user-clock me-2 text-info" style="font-size: 0.9rem;"></i>
                            <div>
                                <small class="fw-bold d-block">Guest Shopping</small>
                                <small class="d-block">
                                    <a href="{{ route('login') }}" class="text-info fw-bold">Login</a> to save cart
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const alerts = document.querySelectorAll('.auto-dismiss');
                        alerts.forEach(alert => {
                            const delay = alert.getAttribute('data-dismiss-delay') || 1000;
                            setTimeout(() => {
                                const bsAlert = new bootstrap.Alert(alert);
                                bsAlert.close();
                            }, delay);
                        });
                    });
                </script>
            @endif

            <!-- Cart Merge Success Message -->
            @if (session('cart_merged_message'))
                <div class="alert alert-success alert-dismissible fade show rounded-2 mb-3 py-2 px-3 mx-auto auto-dismiss"
                    role="alert" data-dismiss-delay="3000"
                    style="max-width: 500px; background-color: rgba(25, 135, 84, 0.08);">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-2 text-success" style="font-size: 1rem;"></i>
                            <div>
                                <strong class="d-block mb-1" style="font-size: 0.9rem;">Cart Merged Successfully!</strong>
                                <p class="mb-0" style="font-size: 0.85rem; line-height: 1.3;">
                                    {{ session('cart_merged_message') }}
                                </p>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-sm ms-2" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <div class="row g-4">
                <!-- Left Column: Cart Items -->
                <div class="col-lg-8">
                    @if ($cartItems->count() > 0)
                        <!-- Modern Coupon Section -->
                        <div class="card rounded-3 shadow-sm border-0 mb-4">
                            <div class="card-header bg-white border-0 py-3 px-4">
                                <h6 class="fw-bold mb-0 d-flex align-items-center">
                                    <i class="fas fa-tag text-primary me-2"></i>
                                    Apply Coupon Code
                                </h6>
                            </div>
                            <div class="card-body p-4">
                                <!-- Coupon Messages -->
                                @if (session('coupon_error'))
                                    <div class="alert alert-danger alert-dismissible fade show rounded-2 mb-3 p-2"
                                        role="alert">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-exclamation-circle me-2 fa-sm"></i>
                                            <div class="small">{{ session('coupon_error') }}</div>
                                            <button type="button" class="btn-close btn-close-sm ms-auto"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    </div>
                                @endif

                                @if (session('coupon_success'))
                                    <div class="alert alert-success alert-dismissible fade show rounded-2 mb-3 p-2"
                                        role="alert">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-check-circle me-2 fa-sm"></i>
                                            <div class="small">{{ session('coupon_success') }}</div>
                                            <button type="button" class="btn-close btn-close-sm ms-auto"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    </div>
                                @endif

                                <!-- Coupon Form -->
                                <div class="coupon-form mb-3">
                                    <form action="{{ route('coupon.apply') }}" method="POST"
                                        class="row g-2 align-items-center">
                                        @csrf
                                        <div class="col-md-8">
                                            <div class="input-group input-group-sm">
                                                <input type="text" name="coupon_code"
                                                    class="form-control border-end-0 rounded-start-2 py-2 px-3"
                                                    placeholder="Enter coupon code"
                                                    value="{{ session('applied_coupon_code') ?? old('coupon_code') }}"
                                                    {{ session('applied_coupon_code') ? 'readonly' : '' }}
                                                    style="height: 40px;">
                                                @if (session('applied_coupon_code'))
                                                    <a href="{{ route('coupon.remove') }}"
                                                        class="btn btn-outline-danger border-start-0 rounded-end-2 px-3"
                                                        style="height: 40px;">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                @else
                                                    <button type="submit"
                                                        class="btn btn-primary border-start-0 rounded-end-2 px-3"
                                                        style="height: 40px;">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-outline-primary w-100 rounded-2 py-2"
                                                data-bs-toggle="modal" data-bs-target="#couponModal">
                                                <i class="fas fa-eye me-1 fa-sm"></i> View Coupons
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Applied Coupon Display -->
                                @if ($appliedCoupon)
                                    <div class="applied-coupon p-2 bg-light border border-success rounded-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="d-flex align-items-center mb-1">
                                                    <span class="badge bg-success rounded-pill me-2"
                                                        style="font-size: 0.7rem;">APPLIED</span>
                                                    <strong class="text-dark small">{{ $appliedCoupon['code'] }}</strong>
                                                </div>
                                                <p class="text-muted small mb-0" style="font-size: 0.8rem;">
                                                    {{ $appliedCoupon['name'] }}</p>
                                            </div>
                                            <div class="text-end">
                                                <div class="text-success fw-bold">
                                                    -₹{{ number_format($appliedCoupon['discount_amount'], 2) }}</div>
                                                <small class="text-muted" style="font-size: 0.75rem;">
                                                    @if ($appliedCoupon['discount_type'] == 'percentage')
                                                        {{ $appliedCoupon['discount_value'] }}% OFF
                                                    @else
                                                        Flat ₹{{ $appliedCoupon['discount_value'] }} OFF
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Add this CSS for better spacing -->
                        <style>
                            .coupon-form .input-group {
                                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
                            }

                            .applied-coupon {
                                border-left: 3px solid #28a745 !important;
                            }

                            .btn-close-sm {
                                padding: 0.25rem;
                                background-size: 0.75rem;
                            }

                            .form-control:focus {
                                border-color: #86b7fe;
                                box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
                            }
                        </style>

                        <!-- Cart Items -->
                        <div class="card rounded-3 shadow-sm border-0">
                            <div class="card-body p-0">
                                @foreach ($cartItems as $item)
                                    <div class="cart-item p-4 border-bottom">
                                        <div class="row align-items-center">
                                            <div class="col-3 col-md-2">
                                                <div class="position-relative">
                                                    @if ($item->product->image)
                                                        <img src="{{ asset('uploads/products/' . $item->product->image) }}"
                                                            alt="{{ $item->product->name }}" class="img-fluid rounded-2"
                                                            style="width: 120px; height: 120px; object-fit: contain;">
                                                    @else
                                                        <div class="bg-light rounded-2 d-flex align-items-center justify-content-center"
                                                            style="width: 120px; height: 120px;">
                                                            <i class="fas fa-box text-muted fa-2x"></i>
                                                        </div>
                                                    @endif
                                                    @if ($item->product->stock <= 5 && $item->product->stock > 0)
                                                        <span class="badge bg-warning position-absolute top-0 start-0 m-1">
                                                            Only {{ $item->product->stock }} left
                                                        </span>
                                                    @endif
                                                    @if ($item->product->stock == 0)
                                                        <span class="badge bg-danger position-absolute top-0 start-0 m-1">
                                                            Out of Stock
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-9 col-md-10">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <h6 class="fw-bold mb-1">{{ $item->product->name }}</h6>
                                                        <p class="text-muted small mb-2">
                                                            @if ($item->product->category)
                                                                Category: {{ $item->product->category->name }}
                                                            @endif
                                                        </p>
                                                        <div class="d-flex align-items-center mb-2">
                                                            <span class="badge bg-success rounded-pill me-2">
                                                                <i class="fas fa-star fa-xs me-1"></i>4.3
                                                            </span>
                                                            <span class="text-muted small">25,000+ ratings</span>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <span
                                                                class="fs-5 fw-bold text-dark">₹{{ $item->price }}</span>
                                                            <span
                                                                class="text-muted text-decoration-line-through ms-2">₹{{ $item->price + 99 }}</span>
                                                            <span
                                                                class="text-success fw-medium ms-2">{{ round(($item->price / ($item->price + 99)) * 100) }}%
                                                                off</span>
                                                        </div>
                                                        <p class="text-success small mt-1 mb-0">
                                                            <i class="fas fa-check-circle me-1"></i>Free delivery
                                                        </p>
                                                        <!-- Show if this was a guest item now merged -->
                                                        @if ($item->is_guest && auth()->check())
                                                            <span class="badge bg-info mt-1">Merged from Guest Cart</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-4 mt-3 mt-md-0">
                                                        <!-- Quantity Selector -->
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="quantity-selector">
                                                                <form action="{{ route('cart.update', $item->id) }}"
                                                                    method="POST" class="update-quantity-form">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="input-group" style="width: 140px;">
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary border-end-0 decrement px-3">
                                                                            <i class="fas fa-minus"></i>
                                                                        </button>
                                                                        <input type="number" name="quantity"
                                                                            value="{{ $item->quantity }}" min="1"
                                                                            max="{{ min(10, $item->product->stock) }}"
                                                                            class="form-control text-center border-start-0 border-end-0 quantity-input px-1"
                                                                            style="height: 45px;"
                                                                            data-item-id="{{ $item->id }}">
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary border-start-0 increment px-3">
                                                                            <i class="fas fa-plus"></i>
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <form action="{{ route('cart.remove', $item->id) }}"
                                                                method="POST" class="remove-item-form ms-3">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-link text-danger p-0"
                                                                    title="Remove item">
                                                                    <i class="fas fa-trash-alt fa-lg"></i>
                                                                </button>
                                                            </form>
                                                        </div>

                                                        <!-- Subtotal -->
                                                        <div class="mt-3 text-end">
                                                            <p class="mb-0 text-muted small">Subtotal</p>
                                                            <h5 class="text-dark fw-bold mb-0">
                                                                ₹{{ $item->price * $item->quantity }}</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Cart Footer -->
                            <div class="card-footer bg-white border-0 p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('products') }}" class="btn btn-outline-dark rounded-pill px-4">
                                        <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                                    </a>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="text-end">
                                            <p class="mb-1 text-muted">Total ({{ $cartCount }} items)</p>
                                            <h4 class="text-dark fw-bold mb-0">₹{{ number_format($subtotal, 2) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Empty Cart -->
                        <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
                            <div class="card rounded-3 shadow-sm border-0 text-center"
                                style="min-height: 30vh;margin-right: -339px;">
                                <div class="card-body p-5">
                                    <div class="empty-cart-icon mb-4">
                                        <i class="fas fa-shopping-cart fa-5x text-muted"></i>
                                    </div>
                                    <h3 class="fw-bold mb-3">Your cart is empty!</h3>
                                    <p class="text-muted mb-4">Looks like you haven't added anything to your cart yet.</p>
                                    <a href="{{ route('products') }}" class="btn btn-primary rounded-pill px-5 py-2">
                                        <i class="fas fa-shopping-bag me-2"></i> Shop Now
                                    </a>

                                    @if (!auth()->check())
                                        <div class="mt-4">
                                            <p class="text-muted small mb-2">Already have items in another browser?</p>
                                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-sign-in-alt me-1"></i> Login to access your saved cart
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    @endif
                </div>

                <!-- Right Column: Order Summary -->
                @if ($cartItems->count() > 0)
                    <div class="col-lg-4">
                        <!-- Price Details Card -->
                        <div class="card rounded-3 shadow-sm border-0 sticky-top" style="top: 20px;">
                            <div class="card-header bg-white border-0 pt-4 pb-3">
                                <h5 class="fw-bold mb-0">Price Details</h5>
                            </div>
                            <div class="card-body pt-0">
                                <!-- Price Breakdown -->
                                <div class="price-breakdown mb-4">
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-muted">Price ({{ $cartCount }} items)</span>
                                        <span>₹{{ number_format($subtotal, 2) }}</span>
                                    </div>

                                    @if ($discountAmount > 0 && $appliedCoupon)
                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="text-muted">
                                                <span class="badge bg-success me-1">{{ $appliedCoupon['code'] }}</span>
                                                Discount Applied
                                            </span>
                                            <span
                                                class="text-success fw-bold">-₹{{ number_format($discountAmount, 2) }}</span>
                                        </div>

                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="text-muted">Discounted Price</span>
                                            <span class="fw-bold">₹{{ number_format($discountedSubtotal, 2) }}</span>
                                        </div>
                                    @endif

                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-muted">Delivery Charges</span>
                                        <span class="{{ $shipping == 0 ? 'text-success' : '' }}">
                                            @if ($shipping == 0)
                                                <span class="fw-bold">FREE</span>
                                            @else
                                                ₹{{ number_format($shipping, 2) }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-muted">Tax (GST 18%)</span>
                                        <span>₹{{ number_format($tax, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-muted">Platform Fee</span>
                                        <span class="text-success">FREE</span>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- Total Amount -->
                                <div class="total-amount mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fw-bold fs-5">Total Amount</span>
                                        <span class="fw-bold fs-4 text-dark">₹{{ number_format($total, 2) }}</span>
                                    </div>

                                    @if ($discountAmount > 0)
                                        <p class="text-success small mb-0">
                                            <i class="fas fa-check-circle me-1"></i>You saved
                                            ₹{{ number_format($discountAmount, 2) }} with coupon
                                        </p>
                                    @else
                                        <p class="text-success small mb-0 mt-1">
                                            <i class="fas fa-check-circle me-1"></i>You will save
                                            ₹{{ number_format($cartCount * 99, 2) }} on this order
                                        </p>
                                    @endif
                                </div>

                                <!-- Checkout Button -->
                                @auth
                                    <a href="{{ route('checkout') }}"
                                        class="btn btn-warning btn-lg w-100 py-3 fw-bold rounded-pill shadow-sm mb-3">
                                        <i class="fas fa-lock me-2"></i> PROCEED TO CHECKOUT
                                    </a>
                                @else
                                    <a href="{{ route('checkout.guest') }}"
                                        class="btn btn-warning btn-lg w-100 py-3 fw-bold rounded-pill shadow-sm mb-3">
                                        <i class="fas fa-lock me-2"></i> PROCEED TO CHECKOUT
                                    </a>
                                    <p class="text-center mt-2 small text-muted">
                                        <i class="fas fa-info-circle me-1"></i>You'll be asked to login before checkout
                                    </p>
                                @endauth

                                <!-- Guest Login Prompt -->
                                @guest
                                    <div class="card border-info mt-3">
                                        <div class="card-body p-3">
                                            {{-- <h6 class="fw-bold mb-2"><i class="fas fa-user-plus me-2 text-info"></i>Benefits
                                                of Login</h6>
                                            <ul class="list-unstyled small mb-0">
                                                <li class="mb-1"><i class="fas fa-check text-success me-1"></i> Save cart
                                                    across devices</li>
                                                <li class="mb-1"><i class="fas fa-check text-success me-1"></i> Faster
                                                    checkout</li>
                                                <li class="mb-1"><i class="fas fa-check text-success me-1"></i> Order
                                                    tracking</li>
                                                <li><i class="fas fa-check text-success me-1"></i> Exclusive offers</li>
                                            </ul>
                                            <div class="text-center mt-3">
                                                <a href="{{ route('login') }}" class="btn btn-outline-info btn-sm w-100">
                                                    <i class="fas fa-sign-in-alt me-1"></i> Login Now
                                                </a>
                                            </div> --}}
                                        </div>
                                    </div>
                                @endguest

                                <!-- Payment Methods -->
                                <div class="payment-methods text-center mt-3">
                                    <p class="text-muted small mb-2">We accept</p>
                                    <div class="d-flex justify-content-center gap-2">
                                        <i class="fab fa-cc-visa fa-2x text-primary"></i>
                                        <i class="fab fa-cc-mastercard fa-2x text-danger"></i>
                                        <i class="fab fa-cc-amex fa-2x text-info"></i>
                                        <i class="fas fa-university fa-2x text-success"></i>
                                        <i class="fas fa-mobile-alt fa-2x text-warning"></i>
                                    </div>
                                </div>

                                <!-- Security Badge -->
                                <div class="security-badge text-center mt-2">
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-shield-alt me-1 text-success"></i>
                                        Safe and Secure Payments. 100% secure
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Include Coupon Modal -->
    @include('partials.coupon-modal', ['availableCoupons' => $availableCoupons])

@endsection

@push('styles')
    <style>
        .cart-page {
            background-color: #f5f5f5;
            min-height: calc(100vh - 200px);
        }

        .cart-item {
            transition: all 0.3s ease;
        }

        .cart-item:hover {
            background-color: #fafafa;
        }

        .quantity-selector .input-group .btn {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            padding: 0.375rem 0.75rem;
        }

        .quantity-selector .input-group .btn:hover {
            background-color: #e9ecef;
        }

        .quantity-selector .form-control {
            font-weight: 600;
            color: #212529;
            border-color: #dee2e6;
        }

        .quantity-selector .form-control:focus {
            box-shadow: none;
            border-color: #86b7fe;
        }

        .sticky-top {
            z-index: 1020;
        }

        .btn-warning {
            background: linear-gradient(135deg, #ff9f00, #ff7200);
            border: none;
            color: #000;
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #ff7200, #ff9f00);
            box-shadow: 0 4px 12px rgba(255, 159, 0, 0.3);
            transform: translateY(-2px);
        }

        .empty-cart-icon {
            color: #e0e0e0;
        }

        .badge.bg-success {
            background-color: #388e3c !important;
        }

        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .price-breakdown div {
            padding: 0.5rem 0;
            border-bottom: 1px dashed #e0e0e0;
        }

        .price-breakdown div:last-child {
            border-bottom: none;
        }

        .breadcrumb {
            font-size: 0.875rem;
        }

        .breadcrumb-item a {
            color: #2874f0;
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            text-decoration: underline;
        }

        .modal-content {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border: none;
        }

        .alert {
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .input-group .btn-outline-secondary {
            border: 1px solid #dee2e6;
        }

        .input-group .btn-outline-secondary:hover {
            background-color: #f8f9fa;
        }

        /* Coupon specific styles */
        .coupon-input {
            border: 2px solid #2874f0;
            border-right: none;
        }

        .coupon-input:focus {
            border-color: #2874f0;
            box-shadow: none;
        }

        .coupon-apply-btn {
            background: linear-gradient(135deg, #2874f0, #1b5fc1);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .coupon-apply-btn:hover {
            background: linear-gradient(135deg, #1b5fc1, #2874f0);
        }

        .coupon-applied-badge {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Quantity increment/decrement
            document.querySelectorAll('.increment').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentElement.querySelector('.quantity-input');
                    const max = parseInt(input.max);
                    const current = parseInt(input.value);

                    if (current < max) {
                        input.value = current + 1;
                        submitQuantityForm(input);
                    } else {
                        showNotification(`Maximum ${max} items allowed`);
                    }
                });
            });

            document.querySelectorAll('.decrement').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentElement.querySelector('.quantity-input');
                    const min = parseInt(input.min);
                    const current = parseInt(input.value);

                    if (current > min) {
                        input.value = current - 1;
                        submitQuantityForm(input);
                    }
                });
            });

            // Quantity input change
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    const min = parseInt(this.min) || 1;
                    const max = parseInt(this.max) || 10;

                    if (this.value < min) this.value = min;
                    if (this.value > max) this.value = max;

                    if (parseInt(this.value) !== parseInt(this.dataset.oldValue || 0)) {
                        submitQuantityForm(this);
                    }
                });

                input.addEventListener('blur', function() {
                    if (this.value === '' || this.value < 1) {
                        this.value = 1;
                        submitQuantityForm(this);
                    }
                });

                // Store old value
                input.dataset.oldValue = input.value;
            });

            // Submit quantity form
            function submitQuantityForm(input) {
                const form = input.closest('form');
                if (form) {
                    form.submit();
                }
            }

            // Remove item with confirmation
            document.querySelectorAll('.remove-item-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Remove Item',
                        text: 'Are you sure you want to remove this item from your cart?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, remove it!',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true,
                        backdrop: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });

            // Copy coupon code functionality
            document.querySelectorAll('.copy-coupon').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const code = this.getAttribute('data-code');
                    navigator.clipboard.writeText(code).then(() => {
                        const originalText = this.innerHTML;
                        this.innerHTML = '<i class="fas fa-check"></i> Copied!';
                        this.classList.add('btn-success');
                        this.classList.remove('btn-outline-primary');
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.classList.remove('btn-success');
                            this.classList.add('btn-outline-primary');
                        }, 2000);
                    });
                });
            });

            // Show notification
            function showNotification(message, type = 'info') {
                // Remove existing notifications
                document.querySelectorAll('.cart-notification').forEach(n => n.remove());

                const colors = {
                    info: 'bg-primary',
                    success: 'bg-success',
                    warning: 'bg-warning',
                    error: 'bg-danger'
                };

                const notification = document.createElement('div');
                notification.className =
                    `cart-notification position-fixed bottom-0 end-0 m-3 p-3 text-white rounded-3 shadow-lg animate__animated animate__fadeInUp`;
                notification.style.zIndex = '1060';
                notification.style.maxWidth = '300px';
                notification.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
                    <span>${message}</span>
                </div>
            `;
                notification.classList.add(colors[type] || colors.info);
                document.body.appendChild(notification);

                // Remove after 3 seconds
                setTimeout(() => {
                    notification.classList.remove('animate__fadeInUp');
                    notification.classList.add('animate__fadeOutDown');
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }

            // Check for success messages
            @if (session('success'))
                showNotification('{{ session('success') }}', 'success');
            @endif

            @if (session('error'))
                showNotification('{{ session('error') }}', 'error');
            @endif
        });


        // Auto-dismiss alerts after delay
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-dismiss alerts
            const autoDismissAlerts = document.querySelectorAll('.auto-dismiss');

            autoDismissAlerts.forEach(alert => {
                const delay = alert.getAttribute('data-dismiss-delay') || 3000; // Default 3 seconds

                setTimeout(() => {
                    // Use Bootstrap to dismiss the alert
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, parseInt(delay));

                // Optional: Add progress bar to show time remaining
                addProgressBar(alert, delay);
            });
        });

        // Optional: Add progress bar to show time remaining
        function addProgressBar(alertElement, totalTime) {
            // Create progress bar container
            const progressContainer = document.createElement('div');
            progressContainer.className = 'alert-progress';
            progressContainer.style.cssText = `
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 3px;
                background: rgba(0,0,0,0.1);
                border-radius: 0 0 0.375rem 0.375rem;
                overflow: hidden;
            `;

            // Create progress bar
            const progressBar = document.createElement('div');
            progressBar.className = 'alert-progress-bar';
            progressBar.style.cssText = `
                height: 100%;
                width: 100%;
                background: currentColor;
                opacity: 0.3;
                transform-origin: left;
                transform: scaleX(1);
                transition: transform ${totalTime}ms linear;
            `;

            progressContainer.appendChild(progressBar);
            alertElement.style.position = 'relative';
            alertElement.appendChild(progressContainer);

            // Start the progress animation
            setTimeout(() => {
                progressBar.style.transform = 'scaleX(0)';
            }, 10);
        }
    </script>
@endpush
