@extends('layouts.app')

@section('title', isset($category) ? $category->name : 'Products')

@section('content')
    <section class="products-page" style="background: #f5f7fa;">
        <div class="container pt-4">
            <!-- Page Header -->
            <div class="page-header mb-5">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <nav aria-label="breadcrumb" class="mb-3">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}"
                                        class="text-decoration-none">Home</a></li>
                                @if (isset($category))
                                    <li class="breadcrumb-item"><a href="{{ route('products') }}"
                                            class="text-decoration-none">Products</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                                @elseif(isset($search))
                                    <li class="breadcrumb-item active" aria-current="page">Search Results</li>
                                @else
                                    <li class="breadcrumb-item active" aria-current="page">All Products</li>
                                @endif
                            </ol>
                        </nav>

                        <h1 class="display-5 fw-bold mb-3 page-title">
                            @if (isset($search))
                                <i class="fas fa-search me-2 text-primary"></i>Search: "{{ $search }}"
                            @elseif(isset($category))
                                <i class="fas fa-tag me-2 text-primary"></i>{{ $category->name }}
                            @else
                                <i class="fas fa-boxes me-2 text-primary"></i>All Products
                            @endif
                        </h1>

                        <p class="lead text-muted mb-0">
                            @if (isset($search))
                                Found {{ $products->total() }} results for "{{ $search }}"
                            @elseif(isset($category))
                                {{ $category->description ?? 'Browse our collection of ' . $category->name . ' products' }}
                            @else
                                Browse our complete collection of products
                            @endif
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <div class="d-flex align-items-center justify-content-lg-end gap-3">
                            <div class="results-count">
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                    <i class="fas fa-box me-1"></i> {{ $products->total() }} Products
                                </span>
                            </div>
                            <div class="mobile-filters d-lg-none">
                                <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas"
                                    data-bs-target="#filterOffcanvas" aria-controls="filterOffcanvas">
                                    <i class="fas fa-filter me-1"></i> Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="row g-4">
                <!-- Sidebar Filters (Desktop) -->
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="sidebar-filters card border-0 shadow-sm sticky-top"
                        style="top: 100px; border-radius: 16px;">
                        <div class="card-body p-4">
                            <!-- Categories Filter -->
                            <div class="filter-section mb-4">
                                <h5 class="filter-title d-flex align-items-center mb-3">
                                    <i class="fas fa-tags me-2 text-primary"></i>Categories
                                </h5>
                                <div class="category-list">
                                    <a href="{{ route('products') }}"
                                        class="category-item d-flex align-items-center justify-content-between p-2 rounded-3 mb-2 text-decoration-none {{ !isset($category) ? 'active-category' : '' }}">
                                        <div class="d-flex align-items-center">
                                            <div class="category-icon me-3">
                                                <i class="fas fa-th-large text-primary"></i>
                                            </div>
                                            <span class="category-name">All Products</span>
                                        </div>
                                        <span class="category-count badge bg-primary bg-opacity-10 text-primary">
                                            {{ \App\Models\Product::count() }}
                                        </span>
                                    </a>

                                    @php
                                        $allCategories = \App\Models\Category::where('status', 'active')->get();
                                    @endphp

                                    @foreach ($allCategories as $cat)
                                        <a href="{{ route('category.products', $cat->slug) }}"
                                            class="category-item d-flex align-items-center justify-content-between p-2 rounded-3 mb-2 text-decoration-none {{ isset($category) && $category->id === $cat->id ? 'active-category' : '' }}">
                                            <div class="d-flex align-items-center">
                                                <div class="category-icon me-3">
                                                    <i class="fas fa-{{ $cat->icon ?? 'tag' }} text-primary"></i>
                                                </div>
                                                <span class="category-name">{{ $cat->name }}</span>
                                            </div>
                                            <span class="category-count badge bg-primary bg-opacity-10 text-primary">
                                                {{ $cat->products_count ?? $cat->products()->count() }}
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="col-lg-9">
                    <!-- Products Grid -->
                    <div class="row g-4 products-grid">
                        @forelse($products as $product)
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                <div class="product-card card border-0 shadow-sm h-100"
                                    style="border-radius: 16px; background: white; transition: all 0.3s ease;">
                                    <!-- Product Image -->
                                    <div class="product-image-wrapper position-relative"
                                        style="border-radius: 16px 16px 0 0; overflow: hidden;">
                                        <a href="{{ route('product.show', $product->id) }}" class="d-block img-link">
                                            <div class="product-image position-relative overflow-hidden"
                                                style="height: 220px; background: #f8fafc;">
                                                @if ($product->image)
                                                    <img src="{{ asset('uploads/products/' . $product->image) }}"
                                                        class="img-fluid w-100 h-100 object-fit-cover product-img"
                                                        alt="{{ $product->name }}" loading="lazy"
                                                        style="transition: transform 0.5s ease;">
                                                @else
                                                    <div
                                                        class="product-placeholder w-100 h-100 d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-box text-muted fa-3x"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </a>

                                        <!-- Product Badges -->
                                        <div class="product-badges position-absolute top-0 start-0 p-3">
                                            @if ($product->stock <= 0)
                                                <span class="badge bg-danger px-3 py-2 rounded-pill fw-normal">Sold
                                                    Out</span>
                                            @elseif($product->is_new ?? true)
                                                <span class="badge bg-success px-3 py-2 rounded-pill fw-normal">New</span>
                                            @endif
                                            @if ($product->discount_percent > 0)
                                                <span class="badge bg-warning px-3 py-2 rounded-pill fw-normal text-dark">
                                                    -{{ $product->discount_percent }}%
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Wishlist Button -->
                                        <div class="product-actions position-absolute top-0 end-0 p-3">
                                            <!-- Wishlist Button (Top Right Corner) -->
                                            <button class="btn btn-sm position-absolute top-0 end-0 m-2 p-2 wishlist-btn"
                                                data-product-id="{{ $product->id }}"
                                                onclick="toggleWishlist(this, {{ $product->id }})"
                                                style="background: rgba(255,255,255,0.8); border-radius: 50%;">
                                                @if (auth()->check() && $product->isInWishlist(auth()->id()))
                                                    <i class="fas fa-heart text-danger"></i>
                                                @else
                                                    <i class="far fa-heart"></i>
                                                @endif
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Product Info -->
                                    <div class="card-body p-4">
                                        <!-- Category -->
                                        @if ($product->category)
                                            <div class="mb-2">
                                                <a href="{{ route('category.products', $product->category->slug) }}"
                                                    class="text-decoration-none text-primary small category-link">
                                                    <i class="fas fa-tag me-1"></i>{{ $product->category->name }}
                                                </a>
                                            </div>
                                        @endif

                                        <!-- Product Title -->
                                        <h5 class="card-title mb-2 product-title">
                                            <a href="{{ route('product.show', $product->id) }}"
                                                class="text-decoration-none text-dark fw-semibold">
                                                {{ Str::limit($product->name, 40) }}
                                            </a>
                                        </h5>

                                        <!-- Short Description -->
                                        <p class="card-text text-muted small mb-3 product-description">
                                            {{ Str::limit($product->short_description ?? $product->description, 80, '...') }}
                                        </p>

                                        <!-- Price -->
                                        <div class="product-price d-flex align-items-center justify-content-between mb-3">
                                            <div>
                                                <span class="h4 fw-bold text-primary">
                                                    ₹{{ number_format($product->sale_price ?? $product->price, 2) }}
                                                </span>
                                                @if ($product->price > ($product->sale_price ?? $product->price))
                                                    <span class="text-muted text-decoration-line-through ms-2">
                                                        ₹{{ number_format($product->price, 2) }}
                                                    </span>
                                                @endif
                                            </div>
                                            @if ($product->stock <= 0)
                                                <span
                                                    class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2 rounded-pill">
                                                    Out of Stock
                                                </span>
                                            @elseif($product->stock < 10)
                                                <span
                                                    class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-2 rounded-pill">
                                                    Only {{ $product->stock }} left
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Quantity Selector and Add to Cart Button -->
                                        @if ($product->stock > 0)
                                            @if ($product->inCart())
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="btn-group" role="group"
                                                        style="background: #f8f9fa; border-radius: 8px; padding: 4px;">
                                                        <form action="{{ route('cart.decrease', $product->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-outline-secondary btn-sm"
                                                                style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                        </form>

                                                        <span class="px-3 fw-bold">{{ $product->cartQuantity() }}</span>

                                                        <form action="{{ route('cart.increase', $product->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-outline-secondary btn-sm"
                                                                {{ $product->cartQuantity() >= $product->stock ? 'disabled' : '' }}
                                                                style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </form>
                                                    </div>

                                                    <a href="{{ route('cart') }}" class="btn btn-success btn-sm"
                                                        style="padding: 8px 16px; border-radius: 8px;">
                                                        <i class="fas fa-check me-1"></i> In Cart
                                                    </a>
                                                </div>
                                            @else
                                                <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                                    class="w-100">
                                                    @csrf
                                                    <div class="d-flex align-items-center gap-2">
                                                        <!-- Quantity Selector -->
                                                        <div class="quantity-selector" style="flex: 1;">
                                                            <div class="input-group input-group-sm"
                                                                style="max-width: 140px;">
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary quantity-decrease"
                                                                    data-id="{{ $product->id }}"
                                                                    style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>
                                                                <input type="number" name="quantity"
                                                                    class="form-control text-center quantity-input"
                                                                    value="1" min="1"
                                                                    max="{{ $product->stock }}"
                                                                    data-id="{{ $product->id }}"
                                                                    style="max-width: 60px; border-color: #dee2e6; font-weight: 600;">
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary quantity-plus"
                                                                    data-id="{{ $product->id }}"
                                                                    style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <!-- Add to Cart Button -->
                                                        <button type="submit" class="btn btn-primary"
                                                            style="flex: 1; padding: 8px 16px; border-radius: 8px; transition: all 0.3s ease;">
                                                            <i class="fas fa-cart-plus me-1"></i> Add to Cart
                                                        </button>
                                                    </div>
                                                </form>
                                            @endif

                                            <!-- Stock Information -->
                                            <small class="text-muted d-block mt-2">
                                                <i class="fas fa-box me-1"></i>
                                                {{ $product->stock }} in stock
                                            </small>
                                        @else
                                            <button class="btn btn-secondary w-100" disabled
                                                style="padding: 12px; border-radius: 8px;">
                                                <i class="fas fa-times-circle me-1"></i> Out of Stock
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="empty-state text-center py-5 my-5"
                                    style="background: white; border-radius: 16px; padding: 4rem 2rem; border: 1px solid #e2e8f0;">
                                    <div class="empty-icon mb-4">
                                        <i class="fas fa-box-open display-1 text-muted opacity-25"></i>
                                    </div>
                                    <h4 class="fw-semibold text-muted mb-3">No Products Found</h4>
                                    <p class="text-muted mb-4">
                                        @if (isset($search))
                                            No results found for "{{ $search }}". Try different keywords.
                                        @elseif(isset($category))
                                            No products available in {{ $category->name }} right now.
                                        @else
                                            No products available at the moment.
                                        @endif
                                    </p>
                                    <div class="d-flex flex-wrap justify-content-center gap-3">
                                        <a href="{{ route('products') }}" class="btn btn-primary px-4 py-2"
                                            style="border-radius: 8px;">
                                            <i class="fas fa-th-large me-2"></i> Browse All Products
                                        </a>
                                        <a href="{{ route('home') }}" class="btn btn-outline-primary px-4 py-2"
                                            style="border-radius: 8px;">
                                            <i class="fas fa-home me-2"></i> Back to Home
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if ($products->hasPages())
                        <div class="pagination-wrapper mt-5 pt-5">
                            <nav aria-label="Products pagination">
                                <ul class="pagination justify-content-center" style="gap: 8px;">
                                    {{-- Previous Page --}}
                                    <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $products->previousPageUrl() }}"
                                            aria-label="Previous"
                                            style="border: none; border-radius: 10px; color: #1e293b; padding: 8px 16px; transition: all 0.3s ease;">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>

                                    {{-- Page Numbers --}}
                                    @foreach ($products->getUrlRange(max(1, $products->currentPage() - 2), min($products->lastPage(), $products->currentPage() + 2)) as $page => $url)
                                        <li class="page-item {{ $page == $products->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}"
                                                style="border: none; border-radius: 10px; color: #1e293b; padding: 8px 16px; transition: all 0.3s ease;">
                                                {{ $page }}
                                            </a>
                                        </li>
                                    @endforeach

                                    {{-- Next Page --}}
                                    <li class="page-item {{ !$products->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next"
                                            style="border: none; border-radius: 10px; color: #1e293b; padding: 8px 16px; transition: all 0.3s ease;">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                </ul>

                                <div class="text-center mt-3">
                                    <p class="text-muted small mb-0">
                                        Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of
                                        {{ $products->total() }} products
                                    </p>
                                </div>
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Mobile Filter Offcanvas -->
        <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="filterOffcanvas"
            aria-labelledby="filterOffcanvasLabel">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title fw-bold" id="filterOffcanvasLabel">
                    <i class="fas fa-filter me-2 text-primary"></i> Filters
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <!-- Mobile filter content goes here -->
                <div class="mobile-filters-content">
                    <!-- Same filter content as desktop sidebar -->
                </div>
            </div>
            <div class="offcanvas-footer border-top p-3">
                <button class="btn btn-primary w-100" data-bs-dismiss="offcanvas">
                    <i class="fas fa-check me-1"></i> Apply Filters
                </button>
            </div>
        </div>
    </section>
