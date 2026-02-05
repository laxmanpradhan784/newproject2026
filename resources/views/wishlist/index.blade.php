@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
    <div class="container">
        <!-- Modern Header -->
        <div class="card border-0 shadow-sm bg-gradient-primary-light mb-2">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <div class="bg-danger bg-opacity-10 p-3 rounded-circle me-3">
                                <i class="fas fa-heart text-danger fa-lg"></i>
                            </div>
                            <div>
                                <h1 class="h3 fw-bold text-dark mb-1">My Wishlist</h1>
                                <p class="text-muted mb-0">
                                    <span id="wishlist-count">{{ $wishlists->count() }}</span>
                                    {{ $wishlists->count() == 1 ? 'item' : 'items' }} saved
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        @if ($wishlists->count() > 0)
                            <div class="d-flex gap-2 justify-content-end">
                                {{-- <form action="{{ route('wishlist.move-all-to-cart') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success rounded-pill px-4"
                                        onclick="return confirm('Move all items to cart?')">
                                        <i class="fas fa-shopping-cart me-2"></i> Move All to Cart
                                    </button>
                                </form> --}}
                                <a href="{{ route('products') }}" class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-plus me-2"></i> Add More
                                </a>
                                <form action="{{ route('wishlist.clear') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger rounded-pill px-4"
                                        onclick="return confirm('Clear all items from wishlist?')">
                                        <i class="fas fa-trash-alt me-2"></i> Clear All
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Wishlist Content -->
        @if ($wishlists->count() > 0)
            <div class="row">
                @foreach ($wishlists as $item)
                    @if ($item->product)
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                            <div class="card product-card border-0 shadow-sm h-100">
                                <!-- Image Section with Wishlist Button -->
                                <div class="position-relative overflow-hidden rounded-top">
                                    <a href="{{ route('product.show', $item->product->id) }}" class="text-decoration-none text-dark">
                                        <div class="product-image-container" style="height: 220px; overflow: hidden;">
                                            @if ($item->product->image)
                                                <img src="{{ asset('uploads/products/' . $item->product->image) }}"
                                                    alt="{{ $item->product->name }}"
                                                    class="img-fluid w-100 h-100 object-fit-cover transition-scale"
                                                    onerror="this.src='{{ asset('images/default-product.jpg') }}'">
                                            @else
                                                <div class="bg-light w-100 h-100 d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-box fa-3x text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </a>

                                    <!-- Category Tag -->
                                    @if ($item->product->category)
                                        <div class="position-absolute top-0 start-0 m-3">
                                            <span class="badge bg-primary bg-opacity-90 text-white px-3 py-2 rounded-pill">
                                                <i class="fas fa-tag me-1"></i> {{ $item->product->category->name }}
                                            </span>
                                        </div>
                                    @endif

                                    <!-- Remove Wishlist Button -->
                                    {{-- <div class="position-absolute top-0 end-0 m-3">
                                        <button class="btn btn-danger btn-sm rounded-circle shadow-sm"
                                            onclick="removeFromWishlist({{ $item->id }})" style="width: 40px; height: 40px;"
                                            title="Remove from wishlist">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div> --}}

                                    <!-- Stock Badge -->
                                    <div class="position-absolute bottom-0 start-0 w-100">
                                        <div class="d-flex justify-content-between align-items-center p-3">
                                            @if ($item->product->stock > 0)
                                                <span class="badge bg-success bg-opacity-90 text-white px-3 py-2">
                                                    <i class="fas fa-check-circle me-1"></i> In Stock
                                                </span>
                                            @else
                                                <span class="badge bg-danger bg-opacity-90 text-white px-3 py-2">
                                                    <i class="fas fa-times-circle me-1"></i> Out of Stock
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Details -->
                                <div class="card-body p-4">
                                    <!-- Product Name -->
                                    <h6 class="card-title mb-2">
                                        <a href="{{ route('product.show', $item->product->id) }}"
                                            class="text-dark text-decoration-none hover-primary fw-bold">
                                            {{ $item->product->name }}
                                        </a>
                                    </h6>

                                    <!-- Price -->
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="text-primary fw-bold fs-4">
                                            ₹{{ number_format($item->product->price, 2) }}
                                        </span>
                                        @if ($item->product->price > 1000)
                                            <span class="ms-3 badge bg-light text-dark border">
                                                <i class="fas fa-bolt text-warning me-1"></i> Free Shipping
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Rating (if available) -->
                                    @if ($item->product->rating > 0)
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="text-warning me-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= floor($item->product->rating))
                                                        <i class="fas fa-star"></i>
                                                    @elseif($i == ceil($item->product->rating) && fmod($item->product->rating, 1) != 0)
                                                        <i class="fas fa-star-half-alt"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <small class="text-muted">({{ $item->product->review_count }})</small>
                                        </div>
                                    @endif

                                    <!-- Add to Cart Section -->
                                    @if ($item->product->stock > 0)
                                        @if ($item->product->inCart())
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <div class="btn-group" role="group">
                                                    <form action="{{ route('cart.decrease', $item->product->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-secondary btn-sm">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </form>

                                                    <span class="px-3 fw-bold">{{ $item->product->cartQuantity() }}</span>

                                                    <form action="{{ route('cart.increase', $item->product->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-secondary btn-sm"
                                                            {{ $item->product->cartQuantity() >= $item->product->stock ? 'disabled' : '' }}>
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </form>
                                                </div>

                                                <a href="{{ route('cart') }}" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check me-1"></i> In Cart
                                                </a>
                                            </div>
                                        @else
                                            <form action="{{ route('cart.add', $item->product->id) }}" method="POST"
                                                class="d-inline w-100 mb-2">
                                                @csrf
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button type="button" class="btn btn-outline-secondary btn-sm quantity-minus"
                                                            data-id="{{ $item->product->id }}">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="number" name="quantity"
                                                        class="form-control text-center quantity-input" value="1"
                                                        min="1" max="{{ $item->product->stock }}"
                                                        data-id="{{ $item->product->id }}" style="max-width: 60px;">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary btn-sm quantity-plus"
                                                            data-id="{{ $item->product->id }}">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-primary btn-sm ms-2">
                                                            <i class="fas fa-cart-plus me-1"></i> Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif

                                        <!-- Stock Information -->
                                        <small class="text-muted d-block mb-3">
                                            <i class="fas fa-box me-1"></i>
                                            {{ $item->product->stock }} in stock
                                        </small>

                                        <!-- Buy Now Button -->
                                        {{-- <a href="{{ route('checkout') }}" class="btn btn-outline-primary btn-sm rounded-pill w-100 mb-2"
                                           onclick="event.preventDefault(); buyNow({{ $item->product->id }})">
                                            <i class="fas fa-bolt me-2"></i> Buy Now
                                        </a> --}}
                                    @else
                                        <button class="btn btn-outline-secondary btn-lg rounded-pill py-2 w-100" disabled>
                                            <i class="fas fa-bell me-2"></i> Notify When Available
                                        </button>
                                    @endif
                                </div>

                                <!-- Footer -->
                                <div class="card-footer bg-light border-0 py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="far fa-clock me-1"></i>
                                            Added {{ $item->created_at->diffForHumans() }}
                                        </small>
                                        <small class="text-primary">
                                            <i class="fas fa-heart text-danger me-1"></i>
                                            Saved
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Stats Bar -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-3">
                    <div class="row text-center">
                        <div class="col-md-3 col-6 mb-2 mb-md-0">
                            <div class="text-primary fw-bold fs-4">{{ $wishlists->count() }}</div>
                            <small class="text-muted">Total Items</small>
                        </div>
                        <div class="col-md-3 col-6 mb-2 mb-md-0">
                            @php
                                $totalValue = $wishlists->sum(function ($item) {
                                    return $item->product ? $item->product->price : 0;
                                });
                            @endphp
                            <div class="text-success fw-bold fs-4">₹{{ number_format($totalValue, 2) }}</div>
                            <small class="text-muted">Total Value</small>
                        </div>
                        <div class="col-md-3 col-6">
                            @php
                                $inStock = $wishlists
                                    ->filter(function ($item) {
                                        return $item->product && $item->product->stock > 0;
                                    })
                                    ->count();
                            @endphp
                            <div class="text-info fw-bold fs-4">{{ $inStock }}</div>
                            <small class="text-muted">In Stock</small>
                        </div>
                        <div class="col-md-3 col-6">
                            @php
                                $oldest = $wishlists->sortBy('created_at')->first();
                                $daysAgo = $oldest ? $oldest->created_at->diffInDays(now()) : 0;
                            @endphp
                            <div class="text-warning fw-bold fs-4">{{ $daysAgo }}</div>
                            <small class="text-muted">Days Old</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            @if ($wishlists->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    <nav aria-label="Wishlist pagination">
                        <ul class="pagination shadow-sm rounded-pill">
                            {{-- Previous Page --}}
                            <li class="page-item {{ $wishlists->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link border-0 bg-light text-dark px-4 py-2 rounded-start-pill"
                                    href="{{ $wishlists->previousPageUrl() }}" aria-label="Previous">
                                    <i class="fas fa-chevron-left me-2"></i> Previous
                                </a>
                            </li>

                            {{-- Page Numbers --}}
                            @foreach ($wishlists->getUrlRange(1, $wishlists->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $wishlists->currentPage() ? 'active' : '' }}">
                                    <a class="page-link border-0 bg-light text-dark px-4 py-2" href="{{ $url }}">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endforeach

                            {{-- Next Page --}}
                            <li class="page-item {{ !$wishlists->hasMorePages() ? 'disabled' : '' }}">
                                <a class="page-link border-0 bg-light text-dark px-4 py-2 rounded-end-pill"
                                    href="{{ $wishlists->nextPageUrl() }}" aria-label="Next">
                                    Next <i class="fas fa-chevron-right ms-2"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="card border-0 shadow-sm">
                <div class="card-body py-5">
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <div
                                class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center p-4 mb-3">
                                <i class="fas fa-heart fa-3x text-danger"></i>
                            </div>
                            <h3 class="fw-bold text-dark mb-3">Your Wishlist is Empty</h3>
                            <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">
                                Save items you love to your wishlist. Review them anytime and easily move them to your cart.
                            </p>
                        </div>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('home') }}" class="btn btn-primary btn-lg rounded-pill px-5">
                                <i class="fas fa-shopping-bag me-2"></i> Start Shopping
                            </a>
                            <a href="{{ route('products') }}" class="btn btn-outline-primary btn-lg rounded-pill px-5">
                                <i class="fas fa-th-large me-2"></i> Browse All
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- JavaScript -->
    <script>
        function removeFromWishlist(wishlistId) {
            if (confirm('Are you sure you want to remove this item from your wishlist?')) {
                fetch(`/wishlist/${wishlistId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update count in header
                            const countElement = document.getElementById('wishlist-count');
                            if (countElement) {
                                countElement.textContent = data.count;
                                
                                // Update text
                                const textElement = countElement.nextSibling;
                                if (textElement && textElement.textContent) {
                                    const newText = data.count == 1 ? 'item' : 'items';
                                    textElement.textContent = ' ' + newText + ' saved';
                                }
                            }

                            // Show success message
                            showToast(data.message, 'success');

                            // Find and remove the card
                            const card = document.querySelector(`[data-wishlist-id="${wishlistId}"]`);
                            if (card) {
                                card.remove();
                            }

                            // If no items left, reload to show empty state
                            if (data.count == 0) {
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Failed to remove item', 'error');
                    });
            }
        }

        // Buy Now function
        function buyNow(productId) {
            // First add to cart, then redirect to checkout
            addToCart(productId, true);
        }

        // Add to Cart function
        function addToCart(productId, redirectToCheckout = false) {
            const quantity = document.querySelector(`.quantity-input[data-id="${productId}"]`)?.value || 1;
            
            fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: parseInt(quantity)
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Added to cart successfully!', 'success');
                        
                        // Update cart count in navbar if function exists
                        if (typeof updateCartCount === 'function') {
                            updateCartCount();
                        }
                        
                        // If Buy Now was clicked, redirect to checkout
                        if (redirectToCheckout) {
                            setTimeout(() => {
                                window.location.href = '{{ route("checkout") }}';
                            }, 1000);
                        }
                    } else {
                        showToast(data.message || 'Failed to add to cart', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Something went wrong', 'error');
                });
        }

        // Quantity controls
        document.addEventListener('DOMContentLoaded', function() {
            // Quantity plus button
            document.querySelectorAll('.quantity-plus').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id');
                    const input = document.querySelector(`.quantity-input[data-id="${productId}"]`);
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
                    const productId = this.getAttribute('data-id');
                    const input = document.querySelector(`.quantity-input[data-id="${productId}"]`);
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
        });

        // Toast notification function
        function showToast(message, type = 'info') {
            // Create toast
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type} border-0`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');

            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;

            // Add to container
            let container = document.getElementById('toast-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toast-container';
                container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
                container.style.zIndex = '1060';
                document.body.appendChild(container);
            }

            container.appendChild(toast);

            // Initialize and show
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();

            // Remove after hide
            toast.addEventListener('hidden.bs.toast', () => {
                toast.remove();
            });
        }
    </script>

    <style>
        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #f0f0f0;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .transition-scale {
            transition: transform 0.5s ease;
        }

        .product-card:hover .transition-scale {
            transform: scale(1.05);
        }

        .hover-primary:hover {
            color: #0d6efd !important;
        }

        .bg-gradient-primary-light {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .object-fit-cover {
            object-fit: cover;
        }

        /* Fix for product image container */
        .product-image-container {
            background-color: #f8f9fa;  
        }

        /* Input group styling */
        .input-group .btn {
            padding: 0.25rem 0.5rem;
        }
        
        .input-group .form-control {
            height: calc(1.5em + 0.5rem + 2px);
        }
        
        .rounded-start-pill {
            border-top-left-radius: 50rem !important;
            border-bottom-left-radius: 50rem !important;
        }
        
        .rounded-end-pill {
            border-top-right-radius: 50rem !important;
            border-bottom-right-radius: 50rem !important;
        }
    </style>
@endsection