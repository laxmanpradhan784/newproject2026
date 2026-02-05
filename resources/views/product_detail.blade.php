@extends('layouts.app')

@section('title', $product->name)

@section('content')

<section>
    <div class="container">
        <!-- Modern Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-5">
            <div class="d-flex align-items-center">
                <a href="{{ route('home') }}" class="text-decoration-none text-muted d-flex align-items-center">
                    <i class="fas fa-home me-2"></i> Home
                </a>
                <span class="mx-2 text-muted">/</span>
                <a href="{{ route('category.products', $product->category->slug) }}" 
                   class="text-decoration-none text-muted d-flex align-items-center">
                    <i class="fas fa-folder me-1"></i> {{ $product->category->name }}
                </a>
                <span class="mx-2 text-muted">/</span>
                <span class="text-dark fw-semibold">{{ Str::limit($product->name, 25) }}</span>
            </div>
        </nav>

        <div class="row g-4">
            <!-- Product Images & Details -->
            <div class="col-lg-8">
                <!-- Main Product Card -->
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5" style="background: white;">
                        <div class="row g-5 align-items-start">
                            <!-- Product Image Gallery -->
                            <div class="col-md-6">
                                <div class="position-relative">
                                    <!-- Main Image Container -->
                                    <div class="product-image-main rounded-3 overflow-hidden bg-light mb-3" 
                                         style="height: 400px; display: flex; align-items: center; justify-content: center;">
                                        @if ($product->image)
                                            <img src="{{ asset('uploads/products/' . $product->image) }}"
                                                class="img-fluid h-100 w-auto product-main-image" 
                                                alt="{{ $product->name }}"
                                                style="object-fit: contain; max-width: 100%;">
                                        @else
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-box-open fa-5x text-muted mb-3"></i>
                                                <span class="text-muted">No Image Available</span>
                                            </div>
                                        @endif
                                        
                                        <!-- Stock Badge -->
                                        @if ($product->stock > 0)
                                            <span class="position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill bg-success text-white fw-medium shadow-sm">
                                                <i class="fas fa-check-circle me-1"></i> In Stock
                                            </span>
                                        @else
                                            <span class="position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill bg-danger text-white fw-medium shadow-sm">
                                                <i class="fas fa-times-circle me-1"></i> Out of Stock
                                            </span>
                                        @endif
                                        
                                        <!-- Discount Badge -->
                                        @if ($product->old_price && $product->old_price > $product->price)
                                            <span class="position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill bg-primary text-white fw-bold shadow-sm">
                                                {{ number_format((($product->old_price - $product->price) / $product->old_price) * 100, 0) }}% OFF
                                            </span>
                                        @endif
                                        
                                        <!-- Wishlist Button -->
                                        <button class="btn btn-light btn-lg position-absolute bottom-0 end-0 m-3 rounded-circle shadow-lg wishlist-btn"
                                                onclick="toggleWishlist(this, {{ $product->id }})"
                                                title="{{ auth()->check() && $product->isInWishlist() ? 'Remove from Wishlist' : 'Add to Wishlist' }}"
                                                data-product-id="{{ $product->id }}"
                                                style="width: 56px; height: 56px;">
                                            @if(auth()->check() && $product->isInWishlist())
                                                <i class="fas fa-heart text-danger fs-5"></i>
                                            @else
                                                <i class="far fa-heart fs-5"></i>
                                            @endif
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="col-md-6">
                                <div class="product-info">
                                    <h1 class="fw-bold mb-3">{{ $product->name }}</h1>
                                    
                                    <!-- Rating & Reviews -->
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="rating-display">
                                            <div class="stars d-inline-block">
                                                @php
                                                    $avgRating = $product->reviews()->where('status', 'approved')->avg('rating') ?? 0;
                                                    $totalReviews = $product->reviews()->where('status', 'approved')->count();
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
                                            <span class="ms-2">
                                                <strong class="fs-5">{{ number_format($avgRating, 1) }}</strong>
                                                <span class="text-muted">({{ $totalReviews }} reviews)</span>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Price -->
                                    <div class="product-price mb-4">
                                        <h2 class="text-primary fw-bold display-6">₹{{ number_format($product->price, 2) }}</h2>
                                        @if ($product->old_price)
                                            <div class="text-muted">
                                                <span class="text-decoration-line-through me-2">₹{{ number_format($product->old_price, 2) }}</span>
                                                <span class="badge bg-danger">
                                                    Save ₹{{ number_format($product->old_price - $product->price, 2) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Highlights -->
                                    <div class="product-highlights mb-4">
                                        <h5 class="mb-3">Key Features</h5>
                                        <ul class="list-unstyled">
                                            <li class="mb-2">
                                                <i class="fas fa-check-circle text-success me-2"></i>
                                                <strong>Category:</strong> {{ $product->category->name }}
                                            </li>
                                            <li class="mb-2">
                                                <i class="fas fa-check-circle text-success me-2"></i>
                                                <strong>Availability:</strong> 
                                                @if ($product->stock > 0)
                                                    <span class="text-success">{{ $product->stock }} units available</span>
                                                @else
                                                    <span class="text-danger">Currently unavailable</span>
                                                @endif
                                            </li>
                                            <li class="mb-2">
                                                <i class="fas fa-check-circle text-success me-2"></i>
                                                <strong>Free Shipping</strong> on orders above ₹999
                                            </li>
                                            <li>
                                                <i class="fas fa-check-circle text-success me-2"></i>
                                                <strong>7-Day Return Policy</strong>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Add to Cart Form -->
                                    @if ($product->stock > 0)
                                        <div class="add-to-cart-form mb-4">
                                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                                @csrf
                                                <div class="row g-3 align-items-center">
                                                    <div class="col-auto">
                                                        <label class="form-label fw-bold">Quantity:</label>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="input-group" style="width: 150px;">
                                                            <button type="button" class="btn btn-outline-secondary quantity-btn minus">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                            <input type="number" name="quantity" class="form-control text-center quantity-input" 
                                                                   value="1" min="1" max="{{ $product->stock }}">
                                                            <button type="button" class="btn btn-outline-secondary quantity-btn plus">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mt-3">
                                                        <button type="submit" class="btn btn-primary btn-lg w-100 py-3">
                                                            <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    @else
                                        <div class="out-of-stock mb-4">
                                            <button class="btn btn-secondary btn-lg w-100 py-3" disabled>
                                                <i class="fas fa-times-circle me-2"></i> Out of Stock
                                            </button>
                                            <div class="mt-3 text-center">
                                                <button class="btn btn-outline-primary notify-btn" data-id="{{ $product->id }}">
                                                    <i class="fas fa-bell me-1"></i> Notify When Available
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Additional Info -->
                                    <div class="additional-info">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="text-center p-3 border rounded">
                                                    <i class="fas fa-shipping-fast fa-2x text-primary mb-2"></i>
                                                    <p class="mb-0 small">Free Shipping</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-center p-3 border rounded">
                                                    <i class="fas fa-undo fa-2x text-primary mb-2"></i>
                                                    <p class="mb-0 small">Easy Returns</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Description -->
                <div class="card border-0 shadow-sm rounded-3 mt-4">
                    <div class="card-header bg-white border-0">
                        <ul class="nav nav-tabs nav-justified" id="productTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" 
                                        data-bs-target="#description" type="button" role="tab">
                                    <i class="fas fa-info-circle me-2"></i>Description
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" 
                                        data-bs-target="#specifications" type="button" role="tab">
                                    <i class="fas fa-list-alt me-2"></i>Specifications
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" 
                                        data-bs-target="#reviews" type="button" role="tab">
                                    <i class="fas fa-star me-2"></i>Reviews ({{ $totalReviews }})
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content" id="productTabContent">
                            <!-- Description Tab -->
                            <div class="tab-pane fade show active" id="description" role="tabpanel">
                                <h4 class="mb-4">Product Description</h4>
                                <p class="mb-0 fs-5">{{ $product->description ?? 'No detailed description available.' }}</p>
                            </div>

                            <!-- Specifications Tab -->
                            <div class="tab-pane fade" id="specifications" role="tabpanel">
                                <h4 class="mb-4">Product Specifications</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td><strong>Product Name</strong></td>
                                                    <td>{{ $product->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Category</strong></td>
                                                    <td>{{ $product->category->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>SKU</strong></td>
                                                    <td>PROD-{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Stock Status</strong></td>
                                                    <td>
                                                        @if ($product->stock > 0)
                                                            <span class="badge bg-success">In Stock ({{ $product->stock }})</span>
                                                        @else
                                                            <span class="badge bg-danger">Out of Stock</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <td><strong>Price</strong></td>
                                                    <td class="text-primary fw-bold">₹{{ number_format($product->price, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Added Date</strong></td>
                                                    <td>{{ $product->created_at->format('M d, Y') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Last Updated</strong></td>
                                                    <td>{{ $product->updated_at->format('M d, Y') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Average Rating</strong></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="stars">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= floor($avgRating))
                                                                        <i class="fas fa-star text-warning fa-sm"></i>
                                                                    @elseif($i - 0.5 <= $avgRating)
                                                                        <i class="fas fa-star-half-alt text-warning fa-sm"></i>
                                                                    @else
                                                                        <i class="far fa-star text-warning fa-sm"></i>
                                                                    @endif
                                                                @endfor
                                                            </div>
                                                            <span class="ms-2">{{ number_format($avgRating, 1) }}/5</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Reviews Tab -->
                            <div class="tab-pane fade" id="reviews" role="tabpanel">
                                <div class="reviews-section">
                                    <!-- Review Header -->
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div>
                                            <h4 class="mb-0">Customer Reviews</h4>
                                            <p class="text-muted mb-0">Share your experience with this product</p>
                                        </div>
                                        
                                        @auth
                                            @php
                                                $existingReview = \App\Models\Review::where('product_id', $product->id)
                                                    ->where('user_id', auth()->id())
                                                    ->first();
                                            @endphp

                                            @if (!$existingReview)
                                                <a href="{{ route('reviews.create', $product->id) }}" class="btn btn-primary">
                                                    <i class="fas fa-pen me-1"></i> Write a Review
                                                </a>
                                            @else
                                                <div class="btn-group">
                                                    <a href="{{ route('reviews.edit', $existingReview->id) }}"
                                                        class="btn btn-outline-primary">
                                                        <i class="fas fa-edit me-1"></i> Edit Review
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $existingReview->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}?redirect={{ url()->current() }}"
                                                class="btn btn-primary">
                                                <i class="fas fa-pen me-1"></i> Login to Review
                                            </a>
                                        @endauth
                                    </div>

                                    <!-- Review Summary -->
                                    <div class="review-summary mb-5">
                                        <div class="row align-items-center">
                                            <div class="col-md-4 text-center mb-4 mb-md-0">
                                                <div class="total-rating">
                                                    <h2 class="display-4 fw-bold text-primary">{{ number_format($avgRating, 1) }}</h2>
                                                    <div class="rating-stars mb-2">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= floor($avgRating))
                                                                <i class="fas fa-star text-warning fs-4"></i>
                                                            @elseif($i - 0.5 <= $avgRating)
                                                                <i class="fas fa-star-half-alt text-warning fs-4"></i>
                                                            @else
                                                                <i class="far fa-star text-warning fs-4"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <p class="text-muted">{{ $totalReviews }} reviews</p>
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
                                                            $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                                                        $ratingDistribution[$i] = [
                                                            'count' => $count,
                                                            'percentage' => $percentage,
                                                        ];
                                                    }
                                                @endphp
                                                
                                                @for ($i = 5; $i >= 1; $i--)
                                                    <div class="rating-bar-row mb-2">
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-3" style="width: 80px;">
                                                                <small class="text-muted">{{ $i }} star</small>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <div class="progress" style="height: 10px;">
                                                                    <div class="progress-bar bg-warning" role="progressbar"
                                                                         style="width: {{ $ratingDistribution[$i]['percentage'] }}%"
                                                                         aria-valuenow="{{ $ratingDistribution[$i]['percentage'] }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ms-3" style="width: 60px;">
                                                                <small class="text-muted text-end d-block">{{ $ratingDistribution[$i]['count'] }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endfor
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
                                            <div class="review-card card border mb-4">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <div>
                                                            <h5 class="fw-bold mb-1">{{ $review->title }}</h5>
                                                            <div class="d-flex align-items-center">
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
                                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success ms-2">
                                                                        <i class="fas fa-check-circle"></i> Verified Purchase
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                                    </div>

                                                    <div class="review-author mb-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="author-avatar rounded-circle bg-light d-flex align-items-center justify-content-center me-3"
                                                                 style="width: 40px; height: 40px;">
                                                                <i class="fas fa-user text-muted"></i>
                                                            </div>
                                                            <div>
                                                                <div class="fw-bold">{{ $review->user->name ?? 'Anonymous' }}</div>
                                                                <small class="text-muted">Customer</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <p class="review-comment mb-3">{{ $review->comment }}</p>

                                                    <!-- Helpful Votes -->
                                                    <div class="helpful-votes">
                                                        <small class="text-muted me-3">Was this review helpful?</small>
                                                        <form action="{{ route('reviews.vote') }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="review_id" value="{{ $review->id }}">
                                                            <input type="hidden" name="type" value="yes">
                                                            <button type="submit" class="btn btn-sm btn-outline-success me-2">
                                                                <i class="fas fa-thumbs-up"></i> Yes ({{ $review->helpful_yes }})
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('reviews.vote') }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="review_id" value="{{ $review->id }}">
                                                            <input type="hidden" name="type" value="no">
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="fas fa-thumbs-down"></i> No ({{ $review->helpful_no }})
                                                            </button>
                                                        </form>
                                                    </div>

                                                    <!-- Admin Response -->
                                                    @if ($review->admin_response)
                                                        <div class="admin-response mt-4 p-3 bg-light border-start border-4 border-primary">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <div class="admin-avatar rounded-circle bg-primary d-flex align-items-center justify-content-center me-3"
                                                                     style="width: 30px; height: 30px;">
                                                                    <i class="fas fa-user-tie text-white"></i>
                                                                </div>
                                                                <div>
                                                                    <small class="fw-bold">Admin Response</small>
                                                                    <small class="text-muted ms-2">{{ $review->response_date->format('M d, Y') }}</small>
                                                                </div>
                                                            </div>
                                                            <p class="mb-0 small">{{ $review->admin_response }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center py-5">
                                                <i class="fas fa-comments fa-4x text-muted mb-4"></i>
                                                <h4>No reviews yet</h4>
                                                <p class="text-muted mb-4">Be the first to share your experience with this product!</p>
                                                @auth
                                                    <a href="{{ route('reviews.create', $product->id) }}" class="btn btn-primary">
                                                        <i class="fas fa-pen me-2"></i> Write First Review
                                                    </a>
                                                @else
                                                    <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="btn btn-primary">
                                                        <i class="fas fa-sign-in-alt me-2"></i> Login to Review
                                                    </a>
                                                @endauth
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
                                                                <a class="page-link" href="{{ $approvedReviews->previousPageUrl() }}">Previous</a>
                                                            </li>
                                                        @endif

                                                        @foreach ($approvedReviews->getUrlRange(1, $approvedReviews->lastPage()) as $page => $url)
                                                            <li class="page-item {{ $approvedReviews->currentPage() == $page ? 'active' : '' }}">
                                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                            </li>
                                                        @endforeach

                                                        @if ($approvedReviews->hasMorePages())
                                                            <li class="page-item">
                                                                <a class="page-link" href="{{ $approvedReviews->nextPageUrl() }}">Next</a>
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
                                                     class="rounded-2 shadow-sm">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center rounded-2 shadow-sm"
                                                     style="width:70px;height:70px;">
                                                    <i class="fas fa-box text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold mb-1 text-dark">{{ Str::limit($related->name, 40) }}</h6>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-success fw-bold">₹{{ number_format($related->price, 2) }}</span>
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
    @if(isset($existingReview) && $existingReview)
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

@push('styles')
<style>
    .product-image-container {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
    }
    
    .product-main-image {
        transition: transform 0.3s ease;
    }
    
    .product-main-image:hover {
        transform: scale(1.05);
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
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .admin-response {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 8px;
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
    
    .breadcrumb {
        background-color: transparent;
        padding: 0;
    }
    
    .breadcrumb-item a {
        color: #6c757d;
    }
    
    .breadcrumb-item.active {
        color: #495057;
    }
    
    .author-avatar {
        background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
    }
    
    .admin-avatar {
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
    }
    
    /* Wishlist Button Styling */
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
</style>
@endpush

@push('scripts')
<script>
    // Wishlist toggle function
    function toggleWishlist(button, productId) {
        @if(auth()->check())
            fetch('{{ route("wishlist.toggle") }}', {
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
                        icon.className = 'fas fa-heart text-danger fs-5';
                        button.title = 'Remove from Wishlist';
                        button.classList.add('active');
                        showToast('Added to wishlist!', 'success');
                    } else {
                        icon.className = 'far fa-heart fs-5';
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
                window.location.href = '{{ route("login") }}';
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
                        window.location.href = '{{ route("checkout") }}';
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

    // Update wishlist count in navbar
    function updateWishlistCount() {
        fetch('{{ route("wishlist.count") }}')
            .then(response => response.json())
            .then(data => {
                const countElement = document.querySelector('.wishlist-count');
                if (countElement) {
                    countElement.textContent = data.count;
                }
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
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

        // Bootstrap tab activation
        const triggerTabList = document.querySelectorAll('#productTab button');
        triggerTabList.forEach(triggerEl => {
            const tabTrigger = new bootstrap.Tab(triggerEl);
            triggerEl.addEventListener('click', event => {
                event.preventDefault();
                tabTrigger.show();
            });
        });
    });
</script>
@endpush

@endsection