@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <section class="checkout-page">
        <div class="container">
            <!-- Breadcrumb -->
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="fw-bold mb-0">Checkout</h1>
                </div>
            </div>

            <!-- Coupon Messages -->
            @if (session('coupon_error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-2 mb-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <div class="flex-grow-1">{{ session('coupon_error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if (session('coupon_success'))
                <div class="alert alert-success alert-dismissible fade show rounded-2 mb-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-2"></i>
                        <div class="flex-grow-1">{{ session('coupon_success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <div class="row g-4">
                <!-- Left Column: Shipping & Payment Info -->
                <div class="col-lg-8">
                    <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
                        @csrf

                        <!-- Modern Coupon Section -->
                        @if (!session('applied_coupon_code'))
                            <div class="card rounded-3 shadow-sm border-0 mb-4">
                                <div class="card-header bg-white border-0 py-2">
                                    <h5 class="mb-0 d-flex align-items-center">
                                        <i class="fas fa-tag text-primary me-2 fa-sm"></i>
                                        Have a Coupon Code?
                                    </h5>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row g-2 align-items-center">
                                        <div class="col-md-8">
                                            <div class="input-group input-group-sm">
                                                <input type="text" name="coupon_code"
                                                    class="form-control rounded-start-2 py-2 px-3"
                                                    placeholder="Enter coupon code" id="checkoutCouponInput"
                                                    style="height: 40px;">
                                                <button type="button" class="btn btn-primary rounded-end-2 px-3"
                                                    id="applyCouponBtn" style="height: 40px;">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-outline-primary w-100 rounded-2 py-2"
                                                data-bs-toggle="modal" data-bs-target="#couponModal">
                                                <i class="fas fa-eye me-1 fa-sm"></i> View All
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Applied Coupon Display -->
                            <div class="card rounded-3 shadow-sm border-0 mb-4 border-success">
                                <div class="card-header bg-white border-0 py-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 d-flex align-items-center">
                                            <i class="fas fa-tag text-success me-2 fa-sm"></i>
                                            Coupon Applied
                                        </h5>
                                        <a href="{{ route('coupon.remove') }}"
                                            class="btn btn-sm btn-outline-danger px-2 py-1">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="d-flex align-items-center mb-1">
                                                <span class="badge bg-success rounded-pill me-2" style="font-size: 0.7rem;">
                                                    APPLIED
                                                </span>
                                                <strong
                                                    class="text-dark small">{{ session('applied_coupon_code') }}</strong>
                                            </div>
                                            <p class="text-muted small mb-0" style="font-size: 0.85rem;">
                                                {{ session('applied_coupon.name') }}
                                            </p>
                                            <small class="text-success d-block mt-1" style="font-size: 0.8rem;">
                                                @if (session('applied_coupon.discount_type') == 'percentage')
                                                    {{ session('applied_coupon.discount_value') }}% OFF
                                                @else
                                                    Flat ₹{{ session('applied_coupon.discount_value') }} OFF
                                                @endif
                                            </small>
                                        </div>
                                        <div class="text-end">
                                            <div class="text-success fw-bold fs-5">
                                                -₹{{ number_format(session('cart_discount'), 2) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Add compact styling -->
                        <style>
                            .card {
                                transition: all 0.2s ease;
                            }

                            .card:hover {
                                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
                            }

                            .input-group-sm .form-control {
                                border-color: #ced4da;
                            }

                            .input-group-sm .btn {
                                border-left: none;
                            }

                            .badge {
                                padding: 0.25em 0.6em;
                            }

                            .btn-outline-danger {
                                border-width: 1px;
                            }

                            .border-success {
                                border-width: 2px !important;
                                border-left: 4px solid #198754 !important;
                            }
                        </style>

                        <!-- Shipping Information -->
                        <div class="card rounded-3 shadow-sm border-0 mb-4">
                            <div class="card-header bg-white border-0 py-3">
                                <h4 class="mb-0"><i class="fas fa-shipping-fast text-primary me-2"></i> Shipping
                                    Information</h4>
                            </div>
                            <div class="card-body">
                                <!-- Contact Information -->
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-medium">First Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="first_name" class="form-control"
                                            value="{{ $user->name ? explode(' ', $user->name)[0] : '' }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-medium">Last Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="last_name" class="form-control"
                                            value="{{ $user->name ? explode(' ', $user->name)[1] ?? '' : '' }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-medium">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ $user->email }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-medium">Phone <span
                                                class="text-danger">*</span></label>
                                        <input type="tel" name="phone" class="form-control"
                                            value="{{ $user->phone ?? '' }}" required>
                                    </div>
                                </div>

                                <!-- Shipping Address -->
                                <div class="mb-4">
                                    <h6 class="fw-medium mb-3">Shipping Address</h6>
                                    <div class="mb-3">
                                        <label class="form-label fw-medium">Address <span
                                                class="text-danger">*</span></label>
                                        <textarea name="address" class="form-control" rows="3"
                                            placeholder="Street address, apartment, suite, unit, etc." required></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label fw-medium">City <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="city" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label fw-medium">State <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="state" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label fw-medium">ZIP Code <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="zip_code" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-medium">Country <span
                                                class="text-danger">*</span></label>
                                        <select name="country" class="form-select" required>
                                            <option value="India" selected>India</option>
                                            <option value="USA">United States</option>
                                            <option value="UK">United Kingdom</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Shipping Method -->
                                <div class="mb-4">
                                    <h6 class="fw-medium mb-3">Shipping Method</h6>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="shipping_method"
                                            id="standardShipping" value="standard" checked>
                                        <label class="form-check-label d-flex justify-content-between w-100"
                                            for="standardShipping">
                                            <span>Standard Delivery</span>
                                            <span class="fw-medium" id="standardPrice">
                                                @if ($discountedSubtotal > 999)
                                                    FREE
                                                @else
                                                    ₹50
                                                @endif
                                            </span>
                                        </label>
                                        <small class="text-muted">Delivery in 5-7 business days</small>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="shipping_method"
                                            id="expressShipping" value="express">
                                        <label class="form-check-label d-flex justify-content-between w-100"
                                            for="expressShipping">
                                            <span>Express Delivery</span>
                                            <span class="fw-medium">₹150</span>
                                        </label>
                                        <small class="text-muted">Delivery in 1-2 business days</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden coupon fields for checkout -->
                        @if (session('applied_coupon'))
                            <input type="hidden" name="coupon_id" value="{{ session('applied_coupon.id') }}">
                            <input type="hidden" name="coupon_code" value="{{ session('applied_coupon.code') }}">
                            <input type="hidden" name="discount_amount" value="{{ session('cart_discount') }}">
                        @endif

                        <!-- Payment Information -->
                        <div class="card rounded-3 shadow-sm border-0">
                            <div class="card-header bg-white border-0 py-3">
                                <h4 class="mb-0"><i class="fas fa-credit-card text-primary me-2"></i> Payment
                                    Information</h4>
                            </div>
                            <div class="card-body">
                                <!-- Payment Method -->
                                <div class="mb-4">
                                    <h6 class="fw-medium mb-3">Payment Method</h6>
                                    <div class="row g-3">
                                        <!-- Cash on Delivery - Enhanced -->
                                        <div class="col-md-6">
                                            <div class="payment-option text-center">
                                                <input type="radio" name="payment_method" id="cod"
                                                    value="cod" class="d-none" checked>
                                                <label for="cod"
                                                    class="payment-label border rounded-3 p-4 d-block h-100 position-relative overflow-hidden">
                                                    <!-- Animated background effect -->
                                                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-success bg-opacity-5"
                                                        style="transform: translateY(100%); transition: transform 0.3s ease;">
                                                    </div>

                                                    <!-- Icon with badge -->
                                                    <div class="position-relative z-2">
                                                        <div class="icon-wrapper mb-3">
                                                            <div
                                                                class="rounded-circle bg-success bg-opacity-10 p-3 d-inline-block">
                                                                <i class="fas fa-money-bill-wave fa-2x text-success"></i>
                                                            </div>
                                                            <span
                                                                class="badge bg-success position-absolute top-0 end-0 translate-middle">
                                                                <i class="fas fa-check"></i>
                                                            </span>
                                                        </div>

                                                        <div class="fw-bold mb-1">Cash on Delivery</div>
                                                        <small class="text-muted d-block mb-2">Pay when you receive</small>

                                                        <!-- Features -->
                                                        <div class="features mt-3">
                                                            <div
                                                                class="d-flex align-items-center justify-content-center gap-1 small text-muted">
                                                                <i class="fas fa-shield-alt fa-xs text-success"></i>
                                                                <span>Zero online payment risk</span>
                                                            </div>
                                                            <div
                                                                class="d-flex align-items-center justify-content-center gap-1 small text-muted mt-1">
                                                                <i class="fas fa-clock fa-xs text-success"></i>
                                                                <span>Easy & convenient</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Razorpay Payment Option - Enhanced -->
                                        <div class="col-md-6">
                                            <div class="payment-option text-center">
                                                <input type="radio" name="payment_method" id="razorpay"
                                                    value="razorpay" class="d-none">
                                                <label for="razorpay"
                                                    class="payment-label border rounded-3 p-4 d-block h-100 position-relative overflow-hidden">
                                                    <!-- Animated background effect -->
                                                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-warning bg-opacity-5"
                                                        style="transform: translateY(100%); transition: transform 0.3s ease;">
                                                    </div>

                                                    <!-- Razorpay logo badge -->
                                                    <div class="position-absolute top-0 start-0 m-2">
                                                        <span class="badge bg-warning text-dark px-2 py-1"
                                                            style="font-size: 0.7rem;">
                                                            <i class="fas fa-lock me-1"></i>Secure
                                                        </span>
                                                    </div>

                                                    <div class="position-relative z-2">
                                                        <!-- Icon with gradient -->
                                                        <div class="icon-wrapper mb-3">
                                                            <div class="rounded-circle bg-gradient-warning p-3 d-inline-block"
                                                                style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);">
                                                                <i class="fas fa-credit-card fa-2x text-white"></i>
                                                            </div>
                                                        </div>

                                                        <div class="fw-bold mb-1">Online Payment</div>
                                                        <small class="text-muted d-block mb-2">Card / UPI /
                                                            Netbanking</small>

                                                        <!-- Payment Logos -->
                                                        <div class="payment-logos mt-3">
                                                            <div class="d-flex justify-content-center gap-2">
                                                                <div class="logo-item" data-bs-toggle="tooltip"
                                                                    title="Visa">
                                                                    <i class="fab fa-cc-visa fa-lg text-primary"></i>
                                                                </div>
                                                                <div class="logo-item" data-bs-toggle="tooltip"
                                                                    title="Mastercard">
                                                                    <i class="fab fa-cc-mastercard fa-lg text-danger"></i>
                                                                </div>
                                                                <div class="logo-item" data-bs-toggle="tooltip"
                                                                    title="UPI">
                                                                    <i class="fas fa-mobile-alt fa-lg text-info"></i>
                                                                </div>
                                                                <div class="logo-item" data-bs-toggle="tooltip"
                                                                    title="Razorpay">
                                                                    <span
                                                                        style="color: #0C4EB2; font-weight: 700; font-size: 0.9rem;">Razorpay</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Security Badge -->
                                                        <div class="security-badge mt-3">
                                                            <div
                                                                class="d-flex align-items-center justify-content-center gap-1 small text-success">
                                                                <i class="fas fa-shield-alt"></i>
                                                                <span>SSL Secured</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Terms & Conditions -->
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                                    <label class="form-check-label small" for="agreeTerms">
                                        I agree to the <a href="#" class="text-decoration-none">Terms &
                                            Conditions</a> and
                                        <a href="#" class="text-decoration-none">Privacy Policy</a>
                                    </label>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold"
                                    id="placeOrderBtn">
                                    <i class="fas fa-lock me-2"></i> Place Order & Pay ₹<span
                                        id="finalTotal">{{ number_format($total, 2) }}</span>
                                </button>

                                <!-- Loading Spinner (Hidden by default) -->
                                <div class="text-center mt-3" id="loadingSpinner" style="display: none;">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2 text-muted">Processing payment...</p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Right Column: Order Summary -->
                <div class="col-lg-4">
                    <div class="card rounded-3 shadow-sm border-0 sticky-top" style="top: 20px;">
                        <div class="card-header bg-white border-0 py-3">
                            <h4 class="mb-0"><i class="fas fa-receipt text-primary me-2"></i> Order Summary</h4>
                        </div>
                        <div class="card-body">
                            <!-- Order Items -->
                            <div class="order-items mb-4">
                                <h6 class="fw-medium mb-3">Items ({{ $cartItems->count() }})</h6>
                                @foreach ($cartItems as $item)
                                    <div class="d-flex mb-3 pb-3 border-bottom">
                                        <div class="flex-shrink-0">
                                            @if ($item->product->image)
                                                <img src="{{ asset('uploads/products/' . $item->product->image) }}"
                                                    alt="{{ $item->product->name }}" class="rounded-2"
                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded-2 d-flex align-items-center justify-content-center"
                                                    style="width: 60px; height: 60px;">
                                                    <i class="fas fa-box text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1 small fw-medium">{{ $item->product->name }}</h6>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted small">Qty: {{ $item->quantity }}</span>
                                                <span class="fw-medium">₹{{ $item->price * $item->quantity }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Price Breakdown -->
                            <div class="price-breakdown mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal</span>
                                    <span>₹<span id="displaySubtotal">{{ number_format($subtotal, 2) }}</span></span>
                                </div>

                                @if ($discountAmount > 0)
                                    <div class="d-flex justify-content-between mb-2 text-success">
                                        <span class="text-muted">Discount</span>
                                        <span>-₹<span
                                                id="displayDiscount">{{ number_format($discountAmount, 2) }}</span></span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Discounted Price</span>
                                        <span>₹<span
                                                id="displayDiscountedSubtotal">{{ number_format($discountedSubtotal, 2) }}</span></span>
                                    </div>
                                @endif

                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Shipping</span>
                                    <span id="displayShipping">
                                        @if ($shipping == 0)
                                            FREE
                                        @else
                                            ₹{{ number_format($shipping, 2) }}
                                        @endif
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Tax (GST 18%)</span>
                                    <span>₹<span id="displayTax">{{ number_format($tax, 2) }}</span></span>
                                </div>
                            </div>

                            <hr>

                            <!-- Total -->
                            <div class="total-amount mb-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 fw-bold">Total</span>
                                    <span class="h4 fw-bold text-primary"
                                        id="displayTotal">₹{{ number_format($total, 2) }}</span>
                                </div>
                                @if ($discountAmount > 0)
                                    <p class="text-success small mt-1 mb-0">
                                        <i class="fas fa-check-circle me-1"></i>You saved
                                        ₹{{ number_format($discountAmount, 2) }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Include Coupon Modal -->
    @include('partials.coupon-modal', ['availableCoupons' => $availableCoupons])
@endsection

@push('styles')
    <style>
        .checkout-page {
            min-height: calc(100vh - 200px);
        }

        .checkout-steps {
            max-width: 800px;
            margin: 0 auto;
        }

        .step-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
        }

        .step-line {
            height: 2px;
            background: #dee2e6;
            z-index: 1;
            margin-top: -1px;
        }

        .step.active .step-icon {
            background: #0d6efd !important;
        }

        .payment-label {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid #dee2e6;
        }

        .payment-label:hover {
            border-color: #0d6efd !important;
            transform: translateY(-2px);
        }

        input[type="radio"]:checked+.payment-label {
            border-color: #0d6efd !important;
            background-color: rgba(13, 110, 253, 0.05);
        }

        .sticky-top {
            z-index: 1020;
        }

        .coupon-input {
            border: 2px solid #2874f0;
            border-right: none;
        }

        .coupon-input:focus {
            border-color: #2874f0;
            box-shadow: none;
        }

        #loadingSpinner {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .checkout-steps {
                font-size: 0.8rem;
            }

            .step-icon {
                width: 30px;
                height: 30px;
                font-size: 0.8rem;
            }

            .payment-option {
                margin-bottom: 1rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <!-- Razorpay Checkout Script -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Apply coupon in checkout
            const applyCouponBtn = document.getElementById('applyCouponBtn');
            if (applyCouponBtn) {
                applyCouponBtn.addEventListener('click', function() {
                    const couponCode = document.getElementById('checkoutCouponInput').value.trim();

                    if (!couponCode) {
                        alert('Please enter a coupon code');
                        return;
                    }

                    // Create a form and submit it
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('coupon.apply') }}';
                    form.style.display = 'none';

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    const couponInput = document.createElement('input');
                    couponInput.type = 'hidden';
                    couponInput.name = 'coupon_code';
                    couponInput.value = couponCode;
                    form.appendChild(couponInput);

                    document.body.appendChild(form);
                    form.submit();
                });
            }

            // Shipping method price update
            const shippingRadios = document.querySelectorAll('input[name="shipping_method"]');
            const subtotal = {{ $discountedSubtotal ?? $subtotal }};
            const discount = {{ $discountAmount ?? 0 }};
            const taxRate = 0.18;

            function updateTotals() {
                const isExpress = document.querySelector('input[name="shipping_method"]:checked').value ===
                    'express';
                const shipping = isExpress ? 150 : (subtotal > 999 ? 0 : 50);
                const tax = subtotal * taxRate;
                const total = subtotal + shipping + tax;

                // Update display
                document.getElementById('displayShipping').textContent = shipping === 0 ? 'FREE' : '₹' + shipping
                    .toFixed(2);
                document.getElementById('displayTax').textContent = tax.toFixed(2);
                document.getElementById('displayTotal').textContent = '₹' + total.toFixed(2);
                document.getElementById('finalTotal').textContent = total.toFixed(2);

                // Update standard price display
                document.getElementById('standardPrice').textContent = subtotal > 999 ? 'FREE' : '₹50';
            }

            shippingRadios.forEach(radio => {
                radio.addEventListener('change', updateTotals);
            });

            // Payment option selection
            const paymentLabels = document.querySelectorAll('.payment-label');
            paymentLabels.forEach(label => {
                label.addEventListener('click', function() {
                    paymentLabels.forEach(l => l.classList.remove('border-primary'));
                    this.classList.add('border-primary');
                });
            });

            // Form validation and Razorpay handling
            const checkoutForm = document.getElementById('checkoutForm');
            const agreeTerms = document.getElementById('agreeTerms');
            const placeOrderBtn = document.getElementById('placeOrderBtn');
            const loadingSpinner = document.getElementById('loadingSpinner');

            checkoutForm.addEventListener('submit', async function(e) {
                // Check if terms are agreed
                if (!agreeTerms.checked) {
                    e.preventDefault();
                    alert('Please agree to the Terms & Conditions');
                    agreeTerms.focus();
                    return;
                }

                // Check if payment method is Razorpay
                const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
                if (paymentMethod && paymentMethod.value === 'razorpay') {
                    e.preventDefault();

                    // Show loading spinner
                    placeOrderBtn.style.display = 'none';
                    loadingSpinner.style.display = 'block';

                    try {
                        // Get form data
                        const formData = new FormData(checkoutForm);

                        // Submit form via AJAX to get Razorpay order
                        const response = await fetch('{{ route('checkout.store') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (!data.success) {
                            throw new Error(data.message || 'Failed to initialize payment');
                        }

                        // Initialize Razorpay
                        const options = {
                            key: data.key,
                            amount: data.amount,
                            currency: data.currency,
                            name: data.name,
                            description: data.description,
                            order_id: data.razorpay_order_id,
                            handler: function(razorpayResponse) {
                                handleRazorpaySuccess(razorpayResponse, data.order_id);
                            },
                            prefill: data.prefill,
                            theme: {
                                color: '#3B82F6'
                            },
                            modal: {
                                ondismiss: function() {
                                    // User closed the modal - redirect to failed page
                                    window.location.href = '{{ route('razorpay.failed') }}';
                                }
                            }
                        };

                        const rzp = new Razorpay(options);
                        rzp.open();

                    } catch (error) {
                        console.error('Payment initialization error:', error);
                        alert('Error: ' + error.message);
                    } finally {
                        // Hide loading spinner
                        placeOrderBtn.style.display = 'block';
                        loadingSpinner.style.display = 'none';
                    }
                }
                // For other payment methods (COD, card, upi), let the form submit normally
            });

            // Handle Razorpay success
            function handleRazorpaySuccess(razorpayResponse, orderId) {
                // Create a form to submit payment details
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('razorpay.callback') }}';
                form.style.display = 'none';

                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Add Razorpay response data
                const orderIdInput = document.createElement('input');
                orderIdInput.type = 'hidden';
                orderIdInput.name = 'razorpay_order_id';
                orderIdInput.value = razorpayResponse.razorpay_order_id;
                form.appendChild(orderIdInput);

                const paymentIdInput = document.createElement('input');
                paymentIdInput.type = 'hidden';
                paymentIdInput.name = 'razorpay_payment_id';
                paymentIdInput.value = razorpayResponse.razorpay_payment_id;
                form.appendChild(paymentIdInput);

                const signatureInput = document.createElement('input');
                signatureInput.type = 'hidden';
                signatureInput.name = 'razorpay_signature';
                signatureInput.value = razorpayResponse.razorpay_signature;
                form.appendChild(signatureInput);

                // Show loading
                placeOrderBtn.style.display = 'none';
                loadingSpinner.style.display = 'block';
                loadingSpinner.innerHTML = `
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Verifying payment...</p>
                `;

                // Submit the form
                document.body.appendChild(form);
                form.submit();
            }

            // Allow Enter key in coupon input to apply coupon
            const couponInput = document.getElementById('checkoutCouponInput');
            if (couponInput) {
                couponInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        document.getElementById('applyCouponBtn').click();
                    }
                });
            }

            // Initialize totals on page load
            updateTotals();
        });
    </script>
@endpush
