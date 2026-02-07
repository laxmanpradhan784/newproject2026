@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <section>
        <div class="container py-5">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted"><i
                                class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('category.products', $product->category->slug) }}"
                            class="text-decoration-none text-muted">{{ $product->category->name }}</a></li>
                    <li class="breadcrumb-item active text-dark fw-semibold">{{ Str::limit($product->name, 30) }}</li>
                </ol>
            </nav>

            <div class="row g-4">
                <!-- Product Gallery & Info -->
                <div class="col-lg-8">
                    <!-- Product Card -->
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="card-body p-4 p-lg-5">
                            <div class="row g-4">
                                <!-- Image Gallery -->
                                <div class="col-md-6">
                                    <div class="sticky-top" style="top: 20px;">
                                        <!-- Main Image -->
                                        <div class="product-gallery-main mb-3 rounded-3 overflow-hidden position-relative"
                                            style="height: 380px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                            @php
                                                // Handle image logic properly
                                                $mainImage = null;
                                                $allImages = collect();

                                                if ($product->images && $product->images->count() > 0) {
                                                    $allImages = $product->images;
                                                    $mainImage =
                                                        $product->images->where('is_primary', 1)->first() ??
                                                        $product->images->first();
                                                } elseif ($product->image) {
                                                    // Handle single image field
                                                    $mainImage = (object) [
                                                        'image' => $product->image,
                                                        'alt_text' => $product->name,
                                                        'is_primary' => true,
                                                    ];
                                                    $allImages = collect([$mainImage]);
                                                }
                                            @endphp

                                            @if ($mainImage)
                                                <img src="{{ asset('uploads/product-images/' . $mainImage->image) }}"
                                                    class="w-100 h-100 object-fit-contain p-3" id="mainProductImage"
                                                    alt="{{ $mainImage->alt_text ?? $product->name }}" loading="lazy"
                                                    data-bs-toggle="modal" data-bs-target="#imageGalleryModal">
                                            @else
                                                <div
                                                    class="d-flex flex-column align-items-center justify-content-center h-100">
                                                    <i class="fas fa-camera fa-4x text-muted mb-3"></i>
                                                    <span class="text-muted">No Image Available</span>
                                                </div>
                                            @endif

                                            <!-- Badges -->
                                            <div class="position-absolute top-0 start-0 d-flex flex-column gap-2 m-3">
                                                @if ($product->stock > 0)
                                                    <span
                                                        class="badge bg-success bg-opacity-90 text-white px-3 py-2 rounded-pill fw-medium">
                                                        <i class="fas fa-check-circle me-1"></i> In Stock
                                                    </span>
                                                @else
                                                    <span
                                                        class="badge bg-danger bg-opacity-90 text-white px-3 py-2 rounded-pill fw-medium">
                                                        <i class="fas fa-times-circle me-1"></i> Out of Stock
                                                    </span>
                                                @endif

                                                @if ($product->old_price && $product->old_price > $product->price)
                                                    <span
                                                        class="badge bg-gradient-primary text-white px-3 py-2 rounded-pill fw-bold">
                                                        {{ number_format((($product->old_price - $product->price) / $product->old_price) * 100, 0) }}%
                                                        OFF
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Zoom & Wishlist -->
                                            <div class="position-absolute top-0 end-0 d-flex flex-column gap-2 m-3">
                                                @if ($mainImage)
                                                    <button class="btn btn-light btn-lg rounded-circle shadow-lg"
                                                        data-bs-toggle="modal" data-bs-target="#imageGalleryModal"
                                                        style="width: 48px; height: 48px;">
                                                        <i class="fas fa-search-plus text-dark"></i>
                                                    </button>
                                                @endif

                                                <button class="btn btn-light btn-lg rounded-circle shadow-lg wishlist-btn"
                                                    onclick="toggleWishlist(this, {{ $product->id }})"
                                                    data-product-id="{{ $product->id }}"
                                                    style="width: 48px; height: 48px;">
                                                    @if (auth()->check() && $product->isInWishlist())
                                                        <i class="fas fa-heart text-danger"></i>
                                                    @else
                                                        <i class="far fa-heart text-dark"></i>
                                                    @endif
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Thumbnails -->
                                        @if ($allImages->count() > 1)
                                            <div class="product-thumbnails">
                                                <div class="row g-2">
                                                    @foreach ($allImages as $index => $image)
                                                        <div class="col-3">
                                                            <div class="thumbnail-item border rounded-2 overflow-hidden cursor-pointer p-1 
                    {{ ($image->is_primary ?? false) || $index === 0 ? 'border-primary border-2' : 'border-light' }}"
                                                                style="height: 50px; background: #f8f9fa;"
                                                                onclick="changeMainImage(
                            '{{ asset('uploads/product-images/' . $image->image) }}', 
                            '{{ $image->alt_text ?? $product->name }}', 
                            this, 
                            {{ $index }}
                        )">

                                                                <img src="{{ asset('uploads/product-images/' . $image->image) }}"
                                                                    class="w-100 h-100 object-fit-cover rounded-1"
                                                                    alt="{{ $image->alt_text ?? $product->name }}"
                                                                    loading="lazy">
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>

                                <!-- Product Info -->
                                <div class="col-md-6">
                                    <div class="product-info">
                                        <!-- Category Badge -->
                                        <div class="mb-3">
                                            <span
                                                class="badge bg-primary bg-opacity-10 text-primary border border-primary px-3 py-2 rounded-pill">
                                                <i class="fas fa-tag me-1"></i> {{ $product->category->name }}
                                            </span>
                                        </div>

                                        <!-- Product Name -->
                                        <h1 class="fw-bold mb-3 display-6" style="color: #2c3e50;">{{ $product->name }}
                                        </h1>

                                        <!-- Rating -->
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rating-display d-flex align-items-center">
                                                <div class="stars me-2">
                                                    @php
                                                        $avgRating =
                                                            $product
                                                                ->reviews()
                                                                ->where('status', 'approved')
                                                                ->avg('rating') ?? 0;
                                                        $totalReviews = $product
                                                            ->reviews()
                                                            ->where('status', 'approved')
                                                            ->count();
                                                    @endphp
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= floor($avgRating))
                                                            <i class="fas fa-star text-warning"></i>
                                                        @elseif($i - 0.5 <= $avgRating)
                                                            <i class="fas fa-star-half-alt text-warning"></i>
                                                        @else
                                                            <i class="far fa-star text-warning"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span class="text-muted">({{ $totalReviews }} reviews)</span>
                                            </div>
                                        </div>

                                        <!-- Price -->
                                        <div class="product-price mb-4">
                                            <div class="d-flex align-items-center">
                                                <h2 class="text-gradient-primary fw-bold mb-0">
                                                    ₹{{ number_format($product->price, 2) }}</h2>
                                                @if ($product->old_price)
                                                    <div class="ms-3">
                                                        <span
                                                            class="text-decoration-line-through text-muted fs-5">₹{{ number_format($product->old_price, 2) }}</span>
                                                        <span
                                                            class="badge bg-danger bg-opacity-10 text-danger border border-danger ms-2">
                                                            Save
                                                            ₹{{ number_format($product->old_price - $product->price, 2) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Stock Status -->
                                        <div class="stock-status mb-4">
                                            @if ($product->stock > 0)
                                                <div class="alert alert-success border-0 d-flex align-items-center"
                                                    style="background: rgba(25, 135, 84, 0.1);">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    <span class="fw-medium">{{ $product->stock }} units available</span>
                                                </div>
                                            @else
                                                <div class="alert alert-danger border-0 d-flex align-items-center"
                                                    style="background: rgba(220, 53, 69, 0.1);">
                                                    <i class="fas fa-exclamation-circle text-danger me-2"></i>
                                                    <span class="fw-medium">Currently out of stock</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Add to Cart -->
                                        @if ($product->stock > 0)
                                            <div class="add-to-cart-form mb-4">
                                                <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                                    class="needs-validation" novalidate>
                                                    @csrf
                                                    <div class="row g-3 align-items-center mb-4">
                                                        <div class="col-auto">
                                                            <label class="form-label fw-bold">Quantity:</label>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="input-group" style="width: 140px;">
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary border-end-0 quantity-btn minus">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>
                                                                <input type="number" name="quantity"
                                                                    class="form-control border-start-0 border-end-0 text-center quantity-input"
                                                                    value="1" min="1"
                                                                    max="{{ $product->stock }}" required>
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary border-start-0 quantity-btn plus">
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-grid gap-3">
                                                        <button type="submit"
                                                            class="btn btn-primary btn-lg py-3 fw-bold">
                                                            <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                                                        </button>
                                                        {{-- <button type="button" class="btn btn-outline-primary btn-lg py-3"
                                                            onclick="buyNow({{ $product->id }})">
                                                            <i class="fas fa-bolt me-2"></i> Buy Now
                                                        </button> --}}
                                                    </div>
                                                </form>
                                            </div>
                                        @else
                                            <div class="out-of-stock mb-4">
                                                <button class="btn btn-secondary btn-lg w-100 py-3 mb-3" disabled>
                                                    <i class="fas fa-times-circle me-2"></i> Out of Stock
                                                </button>
                                                <button class="btn btn-outline-primary w-100 notify-btn"
                                                    data-id="{{ $product->id }}">
                                                    <i class="fas fa-bell me-2"></i> Notify When Available
                                                </button>
                                            </div>
                                        @endif

                                        <!-- Features -->
                                        {{-- <div class="features-grid mb-4">
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <div class="feature-card text-center p-3 border rounded-3">
                                                        <i class="fas fa-shipping-fast fa-2x text-primary mb-2"></i>
                                                        <p class="mb-1 small fw-medium">Free Shipping</p>
                                                        <small class="text-muted">Above ₹999</small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="feature-card text-center p-3 border rounded-3">
                                                        <i class="fas fa-undo fa-2x text-primary mb-2"></i>
                                                        <p class="mb-1 small fw-medium">Easy Returns</p>
                                                        <small class="text-muted">7 Days Policy</small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="feature-card text-center p-3 border rounded-3">
                                                        <i class="fas fa-shield-alt fa-2x text-primary mb-2"></i>
                                                        <p class="mb-1 small fw-medium">Secure Payment</p>
                                                        <small class="text-muted">100% Secure</small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="feature-card text-center p-3 border rounded-3">
                                                        <i class="fas fa-headset fa-2x text-primary mb-2"></i>
                                                        <p class="mb-1 small fw-medium">24/7 Support</p>
                                                        <small class="text-muted">Online Help</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}

                                        <!-- Share -->
                                        {{-- <div class="share-section">
                                            <p class="text-muted mb-2 small">Share this product:</p>
                                            <div class="d-flex gap-2">
                                                <a href="#" class="btn btn-sm btn-outline-primary rounded-circle"
                                                    style="width: 40px; height: 40px;">
                                                    <i class="fab fa-facebook-f"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-outline-info rounded-circle"
                                                    style="width: 40px; height: 40px;">
                                                    <i class="fab fa-twitter"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-outline-danger rounded-circle"
                                                    style="width: 40px; height: 40px;">
                                                    <i class="fab fa-instagram"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-outline-success rounded-circle"
                                                    style="width: 40px; height: 40px;">
                                                    <i class="fab fa-whatsapp"></i>
                                                </a>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Details Tabs -->
                    <div class="card border-0 shadow-lg rounded-4 mt-4">
                        <div class="card-body p-4">
                            <ul class="nav nav-pills nav-justified mb-4" id="productTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active py-3 fw-medium" id="description-tab"
                                        data-bs-toggle="tab" data-bs-target="#description" type="button"
                                        role="tab">
                                        <i class="fas fa-info-circle me-2"></i> Description
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link py-3 fw-medium" id="specifications-tab" data-bs-toggle="tab"
                                        data-bs-target="#specifications" type="button" role="tab">
                                        <i class="fas fa-list-alt me-2"></i> Specifications
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link py-3 fw-medium" id="reviews-tab" data-bs-toggle="tab"
                                        data-bs-target="#reviews" type="button" role="tab">
                                        <i class="fas fa-star me-2"></i> Reviews ({{ $totalReviews }})
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content" id="productTabContent">
                                <!-- Description -->
                                <div class="tab-pane fade show active" id="description" role="tabpanel">
                                    <div class="description-content">
                                        <h4 class="fw-bold mb-4 text-dark">Product Description</h4>
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="card border-0 bg-light">
                                                    <div class="card-body">
                                                        <p class="mb-0 fs-5 text-muted">
                                                            {{ $product->description ?? 'No detailed description available. This product is part of our premium collection, featuring high-quality materials and excellent craftsmanship. Perfect for daily use and designed to last.' }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Key Features -->
                                                <div class="mt-4">
                                                    <h5 class="fw-bold mb-3 text-dark">Key Features</h5>
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <ul class="list-unstyled">
                                                                <li class="mb-2">
                                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                                    Premium Quality Materials
                                                                </li>
                                                                <li class="mb-2">
                                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                                    Long Lasting Durability
                                                                </li>
                                                                <li class="mb-2">
                                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                                    Easy to Maintain
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <ul class="list-unstyled">
                                                                <li class="mb-2">
                                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                                    Modern Design
                                                                </li>
                                                                <li class="mb-2">
                                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                                    User Friendly
                                                                </li>
                                                                <li class="mb-2">
                                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                                    Value for Money
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="card border-primary border-2">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-award fa-3x text-primary mb-3"></i>
                                                        <h5 class="fw-bold text-dark">Premium Product</h5>
                                                        <p class="text-muted small">Certified quality product with warranty
                                                        </p>
                                                        <div class="d-grid">
                                                            <button class="btn btn-outline-primary">View Warranty
                                                                Details</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Specifications -->
                                <div class="tab-pane fade" id="specifications" role="tabpanel">
                                    <h4 class="fw-bold mb-4 text-dark">Product Specifications</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card border-0 shadow-sm mb-4">
                                                <div class="card-header bg-primary bg-opacity-10 border-0">
                                                    <h5 class="mb-0 text-primary fw-bold">Basic Information</h5>
                                                </div>
                                                <div class="card-body">
                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td class="fw-bold text-muted" width="40%">Product Name
                                                                </td>
                                                                <td class="fw-medium">{{ $product->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold text-muted">Category</td>
                                                                <td>
                                                                    <span
                                                                        class="badge bg-primary bg-opacity-10 text-primary">
                                                                        {{ $product->category->name }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold text-muted">SKU</td>
                                                                <td class="text-muted">
                                                                    PROD-{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold text-muted">Stock Status</td>
                                                                <td>
                                                                    @if ($product->stock > 0)
                                                                        <span
                                                                            class="badge bg-success bg-opacity-10 text-success border border-success">
                                                                            In Stock ({{ $product->stock }})
                                                                        </span>
                                                                    @else
                                                                        <span
                                                                            class="badge bg-danger bg-opacity-10 text-danger border border-danger">
                                                                            Out of Stock
                                                                        </span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card border-0 shadow-sm mb-4">
                                                <div class="card-header bg-primary bg-opacity-10 border-0">
                                                    <h5 class="mb-0 text-primary fw-bold">Pricing & Details</h5>
                                                </div>
                                                <div class="card-body">
                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td class="fw-bold text-muted" width="40%">Current
                                                                    Price</td>
                                                                <td class="fw-bold text-primary fs-5">
                                                                    ₹{{ number_format($product->price, 2) }}</td>
                                                            </tr>
                                                            @if ($product->old_price)
                                                                <tr>
                                                                    <td class="fw-bold text-muted">Original Price</td>
                                                                    <td>
                                                                        <span
                                                                            class="text-decoration-line-through text-muted">₹{{ number_format($product->old_price, 2) }}</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="fw-bold text-muted">You Save</td>
                                                                    <td class="text-success fw-bold">
                                                                        ₹{{ number_format($product->old_price - $product->price, 2) }}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <td class="fw-bold text-muted">Added Date</td>
                                                                <td>{{ $product->created_at->format('F d, Y') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold text-muted">Last Updated</td>
                                                                <td>{{ $product->updated_at->format('F d, Y') }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Reviews -->
                                <div class="tab-pane fade" id="reviews" role="tabpanel">
                                    <div class="reviews-section">
                                        <!-- Review Header -->
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div>
                                                <h4 class="fw-bold mb-0 text-dark">Customer Reviews</h4>
                                                <p class="text-muted mb-0">Real feedback from our customers</p>
                                            </div>

                                            @auth
                                                @php
                                                    $existingReview = \App\Models\Review::where(
                                                        'product_id',
                                                        $product->id,
                                                    )
                                                        ->where('user_id', auth()->id())
                                                        ->first();
                                                @endphp

                                                @if (!$existingReview)
                                                    <a href="{{ route('reviews.create', $product->id) }}"
                                                        class="btn btn-primary px-4">
                                                        <i class="fas fa-pen me-2"></i> Write a Review
                                                    </a>
                                                @else
                                                    <div class="btn-group">
                                                        <a href="{{ route('reviews.edit', $existingReview->id) }}"
                                                            class="btn btn-outline-primary">
                                                            <i class="fas fa-edit me-2"></i> Edit Review
                                                        </a>
                                                        <button type="button" class="btn btn-outline-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $existingReview->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            @else
                                                <a href="{{ route('login') }}?redirect={{ url()->current() }}"
                                                    class="btn btn-primary px-4">
                                                    <i class="fas fa-sign-in-alt me-2"></i> Login to Review
                                                </a>
                                            @endauth
                                        </div>

                                        <!-- Review Summary -->
                                        <div class="review-summary card border-0 shadow-sm mb-5">
                                            <div class="card-body p-4">
                                                <div class="row align-items-center">
                                                    <div class="col-md-4 text-center mb-4 mb-md-0">
                                                        <div class="total-rating">
                                                            <div class="display-1 fw-bold text-primary mb-2">
                                                                {{ number_format($avgRating, 1) }}</div>
                                                            <div class="rating-stars mb-3">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= floor($avgRating))
                                                                        <i class="fas fa-star text-warning fa-2x"></i>
                                                                    @elseif($i - 0.5 <= $avgRating)
                                                                        <i
                                                                            class="fas fa-star-half-alt text-warning fa-2x"></i>
                                                                    @else
                                                                        <i class="far fa-star text-warning fa-2x"></i>
                                                                    @endif
                                                                @endfor
                                                            </div>
                                                            <p class="text-muted mb-0">{{ $totalReviews }} verified
                                                                reviews</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        @php
                                                            $ratingDistribution = [];
                                                            for ($i = 5; $i >= 1; $i--) {
                                                                $count = $product
                                                                    ->reviews()
                                                                    ->where('rating', $i)
                                                                    ->where('status', 'approved')
                                                                    ->count();
                                                                $percentage =
                                                                    $totalReviews > 0
                                                                        ? ($count / $totalReviews) * 100
                                                                        : 0;
                                                                $ratingDistribution[$i] = [
                                                                    'count' => $count,
                                                                    'percentage' => $percentage,
                                                                ];
                                                            }
                                                        @endphp

                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <div class="rating-bar-row mb-3">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3" style="width: 80px;">
                                                                        <div class="d-flex align-items-center">
                                                                            <span
                                                                                class="text-muted me-2">{{ $i }}</span>
                                                                            <i class="fas fa-star text-warning"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <div class="progress" style="height: 8px;">
                                                                            <div class="progress-bar bg-warning"
                                                                                role="progressbar"
                                                                                style="width: {{ $ratingDistribution[$i]['percentage'] }}%">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ms-3" style="width: 60px;">
                                                                        <small class="text-muted text-end d-block">
                                                                            {{ $ratingDistribution[$i]['count'] }}
                                                                            ({{ number_format($ratingDistribution[$i]['percentage'], 1) }}%)
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Reviews List -->
                                        <div class="reviews-list">
                                            @php
                                                $approvedReviews = $product
                                                    ->reviews()
                                                    ->where('status', 'approved')
                                                    ->orderBy('created_at', 'desc')
                                                    ->paginate(5);
                                            @endphp

                                            @forelse($approvedReviews as $review)
                                                <div class="review-card card border-0 shadow-sm mb-4">
                                                    <div class="card-body">
                                                        <!-- Review Header -->
                                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                                            <div>
                                                                <h5 class="fw-bold mb-2 text-dark">{{ $review->title }}
                                                                </h5>
                                                                <div class="d-flex align-items-center flex-wrap gap-2">
                                                                    <div class="rating-stars">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            @if ($i <= $review->rating)
                                                                                <i class="fas fa-star text-warning"></i>
                                                                            @else
                                                                                <i class="far fa-star text-warning"></i>
                                                                            @endif
                                                                        @endfor
                                                                    </div>
                                                                    @if ($review->is_verified_purchase)
                                                                        <span
                                                                            class="badge bg-success bg-opacity-10 text-success border border-success">
                                                                            <i class="fas fa-check-circle me-1"></i>
                                                                            Verified Purchase
                                                                        </span>
                                                                    @endif
                                                                    <span class="text-muted small">•
                                                                        {{ $review->created_at->diffForHumans() }}</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Reviewer Info -->
                                                        <div class="review-author mb-4">
                                                            <div class="d-flex align-items-center">
                                                                <div class="author-avatar bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                                                    style="width: 45px; height: 45px;">
                                                                    <i class="fas fa-user"></i>
                                                                </div>
                                                                <div>
                                                                    <div class="fw-bold text-dark">
                                                                        {{ $review->user->name ?? 'Anonymous' }}</div>
                                                                    <small class="text-muted">Regular Customer</small>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Review Content -->
                                                        <p class="review-comment mb-4 text-muted">{{ $review->comment }}
                                                        </p>

                                                        <!-- Helpful Votes -->
                                                        <div class="helpful-votes border-top pt-3">
                                                            <small class="text-muted me-3 fw-medium">Was this review
                                                                helpful?</small>
                                                            <form action="{{ route('reviews.vote') }}" method="POST"
                                                                class="d-inline">
                                                                @csrf
                                                                <input type="hidden" name="review_id"
                                                                    value="{{ $review->id }}">
                                                                <input type="hidden" name="type" value="yes">
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-success me-2">
                                                                    <i class="fas fa-thumbs-up me-1"></i> Yes
                                                                    ({{ $review->helpful_yes }})
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('reviews.vote') }}" method="POST"
                                                                class="d-inline">
                                                                @csrf
                                                                <input type="hidden" name="review_id"
                                                                    value="{{ $review->id }}">
                                                                <input type="hidden" name="type" value="no">
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-danger">
                                                                    <i class="fas fa-thumbs-down me-1"></i> No
                                                                    ({{ $review->helpful_no }})
                                                                </button>
                                                            </form>
                                                        </div>

                                                        <!-- Admin Response -->
                                                        @if ($review->admin_response)
                                                            <div
                                                                class="admin-response mt-4 p-4 bg-primary bg-opacity-5 border-start border-4 border-primary rounded-3">
                                                                <div class="d-flex align-items-center mb-3">
                                                                    <div class="admin-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                                                        style="width: 35px; height: 35px;">
                                                                        <i class="fas fa-user-tie"></i>
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-bold text-primary">Admin Response
                                                                        </div>
                                                                        <small
                                                                            class="text-muted">{{ $review->response_date->format('M d, Y') }}</small>
                                                                    </div>
                                                                </div>
                                                                <p class="mb-0 text-dark">{{ $review->admin_response }}
                                                                </p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="text-center py-5">
                                                    <div class="empty-state mb-4">
                                                        <i class="fas fa-comments fa-4x text-muted mb-4"></i>
                                                        <h4 class="fw-bold text-dark mb-3">No reviews yet</h4>
                                                        <p class="text-muted mb-4">Be the first to share your experience
                                                            with this product!</p>
                                                        @auth
                                                            <a href="{{ route('reviews.create', $product->id) }}"
                                                                class="btn btn-primary px-5">
                                                                <i class="fas fa-pen me-2"></i> Write First Review
                                                            </a>
                                                        @else
                                                            <a href="{{ route('login') }}?redirect={{ url()->current() }}"
                                                                class="btn btn-primary px-5">
                                                                <i class="fas fa-sign-in-alt me-2"></i> Login to Review
                                                            </a>
                                                        @endauth
                                                    </div>
                                                </div>
                                            @endforelse

                                            <!-- Pagination -->
                                            @if ($approvedReviews->hasPages())
                                                <div class="d-flex justify-content-center mt-4">
                                                    <nav aria-label="Reviews pagination">
                                                        <ul class="pagination">
                                                            @if ($approvedReviews->onFirstPage())
                                                                <li class="page-item disabled">
                                                                    <span class="page-link">Previous</span>
                                                                </li>
                                                            @else
                                                                <li class="page-item">
                                                                    <a class="page-link"
                                                                        href="{{ $approvedReviews->previousPageUrl() }}">Previous</a>
                                                                </li>
                                                            @endif

                                                            @foreach ($approvedReviews->getUrlRange(1, $approvedReviews->lastPage()) as $page => $url)
                                                                <li
                                                                    class="page-item {{ $approvedReviews->currentPage() == $page ? 'active' : '' }}">
                                                                    <a class="page-link"
                                                                        href="{{ $url }}">{{ $page }}</a>
                                                                </li>
                                                            @endforeach

                                                            @if ($approvedReviews->hasMorePages())
                                                                <li class="page-item">
                                                                    <a class="page-link"
                                                                        href="{{ $approvedReviews->nextPageUrl() }}">Next</a>
                                                                </li>
                                                            @else
                                                                <li class="page-item disabled">
                                                                    <span class="page-link">Next</span>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </nav>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Related Products -->
                    <div class="card border-0 shadow-sm rounded-3 mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-th-large text-primary me-2"></i>
                                Related Products
                            </h5>
                        </div>
                        <div class="card-body p-3">
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
                                        class="list-group-item list-group-item-action border-0 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="related-product-image me-3">
                                                @if ($related->image)
                                                    <img src="{{ asset('uploads/products/' . $related->image) }}"
                                                        alt="{{ $related->name }}"
                                                        style="width:70px;height:70px;object-fit:cover;"
                                                        class="rounded-2 shadow-sm" loading="lazy">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center rounded-2 shadow-sm"
                                                        style="width:70px;height:70px;">
                                                        <i class="fas fa-box text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="fw-bold mb-1 text-dark">{{ Str::limit($related->name, 40) }}
                                                </h6>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span
                                                        class="text-success fw-bold">₹{{ number_format($related->price, 2) }}</span>
                                                    @if ($related->stock > 0)
                                                        <span class="badge bg-success bg-opacity-10 text-success small">
                                                            <i class="fas fa-check-circle"></i> In Stock
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger bg-opacity-10 text-danger small">
                                                            <i class="fas fa-times-circle"></i> Out of Stock
                                                        </span>
                                                    @endif
                                                </div>
                                                @if ($related->reviews()->where('status', 'approved')->count() > 0)
                                                    <div class="mt-1">
                                                        <small class="text-warning">
                                                            <i class="fas fa-star fa-xs"></i>
                                                            {{ number_format($related->reviews()->where('status', 'approved')->avg('rating') ?? 0, 1) }}
                                                        </small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="text-center py-4">
                                        <i class="fas fa-box-open fa-2x text-muted mb-3"></i>
                                        <p class="text-muted mb-0">No related products found</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Product Info Card -->
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle text-primary me-2"></i>
                                Product Details
                            </h5>
                        </div>
                        <div class="card-body p-3">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Category</span>
                                        <span class="fw-bold">{{ $product->category->name }}</span>
                                    </div>
                                </li>
                                <li class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Status</span>
                                        <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                        </span>
                                    </div>
                                </li>
                                <li class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Added Date</span>
                                        <span class="fw-bold">{{ $product->created_at->format('M d, Y') }}</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Last Updated</span>
                                        <span class="fw-bold">{{ $product->updated_at->format('M d, Y') }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Shipping Info -->
                    <div class="card border-0 shadow-sm rounded-3 mt-4">
                        <div class="card-body p-3">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-shipping-fast text-primary me-2"></i>
                                Shipping Info
                            </h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    <small>Free shipping on orders above ₹999</small>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    <small>Estimated delivery: 3-5 business days</small>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    <small>Cash on Delivery available</small>
                                </li>
                                <li>
                                    <i class="fas fa-check text-success me-2"></i>
                                    <small>7-day return policy</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Delete Modal -->
    @auth
        @if (isset($existingReview) && $existingReview)
            <div class="modal fade" id="deleteModal{{ $existingReview->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Review</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete your review for "{{ $product->name }}"?</p>
                            <p class="text-muted small">This action cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form action="{{ route('reviews.destroy', $existingReview->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete Review</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endauth

    <!-- Image Gallery Modal -->
    <div class="modal fade" id="imageGalleryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Product Gallery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- Main Image Display -->
                            <div class="col-lg-8 p-0">
                                <div class="gallery-main" style="height: 500px; background: #f8f9fa;">
                                    @if ($mainImage)
                                        <img src="{{ asset('uploads/product-images/' . $mainImage->image) }}"
                                            id="modalMainImage" class="img-fluid h-100 w-auto"
                                            style="object-fit: contain;"
                                            alt="{{ $mainImage->alt_text ?? $product->name }}" loading="lazy">
                                    @endif
                                </div>
                            </div>

                            <!-- Thumbnails & Info -->
                            <div class="col-lg-4 p-4">
                                <!-- Product Info -->
                                <div class="mb-4">
                                    <h4 class="fw-bold">{{ $product->name }}</h4>
                                    <div class="text-primary fw-bold fs-5">
                                        ₹{{ number_format($product->price, 2) }}
                                    </div>
                                </div>

                                <!-- Thumbnail Navigation -->
                                @if ($allImages->count() > 1)
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-3">Select Image</h6>
                                        <div class="row g-2">
                                            @foreach ($allImages as $index => $image)
                                                <div class="col-4">
                                                    <div class="gallery-thumbnail rounded-2 overflow-hidden border cursor-pointer 
                                                        {{ ($image->is_primary ?? false) || $index === 0 ? 'border-primary border-2' : 'border-light' }}"
                                                        style="height: 80px;"
                                                        onclick="changeModalImage('{{ asset('uploads/product-images/' . $image->image) }}', '{{ $image->alt_text ?? $product->name }}', this, {{ $index }})">
                                                        <img src="{{ asset('uploads/product-images/' . $image->image) }}"
                                                            class="img-fluid w-100 h-100" style="object-fit: cover;"
                                                            alt="{{ $image->alt_text ?? $product->name }}"
                                                            loading="lazy">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Image Counter -->
                                <div class="text-center">
                                    <small class="text-muted">
                                        Image
                                        <span id="currentImageIndex">1</span>
                                        of
                                        <span id="totalImages">{{ $allImages->count() }}</span>
                                    </small>
                                </div>

                                <!-- Navigation Controls -->
                                @if ($allImages->count() > 1)
                                    <div class="d-flex justify-content-center mt-3">
                                        <button class="btn btn-outline-primary me-2" onclick="prevImage()">
                                            <i class="fas fa-chevron-left"></i> Previous
                                        </button>
                                        <button class="btn btn-outline-primary" onclick="nextImage()">
                                            Next <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                @endif

                                <!-- Download Button -->
                                @if ($mainImage)
                                    <div class="mt-4">
                                        <button class="btn btn-outline-dark w-100" onclick="downloadCurrentImage()">
                                            <i class="fas fa-download me-2"></i> Download Image
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .product-gallery-main {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .product-gallery-main img {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
            }

            .thumbnail-item img {
                transition: all 0.3s ease;
            }

            .thumbnail-item:hover img {
                transform: scale(1.05);
            }

            .thumbnail-item.active {
                border-color: #0d6efd !important;
            }

            .gallery-main {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .gallery-main img {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
            }

            .gallery-thumbnail {
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .gallery-thumbnail:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .gallery-thumbnail.active {
                border-color: #0d6efd !important;
            }

            .rating-stars {
                color: #ffc107;
            }

            .review-card {
                border-left: 4px solid #0d6efd;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .review-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }

            .quantity-btn {
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .quantity-input {
                border-left: none;
                border-right: none;
                text-align: center;
                font-weight: bold;
            }

            .nav-tabs .nav-link {
                color: #6c757d;
                border: none;
                padding: 1rem 1.5rem;
            }

            .nav-tabs .nav-link.active {
                color: #0d6efd;
                background-color: transparent;
                border-bottom: 3px solid #0d6efd;
            }

            .related-product-image img {
                transition: transform 0.3s ease;
            }

            .related-product-image img:hover {
                transform: scale(1.1);
            }

            .progress {
                border-radius: 10px;
            }

            .progress-bar {
                border-radius: 10px;
            }

            .wishlist-btn {
                transition: all 0.3s ease;
                z-index: 10;
            }

            .wishlist-btn:hover {
                background: rgba(255, 255, 255, 1) !important;
                transform: scale(1.1);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }

            .wishlist-btn.active {
                background: rgba(255, 255, 255, 1) !important;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .product-gallery-main {
                    height: 300px !important;
                }

                .gallery-main {
                    height: 400px !important;
                }

                .product-thumbnails .row {
                    flex-wrap: nowrap;
                    overflow-x: auto;
                }

                .product-thumbnails .col-3 {
                    flex: 0 0 auto;
                    width: 25%;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Global variables for image gallery
            let currentProductImages = [];
            let currentImageIndex = 0;

            // Initialize images on page load
            document.addEventListener('DOMContentLoaded', function() {
                // Get all images from thumbnails
                const thumbnailElements = document.querySelectorAll('.thumbnail-item');
                currentProductImages = Array.from(thumbnailElements).map((item, index) => {
                    const img = item.querySelector('img');
                    return {
                        url: img.src,
                        alt: img.alt,
                        index: index,
                        element: item
                    };
                });

                // If no thumbnails, check main image
                if (currentProductImages.length === 0) {
                    const mainImg = document.getElementById('mainProductImage');
                    if (mainImg && mainImg.src) {
                        currentProductImages = [{
                            url: mainImg.src,
                            alt: mainImg.alt,
                            index: 0,
                            element: null
                        }];
                    }
                }

                // Set initial active thumbnail
                if (currentProductImages.length > 0) {
                    setActiveThumbnail(0);
                }

                // Quantity buttons
                document.querySelectorAll('.quantity-btn.plus').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const input = this.parentElement.querySelector('.quantity-input');
                        const max = parseInt(input.getAttribute('max'));
                        let value = parseInt(input.value) || 1;
                        if (value < max) {
                            input.value = value + 1;
                        }
                    });
                });

                document.querySelectorAll('.quantity-btn.minus').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const input = this.parentElement.querySelector('.quantity-input');
                        const min = parseInt(input.getAttribute('min'));
                        let value = parseInt(input.value) || 1;
                        if (value > min) {
                            input.value = value - 1;
                        }
                    });
                });

                // Notify when available
                document.querySelectorAll('.notify-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const productId = this.getAttribute('data-id');
                        alert('We will notify you when product #' + productId + ' is back in stock!');
                        this.innerHTML = '<i class="fas fa-bell me-1"></i> Notification Set';
                        this.classList.remove('btn-outline-primary');
                        this.classList.add('btn-outline-success');
                        this.disabled = true;
                    });
                });
            });

            // Change main image on thumbnail click
            function changeMainImage(imageUrl, altText, element, index) {
                // Update main image
                const mainImage = document.getElementById('mainProductImage');
                if (mainImage) {
                    mainImage.src = imageUrl;
                    mainImage.alt = altText;
                }

                // Update active thumbnail
                setActiveThumbnail(index);

                // Update current index
                currentImageIndex = index;

                // Update modal if open
                const modalImage = document.getElementById('modalMainImage');
                if (modalImage) {
                    modalImage.src = imageUrl;
                    modalImage.alt = altText;
                    updateImageCounter();
                }
            }

            // Change modal image
            function changeModalImage(imageUrl, altText, element, index) {
                const modalImage = document.getElementById('modalMainImage');
                if (modalImage) {
                    modalImage.src = imageUrl;
                    modalImage.alt = altText;
                }

                // Update active thumbnail in modal
                document.querySelectorAll('.gallery-thumbnail').forEach(item => {
                    item.classList.remove('border-primary', 'border-2', 'active');
                    item.classList.add('border-light');
                });
                if (element) {
                    element.classList.remove('border-light');
                    element.classList.add('border-primary', 'border-2', 'active');
                }

                // Update main image too
                const mainImage = document.getElementById('mainProductImage');
                if (mainImage) {
                    mainImage.src = imageUrl;
                    mainImage.alt = altText;
                }

                // Update current index
                currentImageIndex = index;
                updateImageCounter();
            }

            // Set active thumbnail
            function setActiveThumbnail(index) {
                document.querySelectorAll('.thumbnail-item').forEach(item => {
                    item.classList.remove('border-primary', 'border-2', 'active');
                    item.classList.add('border-light');
                });

                if (currentProductImages[index] && currentProductImages[index].element) {
                    currentProductImages[index].element.classList.remove('border-light');
                    currentProductImages[index].element.classList.add('border-primary', 'border-2', 'active');
                }
            }

            // Navigate to previous image
            function prevImage() {
                if (currentProductImages.length <= 1) return;

                currentImageIndex = (currentImageIndex - 1 + currentProductImages.length) % currentProductImages.length;
                const imageData = currentProductImages[currentImageIndex];

                // Update images
                changeMainImage(imageData.url, imageData.alt, imageData.element, currentImageIndex);
                changeModalImage(imageData.url, imageData.alt, imageData.element, currentImageIndex);
            }

            // Navigate to next image
            function nextImage() {
                if (currentProductImages.length <= 1) return;

                currentImageIndex = (currentImageIndex + 1) % currentProductImages.length;
                const imageData = currentProductImages[currentImageIndex];

                // Update images
                changeMainImage(imageData.url, imageData.alt, imageData.element, currentImageIndex);
                changeModalImage(imageData.url, imageData.alt, imageData.element, currentImageIndex);
            }

            // Update image counter
            function updateImageCounter() {
                const currentIndexElement = document.getElementById('currentImageIndex');
                const totalImagesElement = document.getElementById('totalImages');

                if (currentIndexElement) {
                    currentIndexElement.textContent = currentImageIndex + 1;
                }
                if (totalImagesElement) {
                    totalImagesElement.textContent = currentProductImages.length;
                }
            }

            // Download current image
            function downloadCurrentImage() {
                const modalImage = document.getElementById('modalMainImage');
                if (!modalImage) return;

                const imageUrl = modalImage.src;
                const imageName = `product-{{ $product->id }}-image-${currentImageIndex + 1}.jpg`;

                fetch(imageUrl)
                    .then(response => response.blob())
                    .then(blob => {
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.style.display = 'none';
                        a.href = url;
                        a.download = imageName;
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                        document.body.removeChild(a);

                        showToast('Image downloaded successfully!', 'success');
                    })
                    .catch(error => {
                        console.error('Download error:', error);
                        showToast('Failed to download image', 'error');
                    });
            }

            // Keyboard navigation for gallery
            document.addEventListener('keydown', function(e) {
                const galleryModal = document.getElementById('imageGalleryModal');
                if (!galleryModal || !galleryModal.classList.contains('show')) return;

                if (e.key === 'ArrowLeft') {
                    e.preventDefault();
                    prevImage();
                } else if (e.key === 'ArrowRight') {
                    e.preventDefault();
                    nextImage();
                } else if (e.key === 'Escape') {
                    const modal = bootstrap.Modal.getInstance(galleryModal);
                    if (modal) {
                        modal.hide();
                    }
                }
            });

            // Wishlist toggle function
            function toggleWishlist(button, productId) {
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
                                    button.title = 'Remove from Wishlist';
                                    button.classList.add('active');
                                    showToast('Added to wishlist!', 'success');
                                } else {
                                    icon.className = 'far fa-heart';
                                    button.title = 'Add to Wishlist';
                                    button.classList.remove('active');
                                    showToast('Removed from wishlist', 'info');
                                }

                                // Update wishlist count in navbar if function exists
                                if (typeof updateWishlistCount === 'function') {
                                    updateWishlistCount();
                                }
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

            // Buy Now function
            function buyNow(productId) {
                const quantity = document.querySelector('.quantity-input')?.value || 1;

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
                            showToast('Added to cart! Redirecting to checkout...', 'success');
                            setTimeout(() => {
                                window.location.href = '{{ route('checkout') }}';
                            }, 1000);
                        } else {
                            showToast(data.message || 'Failed to add to cart', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Something went wrong', 'error');
                    });
            }

            // Toast notification function
            function showToast(message, type = 'info') {
                // Create toast element
                const toast = document.createElement('div');
                toast.className = `toast align-items-center text-white bg-${type} border-0`;
                toast.setAttribute('role', 'alert');
                toast.setAttribute('aria-live', 'assertive');
                toast.setAttribute('aria-atomic', 'true');

                toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
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
    @endpush

@endsection
