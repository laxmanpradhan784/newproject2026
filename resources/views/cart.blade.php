{{-- resources/views/user/cart.blade.php --}}
@extends('layouts.app')

@section('title', 'My Cart - Flipkart Style')

@section('content')
<!-- Flipkart Style Cart Page -->
<section class="cart-page py-4 bg-light">
    <div class="container pt-5">
        <!-- Breadcrumb -->
        <div class="row mb-4">
            <div class="col-12">
                <nav style="--bs-breadcrumb-divider: '›';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                    </ol>
                    <h2 class="fw-bold mb-0">My Cart ({{ $cartCount }})</h2>
                </nav>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Column: Cart Items -->
            <div class="col-lg-8">
                @if($cartItems->count() > 0)
                <!-- Cart Header -->
                <div class="card rounded-3 shadow-sm border-0 mb-3">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll" checked>
                                    <label class="form-check-label fw-medium ms-2" for="selectAll">
                                        Select all items
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#removeAllModal">
                                    <i class="fas fa-trash-alt me-1"></i> Remove All
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cart Items -->
                <div class="card rounded-3 shadow-sm border-0">
                    <div class="card-body p-0">
                        @foreach($cartItems as $item)
                        <div class="cart-item p-4 border-bottom">
                            <div class="row align-items-center">
                                <div class="col-1">
                                    <div class="form-check">
                                        <input class="form-check-input item-checkbox" type="checkbox" checked data-item-id="{{ $item->id }}">
                                    </div>
                                </div>
                                <div class="col-3 col-md-2">
                                    <div class="position-relative">
                                        @if($item->product->image)
                                        <img src="{{ asset('uploads/products/' . $item->product->image) }}" 
                                             alt="{{ $item->product->name }}"
                                             class="img-fluid rounded-2" 
                                             style="width: 120px; height: 120px; object-fit: contain;">
                                        @else
                                        <div class="bg-light rounded-2 d-flex align-items-center justify-content-center" 
                                             style="width: 120px; height: 120px;">
                                            <i class="fas fa-box text-muted fa-2x"></i>
                                        </div>
                                        @endif
                                        @if($item->product->stock <= 5 && $item->product->stock > 0)
                                        <span class="badge bg-warning position-absolute top-0 start-0 m-1">
                                            Only {{ $item->product->stock }} left
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-8 col-md-9">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h6 class="fw-bold mb-1">{{ $item->product->name }}</h6>
                                            <p class="text-muted small mb-2">
                                                @if($item->product->category)
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
                                                <span class="fs-5 fw-bold text-dark">₹{{ $item->price }}</span>
                                                <span class="text-muted text-decoration-line-through ms-2">₹{{ $item->price + 99 }}</span>
                                                <span class="text-success fw-medium ms-2">{{ round(($item->price)/($item->price + 99)*100) }}% off</span>
                                            </div>
                                            <p class="text-success small mt-1 mb-0">
                                                <i class="fas fa-check-circle me-1"></i>Free delivery
                                            </p>
                                            @if($item->product->stock == 0)
                                            <div class="alert alert-warning p-2 mt-2 mb-0 small">
                                                <i class="fas fa-exclamation-triangle me-1"></i>Out of stock
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-md-4 mt-3 mt-md-0">
                                            <!-- Quantity Selector -->
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="quantity-selector">
                                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="update-quantity-form">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="input-group" style="width: 120px;">
                                                            <button type="button" class="btn btn-outline-secondary border-end-0 decrement px-3">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                            <input type="number" 
                                                                   name="quantity" 
                                                                   value="{{ $item->quantity }}" 
                                                                   min="1" 
                                                                   max="{{ min(10, $item->product->stock) }}"
                                                                   class="form-control text-center border-start-0 border-end-0 quantity-input px-1"
                                                                   style="height: 45px;">
                                                            <button type="button" class="btn btn-outline-secondary border-start-0 increment px-3">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="remove-item-form ms-3">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0" title="Remove item">
                                                        <i class="fas fa-trash-alt fa-lg"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            
                                            <!-- Subtotal -->
                                            <div class="mt-3 text-end">
                                                <p class="mb-0 text-muted small">Subtotal</p>
                                                <h5 class="text-dark fw-bold mb-0">₹{{ $item->price * $item->quantity }}</h5>
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
                            <div class="text-end">
                                <p class="mb-1 text-muted">Total ({{ $cartCount }} items)</p>
                                <h4 class="text-dark fw-bold mb-0">₹{{ number_format($subtotal, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivery Info -->
                <div class="card rounded-3 shadow-sm border-0 mt-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3"><i class="fas fa-truck me-2 text-primary"></i>Delivery Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex mb-3">
                                    <div class="me-3">
                                        <i class="fas fa-shipping-fast text-success fa-lg"></i>
                                    </div>
                                    <div>
                                        <p class="fw-medium mb-1">Free Delivery</p>
                                        <p class="text-muted small mb-0">Delivered in 3-5 business days</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex mb-3">
                                    <div class="me-3">
                                        <i class="fas fa-undo-alt text-primary fa-lg"></i>
                                    </div>
                                    <div>
                                        <p class="fw-medium mb-1">Easy Returns</p>
                                        <p class="text-muted small mb-0">10 days return & exchange policy</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <!-- Empty Cart -->
                <div class="card rounded-3 shadow-sm border-0">
                    <div class="card-body p-5 text-center">
                        <div class="empty-cart-icon mb-4">
                            <i class="fas fa-shopping-cart fa-5x text-muted"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Your cart is empty!</h3>
                        <p class="text-muted mb-4">Looks like you haven't added anything to your cart yet.</p>
                        <a href="{{ route('products') }}" class="btn btn-primary rounded-pill px-5 py-2">
                            <i class="fas fa-shopping-bag me-2"></i> Shop Now
                        </a>
                        <div class="mt-5">
                            <p class="text-muted small mb-2">You might be interested in</p>
                            <a href="#" class="btn btn-outline-primary btn-sm me-2">Best Sellers</a>
                            <a href="#" class="btn btn-outline-primary btn-sm me-2">New Arrivals</a>
                            <a href="#" class="btn btn-outline-primary btn-sm">Deals of the Day</a>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column: Order Summary -->
            @if($cartItems->count() > 0)
            <div class="col-lg-4">
                <!-- Price Details Card -->
                <div class="card rounded-3 shadow-sm border-0 sticky-top" style="top: 20px;">
                    <div class="card-header bg-white border-0 pt-4 pb-3">
                        <h5 class="fw-bold mb-0">Price Details</h5>
                    </div>
                    <div class="card-body pt-0">
                        <!-- Price Breakdown -->
                        <div class="price-breakdown mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Price ({{ $cartCount }} items)</span>
                                <span>₹{{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Delivery Charges</span>
                                <span class="text-success">
                                    @if($shipping == 0)
                                        FREE
                                    @else
                                        ₹{{ number_format($shipping, 2) }}
                                    @endif
                                </span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Platform Fee</span>
                                <span>₹10.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax (GST 18%)</span>
                                <span>₹{{ number_format($tax, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Discount</span>
                                <span class="text-success">-₹{{ number_format(($cartCount * 99), 2) }}</span>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <!-- Total Amount -->
                        <div class="total-amount mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold fs-5">Total Amount</span>
                                <span class="fw-bold fs-4 text-dark">₹{{ number_format($total, 2) }}</span>
                            </div>
                            <p class="text-success small mb-0 mt-1">
                                <i class="fas fa-check-circle me-1"></i>You will save ₹{{ number_format(($cartCount * 99), 2) }} on this order
                            </p>
                        </div>
                        
                        <!-- Checkout Button -->
                        <a href="{{ route('checkout') }}" class="btn btn-warning btn-lg w-100 py-3 fw-bold rounded-pill shadow-sm mb-3">
                            <i class="fas fa-lock me-2"></i> PLACE ORDER
                        </a>
                        
                        <!-- Payment Methods -->
                        <div class="payment-methods text-center mb-3">
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
                        <div class="security-badge text-center">
                            <p class="text-muted small mb-0">
                                <i class="fas fa-shield-alt me-1 text-success"></i>
                                Safe and Secure Payments. 100% secure
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Promo Code Card -->
                <div class="card rounded-3 shadow-sm border-0 mt-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3"><i class="fas fa-tag me-2 text-danger"></i>Apply Coupon</h6>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control rounded-start-pill" placeholder="Enter coupon code">
                            <button class="btn btn-outline-primary rounded-end-pill" type="button">Apply</button>
                        </div>
                        <div class="coupon-suggestions">
                            <p class="small fw-medium mb-2">Available Coupons:</p>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-light text-dark border">FLIP50</span>
                                <span class="badge bg-light text-dark border">WELCOME100</span>
                                <span class="badge bg-light text-dark border">FESTIVE200</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Need Help Card -->
                <div class="card rounded-3 shadow-sm border-0 mt-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3"><i class="fas fa-headset me-2 text-primary"></i>Need Help?</h6>
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-light rounded-circle p-2 me-3">
                                <i class="fas fa-phone-alt text-primary"></i>
                            </div>
                            <div>
                                <p class="fw-medium mb-0">Call us 24/7</p>
                                <p class="text-muted small mb-0">+91 1800-123-4567</p>
                            </div>
                        </div>
                        <a href="#" class="btn btn-outline-dark w-100 rounded-pill">
                            <i class="fas fa-comments me-2"></i> Chat with us
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Remove All Modal -->
@if($cartItems->count() > 0)
<div class="modal fade" id="removeAllModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Clear Cart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-4">
                    <i class="fas fa-trash-alt fa-4x text-danger"></i>
                </div>
                <h5 class="fw-bold mb-3">Remove all items?</h5>
                <p class="text-muted">Are you sure you want to remove all items from your shopping cart?</p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-outline-dark px-4 rounded-pill" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4 rounded-pill">Remove All</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

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
    }
    
    .sticky-top {
        z-index: 1020;
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #ff9f00, #ff7200);
        border: none;
        color: #000;
    }
    
    .btn-warning:hover {
        background: linear-gradient(135deg, #ff7200, #ff9f00);
        box-shadow: 0 4px 12px rgba(255, 159, 0, 0.3);
    }
    
    .empty-cart-icon {
        color: #e0e0e0;
    }
    
    .badge.bg-success {
        background-color: #388e3c !important;
    }
    
    .card {
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    
    .card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }
    
    .form-check-input:checked {
        background-color: #2874f0;
        border-color: #2874f0;
    }
    
    .price-breakdown div {
        padding: 0.5rem 0;
        border-bottom: 1px dashed #e0e0e0;
    }
    
    .price-breakdown div:last-child {
        border-bottom: none;
    }
    
    .coupon-suggestions .badge {
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .coupon-suggestions .badge:hover {
        background-color: #2874f0 !important;
        color: white !important;
    }
    
    .breadcrumb {
        font-size: 0.875rem;
    }
    
    .breadcrumb-item a {
        color: #2874f0;
    }
    
    .modal-content {
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all items functionality
        const selectAll = document.getElementById('selectAll');
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                itemCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
            
            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = [...itemCheckboxes].every(cb => cb.checked);
                    selectAll.checked = allChecked;
                });
            });
        }
        
        // Quantity increment/decrement with Flipkart style
        document.querySelectorAll('.increment').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('.quantity-input');
                const max = parseInt(input.max);
                if (parseInt(input.value) < max) {
                    input.value = parseInt(input.value) + 1;
                    input.closest('form').submit();
                } else {
                    showNotification(`Maximum ${max} items allowed`);
                }
            });
        });

        document.querySelectorAll('.decrement').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('.quantity-input');
                if (parseInt(input.value) > parseInt(input.min)) {
                    input.value = parseInt(input.value) - 1;
                    input.closest('form').submit();
                }
            });
        });

        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                if (this.value < 1) this.value = 1;
                if (this.value > 10) this.value = 10;
                this.closest('form').submit();
            });
            
            input.addEventListener('blur', function() {
                if (this.value === '' || this.value < 1) {
                    this.value = 1;
                    this.closest('form').submit();
                }
            });
        });

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
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });

        // Apply coupon animation
        document.querySelectorAll('.coupon-suggestions .badge').forEach(badge => {
            badge.addEventListener('click', function() {
                const couponCode = this.textContent;
                const couponInput = document.querySelector('input[placeholder="Enter coupon code"]');
                if (couponInput) {
                    couponInput.value = couponCode;
                    couponInput.focus();
                    
                    // Animate the badge
                    this.classList.add('animate__animated', 'animate__bounce');
                    setTimeout(() => {
                        this.classList.remove('animate__animated', 'animate__bounce');
                    }, 1000);
                }
            });
        });

        // Show notification
        function showNotification(message) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = 'position-fixed bottom-0 end-0 m-3 p-3 bg-dark text-white rounded-3 shadow-lg';
            notification.style.zIndex = '1060';
            notification.style.maxWidth = '300px';
            notification.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle me-2"></i>
                    <span>${message}</span>
                </div>
            `;
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
        
        // Update cart count in real-time
        function updateCartCount() {
            fetch('{{ route("cart.count") }}')
                .then(response => response.json())
                .then(data => {
                    const countElements = document.querySelectorAll('[data-cart-count]');
                    countElements.forEach(el => {
                        el.textContent = data.count;
                    });
                });
        }
        
        // Initialize cart animations
        document.querySelectorAll('.cart-item').forEach((item, index) => {
            item.style.animationDelay = `${index * 0.1}s`;
            item.classList.add('animate__animated', 'animate__fadeIn');
        });
    });
</script>
@endpush