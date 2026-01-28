@extends('layouts.app')

@section('title', $product->name)

@section('content')

    <section class="py-5">
        <div class="container pt-5">
            <div class="row g-4">

                <!-- Product Image & Info -->
                <div class="col-lg-8">
                    <div class="row g-4">
                        <!-- Product Image -->
                        <div class="col-md-12">
                            @if ($product->image)
                                <img src="{{ asset('uploads/products/' . $product->image) }}"
                                    class="img-fluid rounded shadow-sm" alt="{{ $product->name }}"
                                    style="max-height: 400px; width: 100%; object-fit: contain;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded shadow-sm"
                                    style="height: 400px;">
                                    <i class="fas fa-box fa-5x text-muted"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="col-md-12 mt-3">
                            <h2 class="fw-bold">{{ $product->name }}</h2>
                            @if ($product->is_new ?? true)
                                <span class="badge bg-success mb-2">New</span>
                            @endif

                            <p class="text-muted mb-2">Category:
                                <a href="{{ route('category.products', $product->category->slug) }}"
                                    class="text-decoration-none">
                                    {{ $product->category->name }}
                                </a>
                            </p>

                            <h4 class="text-primary">₹{{ number_format($product->price, 2) }}
                                @if ($product->old_price)
                                    <span
                                        class="text-muted text-decoration-line-through ms-2">₹{{ number_format($product->old_price, 2) }}</span>
                                @endif
                            </h4>

                            <!-- Stock Status -->
                            @if ($product->stock > 0)
                                <div class="d-flex align-items-center mb-3">
                                    <span class="badge bg-success me-2">In Stock</span>
                                    <small class="text-muted">{{ $product->stock }} units available</small>
                                </div>
                            @else
                                <div class="d-flex align-items-center mb-3">
                                    <span class="badge bg-danger me-2">Out of Stock</span>
                                    <small class="text-muted">Currently unavailable</small>
                                </div>
                            @endif

                            <!-- Product Description -->
                            <div class="mb-4">
                                <h5 class="mb-3">Description</h5>
                                <p class="mb-0">{{ $product->description ?? 'No detailed description available.' }}</p>
                            </div>

                            <!-- Quantity Selector and Add to Cart -->
                            @if ($product->stock > 0)
                                @if ($product->inCart())
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex align-items-center me-4">
                                            <h6 class="me-3 mb-0">Quantity:</h6>
                                            <div class="btn-group" role="group">
                                                <form action="{{ route('cart.decrease', $product->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-secondary">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </form>

                                                <span class="px-3 fw-bold d-flex align-items-center"
                                                    style="min-width: 40px; justify-content: center;">
                                                    {{ $product->cartQuantity() }}
                                                </span>

                                                <form action="{{ route('cart.increase', $product->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-secondary"
                                                        {{ $product->cartQuantity() >= $product->stock ? 'disabled' : '' }}>
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <a href="{{ route('cart') }}" class="btn btn-success">
                                            <i class="fas fa-check me-1"></i> View in Cart
                                        </a>
                                    </div>
                                @else
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                        class="row g-3 align-items-center">
                                        @csrf
                                        <div class="col-auto">
                                            <label class="form-label fw-bold mb-0">Quantity:</label>
                                        </div>
                                        <div class="col-auto">
                                            <div class="input-group" style="width: 150px;">
                                                <button type="button" class="btn btn-outline-secondary quantity-minus">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" name="quantity"
                                                    class="form-control text-center quantity-input" value="1"
                                                    min="1" max="{{ $product->stock }}"
                                                    style="border-left: 0; border-right: 0;">
                                                <button type="button" class="btn btn-outline-secondary quantity-plus">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <i class="fas fa-cart-plus me-2"></i> Add to Cart
                                            </button>
                                        </div>
                                    </form>
                                @endif

                                <!-- Stock Information -->
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="fas fa-shipping-fast me-1"></i>
                                        Free shipping on orders above ₹999
                                    </small>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-undo me-1"></i>
                                        7-day return policy
                                    </small>
                                </div>
                            @else
                                <button class="btn btn-secondary btn-lg" disabled>
                                    <i class="fas fa-times-circle me-2"></i> Out of Stock
                                </button>
                                <div class="mt-3">
                                    <button class="btn btn-outline-primary notify-btn" data-id="{{ $product->id }}">
                                        <i class="fas fa-bell me-1"></i> Notify When Available
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar: Other Products in Same Category -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Other Products in {{ $product->category->name }}</h5>
                            <div class="list-group list-group-flush">
                                @php
                                    $relatedProducts = \App\Models\Product::with('category')
                                        ->where('category_id', $product->category_id)
                                        ->where('id', '!=', $product->id)
                                        ->where('status', 'active')
                                        ->limit(5)
                                        ->get();
                                @endphp

                                @forelse($relatedProducts as $related)
                                    <a href="{{ route('product.show', $related->id) }}"
                                        class="list-group-item list-group-item-action d-flex align-items-center border-0 py-3">
                                        @if ($related->image)
                                            <img src="{{ asset('uploads/products/' . $related->image) }}"
                                                alt="{{ $related->name }}" style="width:60px;height:60px;object-fit:cover;"
                                                class="me-3 rounded">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center me-3"
                                                style="width:60px;height:60px;border-radius:8px;">
                                                <i class="fas fa-box text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">{{ Str::limit($related->name, 30) }}</h6>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span
                                                    class="text-success fw-bold">₹{{ number_format($related->price, 2) }}</span>
                                                @if ($related->stock > 0)
                                                    <span class="badge bg-success bg-opacity-10 text-success">In
                                                        Stock</span>
                                                @else
                                                    <span class="badge bg-danger bg-opacity-10 text-danger">Out of
                                                        Stock</span>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="text-center py-3">
                                        <p class="text-muted mb-0">No other products in this category.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info Card -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-body">
                            <h6 class="card-title mb-3">Product Details</h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-tag me-2"></i>
                                        Category: {{ $product->category->name }}
                                    </small>
                                </li>
                                <li class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-box me-2"></i>
                                        Status:
                                        <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                        </span>
                                    </small>
                                </li>
                                <li class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-2"></i>
                                        Added: {{ $product->created_at->format('M d, Y') }}
                                    </small>
                                </li>
                                <li>
                                    <small class="text-muted">
                                        <i class="fas fa-sync me-2"></i>
                                        Last updated: {{ $product->updated_at->format('M d, Y') }}
                                    </small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- JavaScript for Quantity Controls -->
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Quantity plus button
                document.querySelectorAll('.quantity-plus').forEach(button => {
                    button.addEventListener('click', function() {
                        const input = this.parentElement.querySelector('.quantity-input');
                        const max = parseInt(input.getAttribute('max'));
                        let value = parseInt(input.value) || 1;

                        if (value < max) {
                            input.value = value + 1;
                        }
                    });
                });

                // Quantity minus button
                document.querySelectorAll('.quantity-minus').forEach(button => {
                    button.addEventListener('click', function() {
                        const input = this.parentElement.querySelector('.quantity-input');
                        const min = parseInt(input.getAttribute('min'));
                        let value = parseInt(input.value) || 1;

                        if (value > min) {
                            input.value = value - 1;
                        }
                    });
                });

                // Input validation
                document.querySelectorAll('.quantity-input').forEach(input => {
                    input.addEventListener('change', function() {
                        const min = parseInt(this.getAttribute('min'));
                        const max = parseInt(this.getAttribute('max'));
                        let value = parseInt(this.value) || min;

                        if (value < min) this.value = min;
                        if (value > max) this.value = max;
                    });
                });

                // Notify when available button
                document.querySelectorAll('.notify-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const productId = this.getAttribute('data-id');
                        alert('We will notify you when product #' + productId + ' is back in stock!');
                        this.innerHTML = '<i class="fas fa-bell me-1"></i> Notifications Set';
                        this.classList.remove('btn-outline-primary');
                        this.classList.add('btn-outline-success');
                        this.disabled = true;
                    });
                });
            });
        </script>
        <style>
            .quantity-input {
                width: 60px;
                text-align: center;
            }

            .btn-group .btn {
                border-radius: 50% !important;
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0;
            }

            .input-group .btn {
                border-radius: 0.375rem !important;
                width: 40px;
            }

            .input-group .btn-outline-secondary {
                border-color: #dee2e6;
            }

            .input-group .btn-outline-secondary:hover {
                background-color: #f8f9fa;
            }

            .list-group-item:hover {
                background-color: #f8f9fa;
                transform: translateX(5px);
                transition: all 0.3s ease;
            }

            .card {
                border-radius: 12px;
                overflow: hidden;
            }

            .notify-btn:hover {
                background-color: #0d6efd;
                color: white;
            }
        </style>
    @endpush

@endsection
