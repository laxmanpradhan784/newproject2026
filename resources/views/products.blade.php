@extends('layouts.app')

@section('title', $category->name . ' - E-Shop')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="py-3">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories') }}">Categories</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
        </ol>
    </div>
</nav>

<!-- Category Header -->
<section class="category-header py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">{{ $category->name }}</h1>
                <p class="lead mb-4">{{ $category->description ?? 'Browse our collection of ' . $category->name }}</p>
                <div class="category-meta d-flex gap-4">
                    <div class="meta-item">
                        <i class="fas fa-box text-primary me-2"></i>
                        <span>{{ $products->count() }} Products</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <span>In Stock: {{ $products->where('stock', '>', 0)->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="category-image">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" 
                             alt="{{ $category->name }}"
                             class="img-fluid rounded-3 shadow"
                             style="max-height: 200px;">
                    @else
                        <div class="bg-primary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center p-5">
                            <i class="fas fa-box fa-4x text-primary"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Grid -->
<section class="products-grid py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-6">
                <h4 class="fw-bold">All Products</h4>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Sort by: Featured
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Featured</a></li>
                        <li><a class="dropdown-item" href="#">Price: Low to High</a></li>
                        <li><a class="dropdown-item" href="#">Price: High to Low</a></li>
                        <li><a class="dropdown-item" href="#">Name A-Z</a></li>
                        <li><a class="dropdown-item" href="#">Newest First</a></li>
                    </ul>
                </div>
            </div>
        </div>

        @if($products->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-4x text-muted mb-4"></i>
                <h4 class="text-muted">No products available</h4>
                <p class="text-muted mb-4">There are no products in this category yet.</p>
                <a href="{{ route('categories') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i> Back to Categories
                </a>
            </div>
        @else
            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <a href="{{ route('product.detail', $product->id) }}">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}"
                                             class="img-fluid w-100" 
                                             style="height: 250px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                             style="height: 250px;">
                                            <i class="fas fa-box fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    
                                    @if($product->stock <= 0)
                                        <div class="out-of-stock position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center">
                                            <span class="badge bg-danger py-2 px-3">Out of Stock</span>
                                        </div>
                                    @elseif($product->stock < 10)
                                        <div class="low-stock position-absolute top-0 end-0 m-3">
                                            <span class="badge bg-warning">Low Stock</span>
                                        </div>
                                    @endif
                                </a>
                                
                                <div class="product-actions position-absolute top-0 end-0 p-3">
                                    <button class="btn btn-light btn-sm rounded-circle mb-2 wishlist-btn" 
                                            data-product-id="{{ $product->id }}">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                    <button class="btn btn-light btn-sm rounded-circle quick-view-btn" 
                                            data-product-id="{{ $product->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="product-body p-4">
                                <div class="product-category mb-2">
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        {{ $category->name }}
                                    </span>
                                </div>
                                
                                <h5 class="product-title mb-2">
                                    <a href="{{ route('product.detail', $product->id) }}" class="text-dark text-decoration-none">
                                        {{ Str::limit($product->name, 50) }}
                                    </a>
                                </h5>
                                
                                <p class="product-description text-muted small mb-3">
                                    {{ Str::limit($product->description, 80) }}
                                </p>
                                
                                <div class="product-price mb-3">
                                    <span class="h5 text-primary fw-bold">${{ number_format($product->price, 2) }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="stock-info">
                                        @if($product->stock > 0)
                                            <span class="text-success small">
                                                <i class="fas fa-check-circle me-1"></i> In Stock ({{ $product->stock }})
                                            </span>
                                        @else
                                            <span class="text-danger small">
                                                <i class="fas fa-times-circle me-1"></i> Out of Stock
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <button class="btn btn-primary btn-sm add-to-cart-btn {{ $product->stock <= 0 ? 'disabled' : '' }}" 
                                            data-product-id="{{ $product->id }}"
                                            {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-cart-plus me-1"></i> Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination (if you have pagination) -->
            @if($products->hasPages())
                <div class="mt-5">
                    {{ $products->links() }}
                </div>
            @endif
        @endif
    </div>
</section>

<!-- Related Categories -->
<section class="related-categories py-5 bg-light">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Other Categories</h2>
            <p class="text-muted">You might also like</p>
        </div>
        
        @php
            $otherCategories = \App\Models\Category::where('id', '!=', $category->id)
                                                   ->where('status', 'active')
                                                   ->limit(4)
                                                   ->get();
        @endphp
        
        @if($otherCategories->count() > 0)
            <div class="row g-3">
                @foreach($otherCategories as $otherCategory)
                    <div class="col-md-3">
                        <a href="{{ route('products.by.category', $otherCategory->id) }}" 
                           class="related-category-card d-block text-decoration-none">
                            <div class="bg-white rounded-3 p-4 text-center transition-150">
                                <div class="icon-wrapper bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                     style="width: 60px; height: 60px;">
                                    <i class="fas fa-box text-primary"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-2">{{ $otherCategory->name }}</h6>
                                @php
                                    $otherProductCount = \App\Models\Product::where('category_id', $otherCategory->id)
                                                                           ->where('status', 'active')
                                                                           ->count();
                                @endphp
                                <p class="text-muted small mb-0">{{ $otherProductCount }} products</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
    :root {
        --primary-color: #4361ee;
        --primary-dark: #3a56d4;
    }
    
    /* Breadcrumb */
    .breadcrumb {
        background: transparent;
        padding: 0;
    }
    
    .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
    }
    
    .breadcrumb-item.active {
        color: #6c757d;
    }
    
    /* Category Header */
    .category-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
    
    .category-meta .meta-item {
        background: white;
        padding: 8px 15px;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }
    
    /* Product Card */
    .product-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }
    
    .product-image {
        height: 250px;
        overflow: hidden;
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .product-card:hover .product-image img {
        transform: scale(1.05);
    }
    
    .out-of-stock {
        z-index: 1;
    }
    
    .product-actions button {
        opacity: 0;
        transform: translateX(10px);
        transition: all 0.3s ease;
    }
    
    .product-card:hover .product-actions button {
        opacity: 1;
        transform: translateX(0);
    }
    
    .product-actions button:nth-child(2) {
        transition-delay: 0.1s;
    }
    
    /* Related Categories */
    .related-category-card .transition-150 {
        transition: all 0.3s ease;
    }
    
    .related-category-card:hover .transition-150 {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(67, 97, 238, 0.15) !important;
    }
    
    /* Section Title */
    .section-title {
        text-align: center;
        margin-bottom: 60px;
        position: relative;
    }
    
    .section-title h2 {
        font-weight: 700;
        color: #333;
        display: inline-block;
        padding-bottom: 10px;
    }
    
    .section-title h2::after {
        content: '';
        position: absolute;
        width: 80px;
        height: 3px;
        background: var(--primary-color);
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
    }
    
    /* Buttons */
    .add-to-cart-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    /* Stock badges */
    .badge.bg-warning {
        color: #000;
    }
    
    @media (max-width: 768px) {
        .category-header h1 {
            font-size: 2.5rem;
        }
        
        .product-card {
            margin-bottom: 20px;
        }
        
        .product-actions button {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Add to cart functionality
        $('.add-to-cart-btn').on('click', function(e) {
            e.preventDefault();
            
            const productId = $(this).data('product-id');
            const button = $(this);
            const originalText = button.html();
            
            if(button.hasClass('disabled')) return;
            
            // Show loading state
            button.html('<i class="fas fa-spinner fa-spin me-1"></i> Adding...');
            button.prop('disabled', true);
            
            // Simulate API call
            setTimeout(() => {
                // Update cart count
                const cartCount = $('.cart-count').text();
                const newCount = parseInt(cartCount) + 1;
                $('.cart-count').text(newCount);
                
                // Show success message
                showToast('Product added to cart!', 'success');
                
                // Reset button
                button.html(originalText);
                button.prop('disabled', false);
            }, 1000);
        });
        
        // Wishlist functionality
        $('.wishlist-btn').on('click', function(e) {
            e.preventDefault();
            
            const productId = $(this).data('product-id');
            const heartIcon = $(this).find('i');
            
            if(heartIcon.hasClass('fas fa-heart')) {
                heartIcon.removeClass('fas fa-heart').addClass('far fa-heart');
                showToast('Removed from wishlist', 'info');
            } else {
                heartIcon.removeClass('far fa-heart').addClass('fas fa-heart');
                showToast('Added to wishlist', 'success');
            }
        });
        
        // Quick view functionality
        $('.quick-view-btn').on('click', function(e) {
            e.preventDefault();
            
            const productId = $(this).data('product-id');
            
            // In real app, load product details via AJAX
            // For now, redirect to product detail
            window.location.href = `/products/${productId}`;
        });
        
        // Toast notification function
        function showToast(message, type = 'info') {
            // Create toast element
            const toast = $(`
                <div class="toast align-items-center text-white bg-${type} border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `);
            
            // Add to container
            const container = $('#toastContainer') || createToastContainer();
            container.append(toast);
            
            // Show toast
            const bsToast = new bootstrap.Toast(toast[0]);
            bsToast.show();
            
            // Remove after hide
            toast.on('hidden.bs.toast', function () {
                $(this).remove();
            });
        }
        
        function createToastContainer() {
            const container = $('<div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>');
            $('body').append(container);
            return container;
        }
    });
</script>
@endpush