@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
    <div class="container">
        <!-- Modern Header with Stats -->
        <div class="card border-0 shadow-sm mb-4 overflow-hidden">
            <div class="card-header bg-white py-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper bg-danger bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="fas fa-heart text-danger fa-2x"></i>
                            </div>
                            <div>
                                <h1 class="h2 fw-bold mb-1">My Wishlist</h1>
                                <p class="text-muted mb-0">
                                    <span class="fw-semibold text-dark" id="wishlist-count">{{ $wishlists->count() }}</span>
                                    {{ $wishlists->count() == 1 ? 'item' : 'items' }} saved for later
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex flex-wrap gap-2 justify-content-md-end mt-3 mt-md-0">
                            <a href="{{ route('products') }}" class="btn btn-primary btn-lg rounded-pill px-4">
                                <i class="fas fa-plus-circle me-2"></i>Add More
                            </a>
                            @if ($wishlists->count() > 0)
                                <form action="{{ route('wishlist.clear') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-lg rounded-pill px-4"
                                        onclick="return confirm('Are you sure you want to clear your entire wishlist?')">
                                        <i class="fas fa-trash-alt me-2"></i>Clear All
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stats Cards -->
            @if ($wishlists->count() > 0)
                <div class="card-body bg-light py-3">
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <div class="stat-card p-3 rounded-3 bg-white shadow-sm h-100">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                                        <i class="fas fa-box text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="stat-number fw-bold fs-4">{{ $wishlists->count() }}</div>
                                        <small class="text-muted">Total Items</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card p-3 rounded-3 bg-white shadow-sm h-100">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-success bg-opacity-10 p-2 rounded-3 me-3">
                                        <i class="fas fa-rupee-sign text-success"></i>
                                    </div>
                                    <div>
                                        @php
                                            $totalValue = $wishlists->sum(function ($item) {
                                                return $item->product ? $item->product->price : 0;
                                            });
                                        @endphp
                                        <div class="stat-number fw-bold fs-4">₹{{ number_format($totalValue, 0) }}</div>
                                        <small class="text-muted">Total Value</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card p-3 rounded-3 bg-white shadow-sm h-100">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-info bg-opacity-10 p-2 rounded-3 me-3">
                                        <i class="fas fa-check-circle text-info"></i>
                                    </div>
                                    <div>
                                        @php
                                            $inStock = $wishlists
                                                ->filter(function ($item) {
                                                    return $item->product && $item->product->stock > 0;
                                                })
                                                ->count();
                                        @endphp
                                        <div class="stat-number fw-bold fs-4">{{ $inStock }}</div>
                                        <small class="text-muted">In Stock</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-card p-3 rounded-3 bg-white shadow-sm h-100">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon bg-warning bg-opacity-10 p-2 rounded-3 me-3">
                                        <i class="fas fa-clock text-warning"></i>
                                    </div>
                                    <div>
                                        @php
                                            $oldest = $wishlists->sortBy('created_at')->first();
                                            $daysAgo = $oldest ? $oldest->created_at->diffInDays(now()) : 0;
                                        @endphp
                                        <div class="stat-number fw-bold fs-4">{{ $daysAgo }}</div>
                                        <small class="text-muted">Days Old</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Wishlist Content -->
        @if ($wishlists->count() > 0)
            <div class="row g-4">
                @foreach ($wishlists as $item)
                    @if ($item->product)
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <div class="card product-card h-100 border-0 shadow-sm hover-lift">
                                <!-- Product Image with Actions -->
                                <div class="position-relative">
                                    <a href="{{ route('product.show', $item->product->id) }}" class="text-decoration-none">
                                        <div class="product-image ratio ratio-1x1">
                                            @if ($item->product->image)
                                                <img src="{{ asset('uploads/products/' . $item->product->image) }}"
                                                    alt="{{ $item->product->name }}"
                                                    class="img-fluid object-fit-cover"
                                                    onerror="this.src='{{ asset('images/default-product.jpg') }}'">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-box-open fa-3x text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </a>
                                    
                                    <!-- Remove from Wishlist Button -->
                                    {{-- <button class="btn btn-danger btn-sm position-absolute top-0 end-0 m-3 rounded-circle shadow-sm"
                                            onclick="removeFromWishlist({{ $item->id }})"
                                            data-bs-toggle="tooltip"
                                            title="Remove from wishlist">
                                        <i class="fas fa-times"></i>
                                    </button> --}}
                                    
                                    <!-- Stock Badge -->
                                    <div class="position-absolute bottom-0 start-0 m-3">
                                        @if ($item->product->stock > 0)
                                            <span class="badge bg-success bg-opacity-90 px-3 py-2">
                                                <i class="fas fa-check me-1"></i> In Stock
                                            </span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-90 px-3 py-2">
                                                <i class="fas fa-times me-1"></i> Out of Stock
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Category Badge -->
                                    @if ($item->product->category)
                                        <div class="position-absolute top-0 start-0 m-3">
                                            <span class="badge bg-primary bg-opacity-90 px-3 py-2">
                                                <i class="fas fa-tag me-1"></i> {{ $item->product->category->name }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Details -->
                                <div class="card-body d-flex flex-column">
                                    <!-- Product Name -->
                                    <h6 class="card-title mb-2">
                                        <a href="{{ route('product.show', $item->product->id) }}"
                                           class="text-dark text-decoration-none hover-primary fw-bold text-truncate-2">
                                            {{ $item->product->name }}
                                        </a>
                                    </h6>

                                    <!-- Rating -->
                                    @if ($item->product->rating > 0)
                                        <div class="mb-2">
                                            <div class="d-flex align-items-center">
                                                <div class="text-warning small">
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
                                                <small class="text-muted ms-2">({{ $item->product->review_count }})</small>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Price -->
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="text-primary fw-bold fs-5">
                                            ₹{{ number_format($item->product->price, 2) }}
                                        </span>
                                        @if ($item->product->price > 1000)
                                            <span class="ms-3 badge bg-light text-dark border small">
                                                <i class="fas fa-shipping-fast text-warning me-1"></i> Free Shipping
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="mt-auto">
                                        @if ($item->product->stock > 0)
                                            @if ($item->product->inCart())
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="btn-group" role="group">
                                                        <form action="{{ route('cart.decrease', $item->product->id) }}"
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-secondary btn-sm rounded-start">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                        </form>

                                                        <span class="px-3 fw-bold border-top border-bottom">
                                                            {{ $item->product->cartQuantity() }}
                                                        </span>

                                                        <form action="{{ route('cart.increase', $item->product->id) }}"
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-secondary btn-sm rounded-end"
                                                                    {{ $item->product->cartQuantity() >= $item->product->stock ? 'disabled' : '' }}>
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </form>
                                                    </div>

                                                    <a href="{{ route('cart') }}" class="btn btn-success btn-sm px-3">
                                                        <i class="fas fa-check me-1"></i> In Cart
                                                    </a>
                                                </div>
                                            @else
                                                <form action="{{ route('cart.add', $item->product->id) }}" method="POST" class="w-100">
                                                    @csrf
                                                    <div class="input-group">
                                                        <button type="button" class="btn btn-outline-secondary quantity-minus"
                                                                data-id="{{ $item->product->id }}">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <input type="number" name="quantity"
                                                               class="form-control text-center quantity-input border-secondary"
                                                               value="1" min="1" max="{{ $item->product->stock }}"
                                                               data-id="{{ $item->product->id }}">
                                                        <button type="button" class="btn btn-outline-secondary quantity-plus"
                                                                data-id="{{ $item->product->id }}">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-cart-plus me-2"></i> Add
                                                        </button>
                                                    </div>
                                                </form>
                                            @endif

                                            <!-- Stock Info -->
                                            <div class="mt-2 text-center">
                                                <small class="text-muted">
                                                    <i class="fas fa-box me-1"></i>
                                                    {{ $item->product->stock }} units available
                                                </small>
                                            </div>
                                        @else
                                            <button class="btn btn-outline-secondary w-100 py-2" disabled>
                                                <i class="fas fa-bell me-2"></i> Notify When Available
                                            </button>
                                        @endif
                                    </div>

                                    <!-- Added Date -->
                                    <div class="mt-3 pt-3 border-top">
                                        <small class="text-muted">
                                            <i class="far fa-clock me-1"></i>
                                            Added {{ $item->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($wishlists->hasPages())
                <div class="mt-5">
                    <nav aria-label="Wishlist pagination">
                        <ul class="pagination justify-content-center">
                            {{-- Previous Page --}}
                            <li class="page-item {{ $wishlists->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link rounded-start-3 px-4 py-2 border-0 shadow-sm"
                                   href="{{ $wishlists->previousPageUrl() }}" aria-label="Previous">
                                    <i class="fas fa-chevron-left me-2"></i> Previous
                                </a>
                            </li>

                            {{-- Page Numbers --}}
                            @foreach ($wishlists->getUrlRange(1, $wishlists->lastPage()) as $page => $url)
                                @if ($page >= $wishlists->currentPage() - 2 && $page <= $wishlists->currentPage() + 2)
                                    <li class="page-item {{ $page == $wishlists->currentPage() ? 'active' : '' }}">
                                        <a class="page-link border-0 shadow-sm mx-1 px-3 py-2"
                                           href="{{ $url }}">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page --}}
                            <li class="page-item {{ !$wishlists->hasMorePages() ? 'disabled' : '' }}">
                                <a class="page-link rounded-end-3 px-4 py-2 border-0 shadow-sm"
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
                            <div class="empty-state-icon bg-light rounded-circle d-inline-flex align-items-center justify-content-center p-4 mb-3">
                                <i class="fas fa-heart fa-4x text-danger"></i>
                            </div>
                            <h3 class="fw-bold text-dark mb-3">Your Wishlist is Empty</h3>
                            <p class="text-muted mb-4 mx-auto" style="max-width: 500px;">
                                Save items you love to your wishlist. Review them anytime and easily move them to your cart.
                                Start exploring our collection!
                            </p>
                        </div>
                        <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                            <a href="{{ route('home') }}" class="btn btn-primary btn-lg rounded-pill px-5 py-3">
                                <i class="fas fa-shopping-bag me-2"></i> Start Shopping
                            </a>
                            <a href="{{ route('products') }}" class="btn btn-outline-primary btn-lg rounded-pill px-5 py-3">
                                <i class="fas fa-th-large me-2"></i> Browse All Products
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
                                    textElement.textContent = ' ' + newText + ' saved for later';
                                }
                            }
                            
                            // Show success message
                            showToast('Item removed from wishlist', 'success');
                            
                            // Remove the card with animation
                            const card = document.querySelector(`[onclick="removeFromWishlist(${wishlistId})"]`)?.closest('.col-12');
                            if (card) {
                                card.style.opacity = '0';
                                card.style.transform = 'translateX(-100px)';
                                card.style.transition = 'all 0.3s ease';
                                setTimeout(() => card.remove(), 300);
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

        // Quantity controls
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
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
            toast.className = `toast align-items-center text-white bg-${type === 'error' ? 'danger' : type} border-0`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            
            toast.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="toast-body d-flex align-items-center">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-3 fs-5"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
            
            // Add to container
            let container = document.getElementById('toast-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toast-container';
                container.className = 'toast-container position-fixed top-0 end-0 p-3';
                container.style.zIndex = '1060';
                document.body.appendChild(container);
            }
            
            container.appendChild(toast);
            
            // Initialize and show
            const bsToast = new bootstrap.Toast(toast, { delay: 3000 });
            bsToast.show();
            
            // Remove after hide
            toast.addEventListener('hidden.bs.toast', () => {
                toast.remove();
            });
        }
    </script>

    <style>
        .product-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.08);
            border-radius: 12px;
            overflow: hidden;
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12) !important;
            border-color: rgba(13, 110, 253, 0.2);
        }
        
        .product-image {
            background-color: #f8f9fa;
        }
        
        .product-image img {
            transition: transform 0.5s ease;
        }
        
        .product-card:hover .product-image img {
            transform: scale(1.05);
        }
        
        .hover-primary:hover {
            color: var(--bs-primary) !important;
        }
        
        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .object-fit-cover {
            object-fit: cover;
        }
        
        .stat-card {
            transition: transform 0.2s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .stat-number {
            line-height: 1.2;
        }
        
        .empty-state-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto;
        }
        
        .input-group .quantity-input {
            max-width: 60px;
            border-left: 0;
            border-right: 0;
        }
        
        .input-group .btn-outline-secondary {
            border-color: #dee2e6;
        }
        
        @media (max-width: 576px) {
            .product-card .input-group {
                flex-wrap: nowrap;
            }
            
            .product-card .input-group button {
                padding: 0.375rem 0.75rem;
            }
            
            .stat-card {
                padding: 1rem !important;
            }
            
            .stat-icon {
                width: 40px;
                height: 40px;
            }
        }
        
        @media (max-width: 768px) {
            .card-header .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
            
            .pagination .page-link {
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
            }
        }
        
        .rounded-3 {
            border-radius: 0.75rem !important;
        }
        
        .rounded-start-3 {
            border-top-left-radius: 0.75rem !important;
            border-bottom-left-radius: 0.75rem !important;
        }
        
        .rounded-end-3 {
            border-top-right-radius: 0.75rem !important;
            border-bottom-right-radius: 0.75rem !important;
        }
    </style>
@endsection