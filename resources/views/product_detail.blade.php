@extends('layouts.app')

@section('title', $product->name . ' - E-Shop')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="py-3">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories') }}">Categories</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('products.by.category', $product->category_id) }}">
                    {{ $product->category->name ?? 'Category' }}
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </div>
</nav>

<!-- Product Detail -->
<section class="product-detail py-5">
    <div class="container">
        <div class="row">
            <!-- Product Images -->
            <div class="col-lg-6">
                <div class="product-images">
                    <!-- Main Image -->
                    <div class="main-image mb-4">
                        <div class="rounded-3 overflow-hidden shadow-sm" style="height: 400px;">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}"
                                     class="img-fluid w-100 h-100 object-fit-cover"
                                     id="mainProductImage">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                    <i class="fas fa-box fa-5x text-muted"></i>
                                </div>
                            @endif
                            
                            @if($product->stock <= 0)
                                <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center">
                                    <span class="badge bg-danger py-3 px-4 fs-5">Out of Stock</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Thumbnail Images (if you have multiple images) -->
                    <div class="thumbnail-images d-flex gap-3">
                        <div class="thumbnail-item active" style="width: 80px; height: 80px;">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}"
                                     class="img-fluid rounded-2 cursor-pointer w-100 h-100 object-fit-cover">
                            @else
                                <div class="bg-light rounded-2 d-flex align-items-center justify-content-center w-100 h-100">
                                    <i class="fas fa-box text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <!-- Add more thumbnails here if you have multiple images -->
                    </div>
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="col-lg-6">
                <div class="product-info">
                    <!-- Category Badge -->
                    <div class="mb-3">
                        <a href="{{ route('products.by.category', $product->category_id) }}" 
                           class="badge bg-primary bg-opacity-10 text-primary text-decoration-none">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </a>
                    </div>
                    
                    <!-- Product Name -->
                    <h1 class="fw-bold mb-3">{{ $product->name }}</h1>
                    
                    <!-- Rating -->
                    <div class="product-rating mb-4">
                        <div class="stars text-warning mb-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span class="text-muted ms-2">(4.5/5.0)</span>
                        </div>
                        <a href="#reviews" class="text-decoration-none">
                            <span class="text-muted">128 Reviews</span>
                        </a>
                    </div>
                    
                    <!-- Price -->
                    <div class="product-price mb-4">
                        <h2 class="text-primary fw-bold">${{ number_format($product->price, 2) }}</h2>
                        @if($product->compare_price)
                            <del class="text-muted me-3">${{ number_format($product->compare_price, 2) }}</del>
                            <span class="badge bg-danger">Save {{ number_format((($product->compare_price - $product->price) / $product->compare_price) * 100, 0) }}%</span>
                        @endif
                    </div>
                    
                    <!-- Stock Status -->
                    <div class="stock-status mb-4">
                        @if($product->stock > 0)
                            @if($product->stock < 10)
                                <div class="alert alert-warning d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Only {{ $product->stock }} items left in stock!
                                </div>
                            @else
                                <div class="alert alert-success d-flex align-items-center">
                                    <i class="fas fa-check-circle me-2"></i>
                                    In Stock ({{ $product->stock }} available)
                                </div>
                            @endif
                        @else
                            <div class="alert alert-danger d-flex align-items-center">
                                <i class="fas fa-times-circle me-2"></i>
                                Out of Stock
                            </div>
                        @endif
                    </div>
                    
                    <!-- Product Description -->
                    <div class="product-description mb-5">
                        <h5 class="fw-bold mb-3">Description</h5>
                        <p class="text-muted">{{ $product->description ?? 'No description available.' }}</p>
                    </div>
                    
                    <!-- Add to Cart -->
                    <div class="add-to-cart mb-5">
                        <div class="row g-3">
                            <!-- Quantity -->
                            <div class="col-auto">
                                <div class="input-group" style="width: 140px;">
                                    <button class="btn btn-outline-secondary" type="button" id="decreaseQty">-</button>
                                    <input type="number" class="form-control text-center" value="1" min="1" max="{{ $product->stock }}" id="productQty">
                                    <button class="btn btn-outline-secondary" type="button" id="increaseQty">+</button>
                                </div>
                            </div>
                            
                            <!-- Add to Cart Button -->
                            <div class="col">
                                <button class="btn btn-primary btn-lg w-100 {{ $product->stock <= 0 ? 'disabled' : '' }}" 
                                        id="addToCartBtn"
                                        {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-cart-plus me-2"></i> Add to Cart
                                </button>
                            </div>
                            
                            <!-- Wishlist Button -->
                            <div class="col-auto">
                                <button class="btn btn-outline-primary btn-lg" id="wishlistBtn">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Meta -->
                    <div class="product-meta">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-shipping-fast text-primary me-3 fa-lg"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Free Shipping</h6>
                                        <p class="text-muted small mb-0">On orders over $50</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-undo-alt text-primary me-3 fa-lg"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">30-Day Returns</h6>
                                        <p class="text-muted small mb-0">Easy returns policy</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-shield-alt text-primary me-3 fa-lg"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Secure Payment</h6>
                                        <p class="text-muted small mb-0">100% secure payment</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-headset text-primary me-3 fa-lg"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">24/7 Support</h6>
                                        <p class="text-muted small mb-0">Dedicated support</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Tabs -->
<section class="product-tabs py-5 bg-light">
    <div class="container">
        <ul class="nav nav-tabs border-0" id="productTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button">
                    Description
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button">
                    Specifications
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button">
                    Reviews (128)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" type="button">
                    Shipping & Returns
                </button>
            </li>
        </ul>
        
        <div class="tab-content bg-white p-4 rounded-bottom-3 shadow-sm" id="productTabContent">
            <!-- Description Tab -->
            <div class="tab-pane fade show active" id="description">
                <h4 class="fw-bold mb-4">Product Description</h4>
                <p>{{ $product->description ?? 'No detailed description available.' }}</p>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3">Key Features</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> High quality material</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Durable construction</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Easy to use</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> One-year warranty</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3">What's in the Box</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-box me-2 text-primary"></i> 1 x Main Product</li>
                            <li class="mb-2"><i class="fas fa-box me-2 text-primary"></i> User Manual</li>
                            <li class="mb-2"><i class="fas fa-box me-2 text-primary"></i> Warranty Card</li>
                            <li class="mb-2"><i class="fas fa-box me-2 text-primary"></i> Charger/Cable (if applicable)</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Specifications Tab -->
            <div class="tab-pane fade" id="specifications">
                <h4 class="fw-bold mb-4">Product Specifications</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th class="bg-light" style="width: 30%;">Brand</th>
                                <td>E-Shop Premium</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Model</th>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Category</th>
                                <td>{{ $product->category->name ?? 'General' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Dimensions</th>
                                <td>10 x 8 x 2 inches</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Weight</th>
                                <td>1.5 lbs</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Warranty</th>
                                <td>1 Year Manufacturer</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Reviews Tab -->
            <div class="tab-pane fade" id="reviews">
                <h4 class="fw-bold mb-4">Customer Reviews</h4>
                
                <!-- Average Rating -->
                <div class="average-rating mb-5">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center">
                            <h1 class="fw-bold">4.5</h1>
                            <div class="stars text-warning mb-2">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <p class="text-muted">Based on 128 reviews</p>
                        </div>
                        <div class="col-md-8">
                            <!-- Rating bars would go here -->
                        </div>
                    </div>
                </div>
                
                <!-- Review Form -->
                <div class="review-form mb-5">
                    <h5 class="fw-bold mb-3">Write a Review</h5>
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Your Rating</label>
                            <div class="rating-stars">
                                <i class="far fa-star fa-2x text-warning me-1 cursor-pointer"></i>
                                <i class="far fa-star fa-2x text-warning me-1 cursor-pointer"></i>
                                <i class="far fa-star fa-2x text-warning me-1 cursor-pointer"></i>
                                <i class="far fa-star fa-2x text-warning me-1 cursor-pointer"></i>
                                <i class="far fa-star fa-2x text-warning cursor-pointer"></i>
                            </div>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" rows="4" placeholder="Write your review here..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>
                </div>
            </div>
            
            <!-- Shipping Tab -->
            <div class="tab-pane fade" id="shipping">
                <h4 class="fw-bold mb-4">Shipping & Returns</h4>
                
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <h5 class="fw-bold mb-3">Shipping Information</h5>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <h6 class="fw-bold"><i class="fas fa-shipping-fast text-primary me-2"></i> Standard Shipping</h6>
                                <p class="text-muted mb-0">5-7 business days | Free on orders over $50</p>
                            </li>
                            <li class="mb-3">
                                <h6 class="fw-bold"><i class="fas fa-bolt text-primary me-2"></i> Express Shipping</h6>
                                <p class="text-muted mb-0">2-3 business days | $9.99</p>
                            </li>
                            <li>
                                <h6 class="fw-bold"><i class="fas fa-plane text-primary me-2"></i> International Shipping</h6>
                                <p class="text-muted mb-0">10-15 business days | Rates vary by location</p>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <h5 class="fw-bold mb-3">Return Policy</h5>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <h6 class="fw-bold"><i class="fas fa-undo-alt text-primary me-2"></i> 30-Day Returns</h6>
                                <p class="text-muted mb-0">Full refund within 30 days of purchase</p>
                            </li>
                            <li class="mb-3">
                                <h6 class="fw-bold"><i class="fas fa-box-open text-primary me-2"></i> Condition</h6>
                                <p class="text-muted mb-0">Items must be unused and in original packaging</p>
                            </li>
                            <li>
                                <h6 class="fw-bold"><i class="fas fa-truck text-primary me-2"></i> Return Shipping</h6>
                                <p class="text-muted mb-0">Free returns for defective items</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<section class="related-products py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Related Products</h2>
            <p class="text-muted">You might also like</p>
        </div>
        
        @php
            $relatedProducts = \App\Models\Product::where('category_id', $product->category_id)
                                                  ->where('id', '!=', $product->id)
                                                  ->where('status', 'active')
                                                  ->limit(4)
                                                  ->get();
        @endphp
        
        @if($relatedProducts->count() > 0)
            <div class="row g-4">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="col-md-6 col-lg-3">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <a href="{{ route('product.detail', $relatedProduct->id) }}">
                                    @if($relatedProduct->image)
                                        <img src="{{ asset('storage/' . $relatedProduct->image) }}" 
                                             alt="{{ $relatedProduct->name }}"
                                             class="img-fluid w-100" 
                                             style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                             style="height: 200px;">
                                            <i class="fas fa-box fa-2x text-muted"></i>
                                        </div>
                                    @endif
                                </a>
                            </div>
                            <div class="product-body p-3">
                                <h6 class="product-title mb-2">
                                    <a href="{{ route('product.detail', $relatedProduct->id) }}" 
                                       class="text-dark text-decoration-none">
                                        {{ Str::limit($relatedProduct->name, 30) }}
                                    </a>
                                </h6>
                                <div class="product-price mb-2">
                                    <span class="h6 text-primary fw-bold">${{ number_format($relatedProduct->price, 2) }}</span>
                                </div>
                                <button class="btn btn-outline-primary btn-sm w-100 add-to-cart-btn" 
                                        data-product-id="{{ $relatedProduct->id }}"
                                        {{ $relatedProduct->stock <= 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-cart-plus me-1"></i> Add to Cart
                                </button>
                            </div>
                        </div>
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
    
    /* Product Images */
    .thumbnail-item {
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }
    
    .thumbnail-item.active {
        border-color: var(--primary-color);
    }
    
    .thumbnail-item:hover {
        border-color: var(--primary-dark);
    }
    
    /* Quantity Input */
    .input-group button {
        width: 40px;
    }
    
    /* Tabs */
    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 500;
        padding: 1rem 1.5rem;
        border-radius: 10px 10px 0 0;
    }
    
    .nav-tabs .nav-link.active {
        color: var(--primary-color);
        background: white;
        border-bottom: 3px solid var(--primary-color);
    }
    
    .nav-tabs .nav-link:hover {
        color: var(--primary-color);
    }
    
    /* Related Products */
    .related-products .product-card {
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }
    
    .related-products .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
    
    /* Rating Stars */
    .rating-stars .cursor-pointer {
        cursor: pointer;
    }
    
    .rating-stars .fa-star {
        transition: color 0.3s ease;
    }
    
    /* Table */
    .table th {
        background-color: #f8f9fa;
    }
    
    /* Buttons */
    .btn-lg {
        padding: 0.75rem 1.5rem;
    }
    
    /* Product Meta Icons */
    .product-meta i {
        width: 24px;
    }
    
    /* Alert */
    .alert {
        border-radius: 10px;
        border: none;
    }
    
    @media (max-width: 768px) {
        .product-detail h1 {
            font-size: 2rem;
        }
        
        .nav-tabs .nav-link {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }
        
        .tab-content {
            padding: 1.5rem !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Quantity controls
        $('#increaseQty').on('click', function() {
            const input = $('#productQty');
            const max = parseInt(input.attr('max'));
            let value = parseInt(input.val());
            
            if(value < max) {
                input.val(value + 1);
            }
        });
        
        $('#decreaseQty').on('click', function() {
            const input = $('#productQty');
            let value = parseInt(input.val());
            
            if(value > 1) {
                input.val(value - 1);
            }
        });
        
        // Add to cart from detail page
        $('#addToCartBtn').on('click', function() {
            const button = $(this);
            const originalText = button.html();
            const quantity = parseInt($('#productQty').val());
            
            if(button.hasClass('disabled')) return;
            
            // Show loading
            button.html('<i class="fas fa-spinner fa-spin me-2"></i> Adding...');
            button.prop('disabled', true);
            
            // Simulate API call
            setTimeout(() => {
                // Update cart count
                const cartCount = $('.cart-count').text();
                const newCount = parseInt(cartCount) + quantity;
                $('.cart-count').text(newCount);
                
                // Show success
                showToast(`${quantity} item(s) added to cart!`, 'success');
                
                // Reset button
                button.html(originalText);
                button.prop('disabled', false);
            }, 1000);
        });
        
        // Wishlist button
        $('#wishlistBtn').on('click', function() {
            const heartIcon = $(this).find('i');
            
            if(heartIcon.hasClass('far')) {
                heartIcon.removeClass('far').addClass('fas');
                showToast('Added to wishlist', 'success');
            } else {
                heartIcon.removeClass('fas').addClass('far');
                showToast('Removed from wishlist', 'info');
            }
        });
        
        // Rating stars interaction
        $('.rating-stars i').on('click', function() {
            const rating = $(this).index() + 1;
            $('.rating-stars i').removeClass('fas').addClass('far');
            
            for(let i = 0; i < rating; i++) {
                $('.rating-stars i').eq(i).removeClass('far').addClass('fas');
            }
        });
        
        // Thumbnail click
        $('.thumbnail-item').on('click', function() {
            $('.thumbnail-item').removeClass('active');
            $(this).addClass('active');
            
            const imgSrc = $(this).find('img').attr('src');
            if(imgSrc) {
                $('#mainProductImage').attr('src', imgSrc);
            }
        });
        
        // Toast notification
        function showToast(message, type = 'info') {
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
            
            const container = $('#toastContainer') || createToastContainer();
            container.append(toast);
            
            const bsToast = new bootstrap.Toast(toast[0]);
            bsToast.show();
            
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