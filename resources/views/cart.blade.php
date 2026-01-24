{{-- resources/views/user/cart.blade.php --}}
@extends('layouts.app')

@section('title', 'My Cart')

@section('content')
<!-- Hero Section -->
<section class="contact-hero py-5 bg-light">
    <div class="container pt-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>


<!-- Mission & Vision -->
<section class="mission-vision py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0">
                        <h3 class="mb-0">Shopping Cart</h3>
                        <p class="text-muted mb-0">{{ $cartCount }} items in your cart</p>
                    </div>
                    <div class="card-body">
                        @if($cartItems->count() > 0)
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead class="bg-light">
                                        <tr>
                                            <th style="width: 100px;">Product</th>
                                            <th>Details</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Subtotal</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cartItems as $item)
                                        <tr>
                                            <td>
                                                @if($item->product->image)
                                                <img src="{{ asset('uploads/products/' . $item->product->image) }}" 
                                                     alt="{{ $item->product->name }}"
                                                     class="img-fluid rounded" 
                                                     style="width: 80px; height: 80px; object-fit: cover;">
                                                @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                     style="width: 80px; height: 80px;">
                                                    <i class="fas fa-box text-muted fa-2x"></i>
                                                </div>
                                                @endif
                                            </td>
                                            <td>
                                                <h6 class="mb-1">{{ $item->product->name }}</h6>
                                                @if($item->product->category)
                                                <p class="text-muted small mb-0">
                                                    Category: {{ $item->product->category->name }}
                                                </p>
                                                @endif
                                                <p class="text-muted small mb-0">
                                                    ₹{{ $item->price }} each
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                <span class="fw-bold">₹{{ $item->price }}</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="update-quantity-form">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="input-group input-group-sm" style="width: 120px;">
                                                            <button type="button" class="btn btn-outline-secondary decrement">-</button>
                                                            <input type="number" 
                                                                   name="quantity" 
                                                                   value="{{ $item->quantity }}" 
                                                                   min="1" 
                                                                   max="10"
                                                                   class="form-control text-center quantity-input">
                                                            <button type="button" class="btn btn-outline-secondary increment">+</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="fw-bold text-primary">₹{{ $item->price * $item->quantity }}</span>
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline remove-item-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('products') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                                </a>
                                <form action="{{ route('cart.clear') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Clear entire cart?')">
                                        <i class="fas fa-trash me-2"></i> Clear Cart
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                                <h4 class="mb-3">Your cart is empty</h4>
                                <p class="text-muted mb-4">Add some products to your cart and they'll appear here.</p>
                                <a href="{{ route('products') }}" class="btn btn-primary">
                                    <i class="fas fa-shopping-bag me-2"></i> Start Shopping
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            @if($cartItems->count() > 0)
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-white border-0">
                        <h4 class="mb-0">Order Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span class="fw-medium">₹{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping</span>
                            <span class="fw-medium">
                                @if($shipping == 0)
                                    <span class="text-success">FREE</span>
                                @else
                                    ₹{{ number_format($shipping, 2) }}
                                @endif
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Tax (GST 18%)</span>
                            <span class="fw-medium">₹{{ number_format($tax, 2) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5 fw-bold">Total</span>
                            <span class="h4 fw-bold text-primary">₹{{ number_format($total, 2) }}</span>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="agreeTerms" checked>
                                <label class="form-check-label small" for="agreeTerms">
                                    I agree to the <a href="#" class="text-decoration-none">Terms & Conditions</a>
                                </label>
                            </div>
                        </div>
                        
                        <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg w-100 py-3">
                            <i class="fas fa-lock me-2"></i> Proceed to Checkout
                        </a>
                        
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i> Secure checkout · SSL encrypted
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Quantity increment/decrement
    document.addEventListener('DOMContentLoaded', function() {
        // Increment button
        document.querySelectorAll('.increment').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('.quantity-input');
                if (parseInt(input.value) < parseInt(input.max)) {
                    input.value = parseInt(input.value) + 1;
                    input.closest('form').submit();
                }
            });
        });

        // Decrement button
        document.querySelectorAll('.decrement').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('.quantity-input');
                if (parseInt(input.value) > parseInt(input.min)) {
                    input.value = parseInt(input.value) - 1;
                    input.closest('form').submit();
                }
            });
        });

        // Quantity input change
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                if (this.value < 1) this.value = 1;
                if (this.value > 10) this.value = 10;
                this.closest('form').submit();
            });
        });

        // Remove item with confirmation
        document.querySelectorAll('.remove-item-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Remove this item from cart?')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endpush