@endsection

<style>
    /* Inline styles only - no external CSS */
    .products-page {
        background: #f5f7fa;
    }

    /* Page Header */
    .page-header .breadcrumb {
        background: transparent;
        padding: 0;
    }

    .breadcrumb-item+.breadcrumb-item::before {
        content: "›";
        color: #6c757d;
    }

    .page-title {
        background: linear-gradient(135deg, #6366f1, #ec4899);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Sidebar Filters */
    .category-item {
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .category-item:hover {
        background: rgba(99, 102, 241, 0.1);
        border-color: #6366f1;
        transform: translateX(5px);
    }

    .category-item.active-category {
        background: #6366f1;
        color: white;
        border-color: #6366f1;
    }

    .category-item.active-category .category-icon i,
    .category-item.active-category .category-count {
        color: white !important;
        background: rgba(255, 255, 255, 0.2);
    }

    .category-icon {
        width: 36px;
        height: 36px;
        background: rgba(99, 102, 241, 0.1);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Product Cards */
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12) !important;
    }

    .product-card:hover .product-img {
        transform: scale(1.05);
    }

    .product-actions {
        opacity: 0;
        transform: translateX(20px);
        transition: all 0.3s ease;
    }

    .product-card:hover .product-actions {
        opacity: 1;
        transform: translateX(0);
    }

    .wishlist-btn:hover {
        background: #ef4444 !important;
        color: white !important;
    }

    .category-link:hover {
        color: #4f46e5 !important;
    }

    .product-title a:hover {
        color: #6366f1 !important;
    }

    .quantity-decrease:hover,
    .quantity-increase:hover {
        background-color: #f8f9fa;
    }

    .quantity-input:focus {
        box-shadow: none;
        border-color: #6366f1 !important;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
    }

    /* Pagination */
    .page-link:hover {
        background: rgba(99, 102, 241, 0.1);
        color: #6366f1;
    }

    .page-item.active .page-link {
        background: #6366f1;
        color: white;
    }

    .page-item.disabled .page-link {
        color: #6c757d;
        background: #f8f9fa;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .page-title {
            font-size: 2.5rem;
        }

        .product-image {
            height: 180px !important;
        }
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }

        .product-image {
            height: 160px !important;
        }

        .product-actions {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @media (max-width: 576px) {
        .page-title {
            font-size: 1.75rem;
        }

        .product-image {
            height: 140px !important;
        }

        .product-title {
            font-size: 1rem;
        }

        .product-price .h4 {
            font-size: 1.25rem;
        }
    }

    /* Touch Device Optimizations */
    @media (hover: none) and (pointer: coarse) {
        .product-actions {
            opacity: 1;
            transform: translateX(0);
        }

        .btn,
        .form-control,
        .page-link {
            min-height: 44px;
        }

        .btn-icon {
            min-width: 44px;
            min-height: 44px;
        }
    }
</style>

<script>
    // Only UI-related JavaScript
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity controls
        document.querySelectorAll('.quantity-plus').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                const input = document.querySelector(`.quantity-input[data-id="${productId}"]`);
                if (input) {
                    const max = parseInt(input.getAttribute('max'));
                    let value = parseInt(input.value) || 1;
                    if (value < max) {
                        input.value = value + 1;
                        // Add visual feedback
                        input.style.borderColor = '#10b981';
                        setTimeout(() => input.style.borderColor = '', 300);
                    }
                }
            });
        });

        document.querySelectorAll('.quantity-minus').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                const input = document.querySelector(`.quantity-input[data-id="${productId}"]`);
                if (input) {
                    const min = parseInt(input.getAttribute('min'));
                    let value = parseInt(input.value) || 1;
                    if (value > min) {
                        input.value = value - 1;
                        // Add visual feedback
                        input.style.borderColor = '#ef4444';
                        setTimeout(() => input.style.borderColor = '', 300);
                    }
                }
            });
        });

        // Quantity input validation
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const min = parseInt(this.getAttribute('min'));
                const max = parseInt(this.getAttribute('max'));
                let value = parseInt(this.value) || min;

                if (value < min) this.value = min;
                if (value > max) this.value = max;

                // Visual feedback
                if (value < min || value > max) {
                    this.style.borderColor = '#ef4444';
                    this.style.boxShadow = '0 0 0 0.2rem rgba(239, 68, 68, 0.25)';
                    setTimeout(() => {
                        this.style.borderColor = '';
                        this.style.boxShadow = '';
                    }, 1000);
                }
            });
        });

        // Add to cart button hover effect
        document.querySelectorAll('.btn-primary[type="submit"]').forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });

            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Category item hover effects
        document.querySelectorAll('.category-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                if (!this.classList.contains('active-category')) {
                    this.style.transform = 'translateX(5px)';
                }
            });

            item.addEventListener('mouseleave', function() {
                if (!this.classList.contains('active-category')) {
                    this.style.transform = 'translateX(0)';
                }
            });
        });

        // Pagination hover effects
        document.querySelectorAll('.page-link:not(.disabled)').forEach(link => {
            link.addEventListener('mouseenter', function() {
                if (!this.closest('.page-item').classList.contains('active')) {
                    this.style.transform = 'scale(1.05)';
                }
            });

            link.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });

        // Product card hover effects
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Image hover effect
        document.querySelectorAll('.product-img').forEach(img => {
            img.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
            });

            img.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    });

    // Wishlist Toggle Function
    function toggleWishlist(button, productId) {
        // Check if user is logged in
        @if (auth()->check())
            fetch('{{ route('wishlist.toggle') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update button icon
                        const icon = button.querySelector('i');
                        if (data.action === 'added') {
                            icon.className = 'fas fa-heart text-danger';
                            button.classList.add('active');
                        } else {
                            icon.className = 'far fa-heart';
                            button.classList.remove('active');
                        }

                        // Update wishlist count in navbar if function exists
                        if (typeof updateWishlistCount === 'function') {
                            updateWishlistCount();
                        }

                        // Show toast notification
                        showToast(data.message, data.action === 'added' ? 'success' : 'info');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Something went wrong', 'error');
                });
        @else
            // If user is not logged in, redirect to login
            showToast('Please login to add items to wishlist', 'warning');
            setTimeout(() => {
                window.location.href = '{{ route('login') }}';
            }, 1500);
        @endif
    }
</script>
