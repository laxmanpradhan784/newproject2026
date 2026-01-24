{{-- resources/views/user/cart.blade.php --}}
@extends('layouts.app')

@section('title', 'My Cart')

@section('content')
<!-- Cart Header -->
<section class="py-4 bg-gradient-light">
    <div class="container pt-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold mb-3">Shopping Cart</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none"><i class="fas fa-home me-1"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cart</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-6 text-lg-end">
                @if($cartItems->count() > 0)
                    <div class="d-inline-flex align-items-center bg-white p-3 rounded-3 shadow-sm">
                        <i class="fas fa-shopping-cart text-primary fa-2x me-3"></i>
                        <div>
                            <h5 class="mb-0 fw-bold">{{ $cartCount }} Items</h5>
                            <small class="text-muted">In your shopping cart</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Cart Content -->
<section class="py-1">
    <div class="container">
        <div class="row">
            <!-- Cart Items -->
            <div class="{{ $cartItems->count() > 0 ? 'col-lg-8 mb-5 mb-lg-0' : 'col-12' }}">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-4 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="mb-0 fw-bold">Your Cart Items</h3>
                            @if($cartItems->count() > 0)
                                <span class="badge bg-primary rounded-pill px-3 py-2">{{ $cartCount }} items</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="card-body p-0">
                        @if($cartItems->count() > 0)
                            <!-- Desktop View -->
                            <div class="d-none d-md-block">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="py-3 ps-4" style="width: 100px;">Product</th>
                                                <th class="py-3">Details</th>
                                                <th class="py-3 text-center">Price</th>
                                                <th class="py-3 text-center">Quantity</th>
                                                <th class="py-3 text-center">Subtotal</th>
                                                <th class="py-3 text-center pe-4">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cartItems as $item)
                                            <tr class="cart-item-row">
                                                <td class="ps-4">
                                                    <a href="{{ route('product.show', $item->product_id) }}" class="text-decoration-none">
                                                        <div class="product-image-wrapper position-relative">
                                                            @if($item->product->image)
                                                                <img src="{{ asset('uploads/products/' . $item->product->image) }}" 
                                                                     alt="{{ $item->product->name }}"
                                                                     class="img-fluid rounded-3" 
                                                                     style="width: 90px; height: 90px; object-fit: cover;">
                                                            @else
                                                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" 
                                                                     style="width: 90px; height: 90px;">
                                                                    <i class="fas fa-box text-muted fa-2x"></i>
                                                                </div>
                                                            @endif
                                                            @if($item->quantity > $item->product->stock)
                                                                <span class="position-absolute top-0 start-0 translate-middle badge bg-danger" 
                                                                      style="font-size: 0.6rem;">
                                                                    Only {{ $item->product->stock }} left
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('product.show', $item->product_id) }}" class="text-decoration-none text-dark">
                                                        <h6 class="fw-bold mb-1">{{ $item->product->name }}</h6>
                                                    </a>
                                                    @if($item->product->category)
                                                        <p class="text-muted small mb-1">
                                                            <i class="fas fa-tag me-1"></i>{{ $item->product->category->name }}
                                                        </p>
                                                    @endif
                                                    <p class="text-success small fw-semibold mb-0">
                                                        <i class="fas fa-check-circle me-1"></i>In Stock
                                                    </p>
                                                </td>
                                                <td class="text-center">
                                                    <span class="fw-bold h6 mb-0">₹{{ number_format($item->price, 2) }}</span>
                                                    <small class="text-muted d-block">per item</small>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <div class="quantity-selector">
                                                            <button type="button" 
                                                                    class="btn btn-outline-secondary btn-sm rounded-circle quantity-btn decrease"
                                                                    data-item-id="{{ $item->id }}"
                                                                    {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                                <i class="fas fa-minus fa-xs"></i>
                                                            </button>
                                                            
                                                            <input type="number" 
                                                                   class="form-control form-control-sm text-center mx-2 quantity-display"
                                                                   value="{{ $item->quantity }}" 
                                                                   min="1" 
                                                                   max="{{ $item->product->stock }}"
                                                                   data-item-id="{{ $item->id }}"
                                                                   style="width: 60px;">
                                                            
                                                            <button type="button" 
                                                                    class="btn btn-outline-secondary btn-sm rounded-circle quantity-btn increase"
                                                                    data-item-id="{{ $item->id }}"
                                                                    {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }}>
                                                                <i class="fas fa-plus fa-xs"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @if($item->quantity > $item->product->stock)
                                                        <small class="text-danger d-block mt-1">
                                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                                            Max {{ $item->product->stock }} available
                                                        </small>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <span class="fw-bold text-primary h5">₹{{ number_format($item->price * $item->quantity, 2) }}</span>
                                                </td>
                                                <td class="text-center pe-4">
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-danger rounded-circle remove-btn"
                                                            data-item-id="{{ $item->id }}"
                                                            data-item-name="{{ $item->product->name }}"
                                                            title="Remove item">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Mobile View -->
                            <div class="d-block d-md-none">
                                @foreach($cartItems as $item)
                                <div class="border-bottom p-4">
                                    <div class="row g-3">
                                        <div class="col-4">
                                            <a href="{{ route('product.show', $item->product_id) }}">
                                                @if($item->product->image)
                                                    <img src="{{ asset('uploads/products/' . $item->product->image) }}" 
                                                         alt="{{ $item->product->name }}"
                                                         class="img-fluid rounded-3 w-100"
                                                         style="height: 120px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center w-100"
                                                         style="height: 120px;">
                                                        <i class="fas fa-box text-muted fa-2x"></i>
                                                    </div>
                                                @endif
                                            </a>
                                        </div>
                                        <div class="col-8">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <a href="{{ route('product.show', $item->product_id) }}" class="text-decoration-none text-dark">
                                                    <h6 class="fw-bold mb-1">{{ $item->product->name }}</h6>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger remove-btn"
                                                        data-item-id="{{ $item->id }}"
                                                        data-item-name="{{ $item->product->name }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                            
                                            @if($item->product->category)
                                                <p class="text-muted small mb-2">
                                                    <i class="fas fa-tag me-1"></i>{{ $item->product->category->name }}
                                                </p>
                                            @endif
                                            
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="fw-bold text-primary">₹{{ number_format($item->price, 2) }}</span>
                                                <span class="badge bg-success">In Stock</span>
                                            </div>
                                            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="quantity-selector">
                                                    <button type="button" 
                                                            class="btn btn-outline-secondary btn-sm rounded-circle quantity-btn decrease"
                                                            data-item-id="{{ $item->id }}"
                                                            {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                        <i class="fas fa-minus fa-xs"></i>
                                                    </button>
                                                    
                                                    <input type="number" 
                                                           class="form-control form-control-sm text-center mx-2 quantity-display"
                                                           value="{{ $item->quantity }}" 
                                                           min="1" 
                                                           max="{{ $item->product->stock }}"
                                                           data-item-id="{{ $item->id }}"
                                                           style="width: 50px;">
                                                    
                                                    <button type="button" 
                                                            class="btn btn-outline-secondary btn-sm rounded-circle quantity-btn increase"
                                                            data-item-id="{{ $item->id }}"
                                                            {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }}>
                                                        <i class="fas fa-plus fa-xs"></i>
                                                    </button>
                                                </div>
                                                <span class="fw-bold h5 mb-0">₹{{ number_format($item->price * $item->quantity, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <!-- Cart Actions -->
                            <div class="card-footer bg-white py-4 border-0">
                                <div class="d-flex flex-wrap justify-content-between align-items-center">
                                    <a href="{{ route('products') }}" class="btn btn-outline-primary px-4 py-2 mb-2 mb-md-0">
                                        <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                                    </a>
                                    
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-danger px-4 py-2" id="clear-cart-btn">
                                            <i class="fas fa-trash-alt me-2"></i> Clear Cart
                                        </button>
                                        
                                        <a href="{{ route('checkout') }}" class="btn btn-primary px-4 py-2">
                                            <i class="fas fa-lock me-2"></i> Proceed to Checkout
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                        @else
                            <!-- Empty Cart -->
                            <div class="text-center py-5 my-5">
                                <div class="empty-cart-icon mb-4">
                                    <i class="fas fa-shopping-cart fa-5x text-muted opacity-25"></i>
                                </div>
                                <h4 class="fw-bold mb-3">Your cart feels lonely</h4>
                                <p class="text-muted mb-4">Looks like you haven't added anything to your cart yet.</p>
                                <a href="{{ route('products') }}" class="btn btn-primary btn-lg px-5 py-3">
                                    <i class="fas fa-shopping-bag me-2"></i> Start Shopping Now
                                </a>
                                <div class="mt-4">
                                    <small class="text-muted">
                                        <i class="fas fa-truck me-1"></i> Free shipping on orders above ₹999
                                    </small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            @if($cartItems->count() > 0)
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;">
                    <div class="card-header bg-white py-4 border-0">
                        <h4 class="mb-0 fw-bold">Order Summary</h4>
                    </div>
                    
                    <div class="card-body">
                        <!-- Summary Items -->
                        <div class="summary-item d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <span class="text-muted">Subtotal ({{ $cartCount }} items)</span>
                            <span class="fw-semibold">₹{{ number_format($subtotal, 2) }}</span>
                        </div>
                        
                        <div class="summary-item d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <span class="text-muted">Shipping</span>
                            <span class="fw-semibold">
                                @if($shipping == 0)
                                    <span class="text-success">FREE</span>
                                @else
                                    ₹{{ number_format($shipping, 2) }}
                                @endif
                            </span>
                        </div>
                        
                        <div class="summary-item d-flex justify-content-between mb-4">
                            <span class="text-muted">Tax (GST 18%)</span>
                            <span class="fw-semibold">₹{{ number_format($tax, 2) }}</span>
                        </div>
                        
                        <!-- Total -->
                        <div class="total-section bg-light p-4 rounded-3 mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold">Total Amount</h5>
                                <h3 class="mb-0 text-primary fw-bold">₹{{ number_format($total, 2) }}</h3>
                            </div>
                            <small class="text-muted d-block mt-2">Including all taxes and charges</small>
                        </div>
                        
                        <!-- Checkout Button -->
                        <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg w-100 py-3 mb-4">
                            <i class="fas fa-lock me-2"></i> Proceed to Secure Checkout
                        </a>
                        
                        <!-- Security Info -->
                        <div class="security-info text-center">
                            <div class="d-flex justify-content-center gap-4 mb-3">
                                <div class="text-center">
                                    <i class="fas fa-shield-alt fa-2x text-success mb-2"></i>
                                    <p class="small mb-0">100% Secure</p>
                                </div>
                                <div class="text-center">
                                    <i class="fas fa-sync-alt fa-2x text-info mb-2"></i>
                                    <p class="small mb-0">Easy Returns</p>
                                </div>
                                <div class="text-center">
                                    <i class="fas fa-truck fa-2x text-warning mb-2"></i>
                                    <p class="small mb-0">Fast Delivery</p>
                                </div>
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-lock me-1"></i> Your payment information is encrypted and secure
                            </small>
                        </div>
                        
                        <!-- Promo Code -->
                        <div class="mt-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Promo code" id="promo-code">
                                <button class="btn btn-outline-secondary" type="button" id="apply-promo">
                                    Apply
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Related Products (Optional) -->
@if($cartItems->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <h3 class="fw-bold mb-4">You might also like</h3>
        <div class="row g-4">
            @php
                $relatedProducts = \App\Models\Product::where('status', 'active')
                    ->whereNotIn('id', $cartItems->pluck('product_id'))
                    ->inRandomOrder()
                    ->limit(4)
                    ->get();
            @endphp
            
            @foreach($relatedProducts as $product)
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden product-card">
                    <a href="{{ route('product.show', $product->id) }}">
                        @if($product->image)
                            <img src="{{ asset('uploads/products/' . $product->image) }}" 
                                 class="card-img-top" 
                                 style="height: 200px; object-fit: cover;" 
                                 alt="{{ $product->name }}">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                 style="height: 200px;">
                                <i class="fas fa-box fa-3x text-muted"></i>
                            </div>
                        @endif
                    </a>
                    <div class="card-body p-3">
                        <h6 class="fw-bold mb-2">{{ $product->name }}</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-primary fw-bold">₹{{ number_format($product->price, 2) }}</span>
                            <button class="btn btn-sm btn-outline-primary add-to-cart-quick" data-product-id="{{ $product->id }}">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@push('styles')
<style>
    .cart-item-row:hover {
        background-color: #f8f9fa;
        transition: background-color 0.3s ease;
    }
    
    .quantity-selector {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .quantity-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        border-color: #dee2e6;
    }
    
    .quantity-btn:hover:not(:disabled) {
        background-color: #e9ecef;
        border-color: #adb5bd;
    }
    
    .quantity-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .quantity-display {
        width: 60px !important;
        border-color: #dee2e6;
    }
    
    .quantity-display:focus {
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        border-color: #86b7fe;
    }
    
    .remove-btn {
        transition: all 0.3s ease;
    }
    
    .remove-btn:hover {
        background-color: #dc3545;
        color: white;
        transform: scale(1.1);
    }
    
    .product-card {
        transition: all 0.3s ease;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .add-to-cart-quick {
        transition: all 0.3s ease;
    }
    
    .add-to-cart-quick:hover {
        background-color: #0d6efd;
        color: white;
    }
    
    .empty-cart-icon {
        animation: bounce 2s infinite;
    }
    
    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
    
    .sticky-top {
        z-index: 1020;
    }
    
    .summary-item {
        transition: all 0.3s ease;
    }
    
    .summary-item:hover {
        background-color: #f8f9fa;
        padding-left: 10px;
        padding-right: 10px;
        margin-left: -10px;
        margin-right: -10px;
        border-radius: 8px;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // CSRF Token for AJAX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Update cart quantity
    function updateCartQuantity(itemId, quantity) {
        fetch(`/cart/update/${itemId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload page to update totals
                location.reload();
            } else {
                alert(data.message || 'Failed to update quantity');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the cart');
        });
    }
    
    // Remove item from cart
    function removeCartItem(itemId) {
        if (confirm('Are you sure you want to remove this item from your cart?')) {
            fetch(`/cart/remove/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Failed to remove item');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while removing the item');
            });
        }
    }
    
    // Clear entire cart
    function clearCart() {
        if (confirm('Are you sure you want to clear your entire cart?')) {
            fetch('/cart/clear', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Failed to clear cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while clearing the cart');
            });
        }
    }
    
    // Quick add to cart
    function quickAddToCart(productId) {
        fetch(`/cart/add/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ quantity: 1 })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Product added to cart!');
                location.reload();
            } else {
                alert(data.message || 'Failed to add product to cart');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while adding the product');
        });
    }
    
    // Quantity increase buttons
    document.querySelectorAll('.quantity-btn.increase').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-item-id');
            const input = this.parentElement.querySelector('.quantity-display');
            const max = parseInt(input.getAttribute('max'));
            let currentValue = parseInt(input.value) || 1;
            
            if (currentValue < max) {
                input.value = currentValue + 1;
                updateCartQuantity(itemId, input.value);
            }
        });
    });
    
    // Quantity decrease buttons
    document.querySelectorAll('.quantity-btn.decrease').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-item-id');
            const input = this.parentElement.querySelector('.quantity-display');
            const min = parseInt(input.getAttribute('min'));
            let currentValue = parseInt(input.value) || 1;
            
            if (currentValue > min) {
                input.value = currentValue - 1;
                updateCartQuantity(itemId, input.value);
            }
        });
    });
    
    // Quantity input change
    document.querySelectorAll('.quantity-display').forEach(input => {
        input.addEventListener('change', function() {
            const itemId = this.getAttribute('data-item-id');
            const min = parseInt(this.getAttribute('min'));
            const max = parseInt(this.getAttribute('max'));
            let value = parseInt(this.value) || min;
            
            if (value < min) value = min;
            if (value > max) value = max;
            
            this.value = value;
            updateCartQuantity(itemId, value);
        });
    });
    
    // Remove item buttons
    document.querySelectorAll('.remove-btn').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-item-id');
            const itemName = this.getAttribute('data-item-name');
            
            if (confirm(`Remove "${itemName}" from your cart?`)) {
                removeCartItem(itemId);
            }
        });
    });
    
    // Clear cart button
    const clearCartBtn = document.getElementById('clear-cart-btn');
    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', clearCart);
    }
    
    // Quick add to cart buttons
    document.querySelectorAll('.add-to-cart-quick').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            quickAddToCart(productId);
        });
    });
    
    // Promo code apply button
    const applyPromoBtn = document.getElementById('apply-promo');
    if (applyPromoBtn) {
        applyPromoBtn.addEventListener('click', function() {
            const promoCode = document.getElementById('promo-code').value;
            if (promoCode.trim()) {
                alert(`Promo code "${promoCode}" applied! (Note: This is a demo - implement actual promo logic)`);
                document.getElementById('promo-code').value = '';
            } else {
                alert('Please enter a promo code');
            }
        });
    }
    
    // Enter key for promo code
    const promoInput = document.getElementById('promo-code');
    if (promoInput) {
        promoInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('apply-promo').click();
            }
        });
    }
});
</script>
@endpush