@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <section class="checkout-page py-5 bg-light">
        <div class="container">
            <!-- Breadcrumb -->
            <div class="row mb-4">
                <div class="col-12">
                    <nav style="--bs-breadcrumb-divider: '›';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('cart') }}" class="text-decoration-none">Cart</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                        </ol>
                        <h1 class="fw-bold mb-0">Checkout</h1>
                    </nav>
                </div>
            </div>

            <div class="row g-4">
                <!-- Left Column: Shipping & Payment Info -->
                <div class="col-lg-8">
                    <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
                        @csrf

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
                                        <label class="form-label fw-medium">Phone <span class="text-danger">*</span></label>
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
                                        <textarea name="address" class="form-control" rows="3" placeholder="Street address, apartment, suite, unit, etc."
                                            required></textarea>
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
                                                @if ($subtotal > 1000)
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
                                        <div class="col-md-4">
                                            <div class="payment-option text-center">
                                                <input type="radio" name="payment_method" id="cod"
                                                    value="cod" class="d-none" checked>
                                                <label for="cod"
                                                    class="payment-label border rounded p-3 d-block h-100">
                                                    <i class="fas fa-money-bill-wave fa-2x text-success mb-2"></i>
                                                    <div class="fw-medium">Cash on Delivery</div>
                                                    <small class="text-muted">Pay when you receive</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="payment-option text-center">
                                                <input type="radio" name="payment_method" id="card"
                                                    value="card" class="d-none">
                                                <label for="card"
                                                    class="payment-label border rounded p-3 d-block h-100">
                                                    <i class="fab fa-cc-visa fa-2x text-primary mb-2"></i>
                                                    <div class="fw-medium">Credit/Debit Card</div>
                                                    <small class="text-muted">Secure payment</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="payment-option text-center">
                                                <input type="radio" name="payment_method" id="upi"
                                                    value="upi" class="d-none">
                                                <label for="upi"
                                                    class="payment-label border rounded p-3 d-block h-100">
                                                    <i class="fas fa-mobile-alt fa-2x text-info mb-2"></i>
                                                    <div class="fw-medium">UPI Payment</div>
                                                    <small class="text-muted">Google Pay, PhonePe, etc.</small>
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
                                <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold">
                                    <i class="fas fa-lock me-2"></i> Place Order & Pay ₹<span
                                        id="finalTotal">{{ number_format($total, 2) }}</span>
                                </button>
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
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Shipping</span>
                                    <span id="displayShipping">₹{{ number_format($shipping, 2) }}</span>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Shipping method price update
            const shippingRadios = document.querySelectorAll('input[name="shipping_method"]');
            const subtotal = {{ $subtotal }};
            const taxRate = 0.18;

            function updateTotals() {
                const isExpress = document.querySelector('input[name="shipping_method"]:checked').value ===
                    'express';
                const shipping = isExpress ? 150 : (subtotal > 1000 ? 0 : 50);
                const tax = subtotal * taxRate;
                const total = subtotal + shipping + tax;

                // Update display
                document.getElementById('displayShipping').textContent = shipping === 0 ? 'FREE' : '₹' + shipping
                    .toFixed(2);
                document.getElementById('displayTax').textContent = tax.toFixed(2);
                document.getElementById('displayTotal').textContent = '₹' + total.toFixed(2);
                document.getElementById('finalTotal').textContent = total.toFixed(2);

                // Update standard price display
                document.getElementById('standardPrice').textContent = subtotal > 1000 ? 'FREE' : '₹50';
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

            // Form validation
            const checkoutForm = document.getElementById('checkoutForm');
            const agreeTerms = document.getElementById('agreeTerms');

            checkoutForm.addEventListener('submit', function(e) {
                if (!agreeTerms.checked) {
                    e.preventDefault();
                    alert('Please agree to the Terms & Conditions');
                    agreeTerms.focus();
                }
            });
        });
    </script>
@endpush
