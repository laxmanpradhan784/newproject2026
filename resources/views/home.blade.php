@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Slider with Overlay -->
    <section class="hero-section position-relative overflow-hidden">
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
            <!-- Indicators -->
            <div class="carousel-indicators position-absolute bottom-0 mb-5 z-2 d-none d-md-flex">
                @foreach ($sliders as $key => $slider)
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $key }}"
                        class="{{ $key == 0 ? 'active' : '' }} hero-indicator" aria-label="Slide {{ $key + 1 }}">
                    </button>
                @endforeach
            </div>

            <!-- Slides -->
            <div class="carousel-inner">
                @foreach ($sliders as $key => $slider)
                    <div class="carousel-item hero-slide {{ $key == 0 ? 'active' : '' }}">
                        <div class="hero-background position-absolute w-100 h-100"
                            style="background-image: url('{{ asset('uploads/sliders/' . $slider->image) }}')">
                        </div>

                        <!-- Overlay -->
                        <div class="hero-overlay position-absolute w-100 h-100"></div>

                        <!-- Content -->
                        <div class="container position-relative h-100 d-flex align-items-center">
                            <div class="hero-content text-white animate-slide-up">
                                @if ($slider->title)
                                    <h1 class="display-4 fw-bold mb-3 animate-fade-in">{{ $slider->title }}</h1>
                                @endif

                                @if ($slider->subtitle)
                                    <p class="lead mb-4 animate-fade-in" style="animation-delay: 0.2s">
                                        {{ $slider->subtitle }}
                                    </p>
                                @endif

                                @if ($slider->button_text && $slider->button_link)
                                    <a href="{{ $slider->button_link }}"
                                        class="btn btn-lg btn-primary px-5 py-3 rounded-pill hero-btn animate-fade-in"
                                        style="animation-delay: 0.4s">
                                        {{ $slider->button_text }}
                                        <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                @else
                                    <a href="{{ route('products') }}"
                                        class="btn btn-lg btn-primary px-5 py-3 rounded-pill hero-btn animate-fade-in"
                                        style="animation-delay: 0.4s">
                                        Shop Now
                                        <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev d-none d-md-flex" type="button" data-bs-target="#heroCarousel"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next d-none d-md-flex" type="button" data-bs-target="#heroCarousel"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>

            <!-- Mobile Indicators -->
            <div class="mobile-indicators d-flex d-md-none justify-content-center position-absolute bottom-0 mb-3 w-100">
                @foreach ($sliders as $key => $slider)
                    <span class="mobile-indicator {{ $key == 0 ? 'active' : '' }}"></span>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-sm-6">
                    <div class="feature-card text-center p-4 h-100 animate-fade-in">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-shipping-fast fa-3x text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Free Shipping</h5>
                        <p class="text-muted mb-0">On orders over ₹999</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="feature-card text-center p-4 h-100 animate-fade-in" style="animation-delay: 0.1s">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-sync-alt fa-3x text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Easy Returns</h5>
                        <p class="text-muted mb-0">30-day return policy</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="feature-card text-center p-4 h-100 animate-fade-in" style="animation-delay: 0.2s">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-shield-alt fa-3x text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Secure Payment</h5>
                        <p class="text-muted mb-0">100% secure & safe</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="feature-card text-center p-4 h-100 animate-fade-in" style="animation-delay: 0.3s">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-headset fa-3x text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-2">24/7 Support</h5>
                        <p class="text-muted mb-0">Dedicated support</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-products py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="display-5 fw-bold mb-3 animate-fade-in">Featured Products</h2>
                <p class="text-muted fs-5 animate-fade-in" style="animation-delay: 0.1s">
                    Premium selection of our best-selling items
                </p>
            </div>

            <div class="row g-4">
                @forelse($products as $product)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="card product-card border-0 shadow-sm h-100 overflow-hidden animate-scale-up">
                            <!-- Product Image with Badges -->
                            <div class="product-img-wrapper position-relative">
                                <a href="{{ route('product.show', $product->id) }}" class="d-block img-link">
                                    <div class="product-image position-relative"
                                        style="height: 220px; background: #f8fafc;">
                                        @if ($product->image)
                                            <img src="{{ asset('uploads/products/' . $product->image) }}"
                                                class="img-fluid w-100 h-auto product-img"
                                                style="object-fit: contain; height: 100%; width: 100%;"
                                                alt="{{ $product->name }}" loading="lazy">
                                        @else
                                            <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=400&fit=crop"
                                                class="img-fluid w-100 h-auto product-img"
                                                style="object-fit: contain; height: 100%; width: 100%;"
                                                alt="{{ $product->name }}" loading="lazy">
                                        @endif
                                    </div>
                                </a>

                                <!-- Top Badges -->
                                <div class="product-badges position-absolute top-0 start-0 p-3">
                                    @if ($product->stock <= 0)
                                        <span class="badge bg-danger px-3 py-2 rounded-pill fw-normal">Sold Out</span>
                                    @elseif ($product->is_new ?? true)
                                        <span class="badge bg-success px-3 py-2 rounded-pill fw-normal">New</span>
                                    @endif
                                    @if ($product->discount_percent > 0)
                                        <span class="badge bg-warning px-3 py-2 rounded-pill fw-normal">
                                            -{{ $product->discount_percent }}%
                                        </span>
                                    @endif
                                </div>

                                <!-- Quick Actions -->
                                <div class="product-actions position-absolute top-0 end-0 p-3 d-flex flex-column gap-2">
                                    <!-- Wishlist Button -->
                                    <button class="btn btn-light btn-icon rounded-circle shadow-sm wishlist-btn"
                                        onclick="toggleWishlist(this, {{ $product->id }})"
                                        title="{{ auth()->check() && $product->isInWishlist() ? 'Remove from Wishlist' : 'Add to Wishlist' }}"
                                        data-product-id="{{ $product->id }}">
                                        @if (auth()->check() && $product->isInWishlist())
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

                                <!-- Rating & Reviews -->
                                {{-- <div class="d-flex align-items-center mb-3">
                                    <div class="rating-display">
                                        <div class="stars d-inline-block">
                                            @php
                                                $avgRating =
                                                    $product->reviews()->where('status', 'approved')->avg('rating') ??
                                                    0;
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
                                        <span class="ms-2">
                                            <strong class="fs-5">{{ number_format($avgRating, 1) }}</strong>
                                            <span class="text-muted">({{ $totalReviews }} reviews)</span>
                                        </span>
                                    </div>
                                </div> --}}

                                <!-- Short Description -->
                                {{-- <p class="card-text text-muted small mb-3 product-description">
                                    {{ Str::limit($product->short_description ?? $product->description, 80, '...') }}
                                </p> --}}

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
                                    @elseif ($product->stock < 10)
                                        <span
                                            class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-2 rounded-pill">
                                            Only {{ $product->stock }} left
                                        </span>
                                    @endif
                                </div>

                                <!-- Stock Progress -->
                                @if ($product->stock > 0 && $product->stock < 20)
                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small class="text-muted">Hurry! Only {{ $product->stock }} left</small>
                                            <small class="text-muted">{{ round(($product->stock / 20) * 100) }}%</small>
                                        </div>
                                        <div class="progress stock-progress" style="height: 6px;">
                                            <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated"
                                                style="width: {{ ($product->stock / 20) * 100 }}%">
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- In Cart Controls (if item already in cart) -->
                                @if ($product->stock > 0 && $product->inCart())
                                    <div class="cart-controls mt-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="btn-group shadow-sm rounded-3 overflow-hidden">
                                                <form action="{{ route('cart.decrease', $product->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-outline-secondary px-3 py-2 border-0">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </form>

                                                <!-- Hidden input for cart quantity -->
                                                <input type="number" class="d-none"
                                                    value="{{ $product->cartQuantity() }}">

                                                <!-- Visible display -->
                                                <span
                                                    class="px-3 py-2 bg-light fw-bold d-flex align-items-center justify-content-center"
                                                    style="min-width: 40px; background: #f8f9fa;">
                                                    {{ $product->cartQuantity() }}
                                                </span>

                                                <form action="{{ route('cart.increase', $product->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-outline-secondary px-3 py-2 border-0"
                                                        {{ $product->cartQuantity() >= $product->stock ? 'disabled' : '' }}>
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </form>
                                            </div>

                                            <a href="{{ route('cart') }}" class="btn btn-success px-4 py-2 rounded-3">
                                                <i class="fas fa-check me-1"></i> In Cart
                                            </a>
                                        </div>
                                    </div>
                                @elseif ($product->stock > 0)
                                    <!-- Quantity Selector -->
                                    <div class="mt-3">
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                            class="add-to-cart-form" data-product-id="{{ $product->id }}">
                                            @csrf

                                            <!-- Hidden input for form submission -->
                                            <input type="number" name="quantity" class="quantity-input d-none"
                                                value="1" min="1" max="{{ $product->stock }}"
                                                id="quantity-{{ $product->id }}" data-product-id="{{ $product->id }}">

                                            <div class="d-flex align-items-stretch gap-2">
                                                <!-- Quantity Controls -->
                                                <div
                                                    class="d-flex align-items-center bg-light rounded-3 overflow-hidden shadow-sm">
                                                    <button type="button"
                                                        class="btn btn-white quantity-minus px-1 py-2 border-0"
                                                        data-product-id="{{ $product->id }}">
                                                        <i class="fas fa-minus text-dark"></i>
                                                    </button>

                                                    <!-- Visible quantity display -->
                                                    <div class="quantity-display px-3 py-2 fw-bold text-center bg-white"
                                                        data-product-id="{{ $product->id }}" style="min-width: 50px;">
                                                        1
                                                    </div>

                                                    <button type="button"
                                                        class="btn btn-white quantity-plus px-3 py-2 border-0"
                                                        data-product-id="{{ $product->id }}">
                                                        <i class="fas fa-plus text-dark"></i>
                                                    </button>
                                                </div>

                                                <!-- Add to Cart Button -->
                                                <button type="submit"
                                                    class="btn btn-primary flex-grow-1 add-to-cart-btn py-2 px-3">
                                                    <i class="fas fa-cart-plus me-2"></i> Add
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @else
                                    <!-- Out of Stock -->
                                    <button class="btn btn-outline-secondary w-100 mt-3 py-3 rounded-3" disabled>
                                        <i class="fas fa-times-circle me-2"></i>Notify When Available
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-box-open display-1 text-muted opacity-25"></i>
                            </div>
                            <h4 class="fw-semibold text-muted mb-3">No Products Found</h4>
                            <p class="text-muted mb-4">Check back soon for new arrivals!</p>
                            <a href="{{ route('home') }}" class="btn btn-outline-primary px-4">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- View All Button -->
            @if ($products->count() > 0)
                <div class="text-center mt-5 pt-3">
                    <a href="{{ route('products') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-pill">
                        View All Products <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Banner Section -->
    <section class="banner-section py-5">
        <div class="container">
            <div class="row align-items-center banner-content rounded-3 overflow-hidden shadow-lg">
                <div class="col-lg-8 p-5">
                    <div class="animate-fade-in">
                        <span class="badge bg-warning text-dark mb-3 px-3 py-2">Limited Time Offer</span>
                        <h2 class="display-6 fw-bold text-white mb-3">Up to 50% Off on Electronics!</h2>
                        <p class="lead text-white mb-4">Don't miss out on our biggest sale of the year. Limited stock
                            available.</p>
                        <div class="countdown-timer d-flex gap-3 mb-4">
                            <div class="countdown-item">
                                <div
                                    class="countdown-value bg-white text-dark rounded-circle d-flex align-items-center justify-content-center">
                                    <span class="days">00</span>
                                </div>
                                <span class="countdown-label text-white">Days</span>
                            </div>
                            <div class="countdown-item">
                                <div
                                    class="countdown-value bg-white text-dark rounded-circle d-flex align-items-center justify-content-center">
                                    <span class="hours">00</span>
                                </div>
                                <span class="countdown-label text-white">Hours</span>
                            </div>
                            <div class="countdown-item">
                                <div
                                    class="countdown-value bg-white text-dark rounded-circle d-flex align-items-center justify-content-center">
                                    <span class="minutes">00</span>
                                </div>
                                <span class="countdown-label text-white">Minutes</span>
                            </div>
                            <div class="countdown-item">
                                <div
                                    class="countdown-value bg-white text-dark rounded-circle d-flex align-items-center justify-content-center">
                                    <span class="seconds">00</span>
                                </div>
                                <span class="countdown-label text-white">Seconds</span>
                            </div>
                        </div>
                        <div class="d-flex gap-3">
                            <a href="{{ route('category.products', 'electronics') }}" class="btn btn-light btn-lg px-4">
                                Shop Electronics <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                            <a href="#" class="btn btn-outline-light btn-lg px-4">
                                View All Deals
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-0 d-none d-lg-block">
                    <div class="banner-image h-100"
                        style="background-image: url('https://images.unsplash.com/photo-1498049794561-7780e7231661?w=600&auto=format&fit=crop');">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Categories -->
    <section class="categories py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Shop by Category</h2>
                <p class="text-muted fs-5">Browse products from our popular categories</p>
            </div>

            <div class="row g-4 justify-content-center">
                @php
                    $categories = \App\Models\Category::where('status', 'active')
                        ->withCount('products')
                        ->orderByDesc('products_count')
                        ->take(4)
                        ->get();
                @endphp

                @forelse($categories as $category)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <a href="{{ route('category.products', $category->slug) }}"
                            class="category-card-link text-decoration-none">
                            <div
                                class="category-card text-center border-0 shadow-sm rounded-3 p-4 h-100 position-relative overflow-hidden">
                                <!-- Category Icon -->
                                <div class="category-icon-wrapper mb-4">
                                    <div class="category-icon mx-auto" style="width: 80px">
                                        @php
                                            $icon = match (strtolower($category->name)) {
                                                'electronics', 'electronic' => 'tv',
                                                'fashion', 'clothing' => 'tshirt',
                                                'home', 'kitchen', 'home & kitchen' => 'home',
                                                'books', 'stationery' => 'book',
                                                'sports', 'fitness' => 'futbol',
                                                'beauty', 'health', 'beauty & health' => 'spa',
                                                'toys', 'games' => 'gamepad',
                                                'food', 'grocery' => 'shopping-basket',
                                                default => 'shopping-bag',
                                            };
                                        @endphp
                                        <i class="fas fa-{{ $category->icon ?? $icon }} fa-3x text-primary"></i>
                                    </div>
                                </div>

                                <!-- Category Info -->
                                <h5 class="category-title fw-bold mb-2">{{ $category->name }}</h5>
                                <p class="text-muted small mb-3">
                                    {{ $category->products_count ?? 0 }} Products
                                </p>

                                <!-- Shop Now Button -->
                                <span class="btn btn-outline-primary btn-sm">
                                    Shop Now <i class="fas fa-arrow-right ms-1"></i>
                                </span>

                                <!-- Hover Effect -->
                                <div class="category-hover-overlay"></div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No categories found.</p>
                    </div>
                @endforelse
            </div>

            @if ($categories->count() > 0)
                <div class="text-center mt-5">
                    <a href="{{ route('products') }}" class="btn btn-outline-primary btn-lg px-5">
                        View All Categories <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Testimonials -->
    {{-- <section class="testimonials py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">What Our Customers Say</h2>
                <p class="text-muted fs-5">Trusted by thousands of happy customers</p>
            </div>
            
            <div class="row g-4">
                @for ($i = 1; $i <= 3; $i++)
                    <div class="col-md-4">
                        <div class="testimonial-card p-4 rounded-3 shadow-sm h-100">
                            <div class="testimonial-rating mb-3">
                                @for ($j = 1; $j <= 5; $j++)
                                    <i class="fas fa-star text-warning"></i>
                                @endfor
                            </div>
                            <p class="testimonial-text mb-4">"Excellent shopping experience! The products are high quality and delivery was super fast."</p>
                            <div class="testimonial-author d-flex align-items-center">
                                <div class="author-avatar bg-primary rounded-circle me-3"></div>
                                <div>
                                    <h6 class="fw-bold mb-0">Customer {{ $i }}</h6>
                                    <small class="text-muted">Verified Buyer</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section> --}}

    <!-- Newsletter -->
    {{-- <section class="newsletter py-5 bg-primary text-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="display-6 fw-bold mb-3">Stay Updated</h2>
                    <p class="lead mb-4">Subscribe to our newsletter for exclusive deals and updates</p>
                    <form class="newsletter-form mx-auto" style="max-width: 500px;">
                        <div class="input-group input-group-lg">
                            <input type="email" class="form-control" placeholder="Enter your email" aria-label="Email">
                            <button class="btn btn-light" type="submit">
                                Subscribe <i class="fas fa-paper-plane ms-2"></i>
                            </button>
                        </div>
                    </form>
                    <p class="small mt-3 mb-0">By subscribing, you agree to our Privacy Policy</p>
                </div>
            </div>
        </div>
    </section> --}}
@endsection

@push('styles')
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-dark: #3a56d4;
            --secondary-color: #7209b7;
            --success-color: #4cc9f0;
            --danger-color: #f72585;
            --warning-color: #f8961e;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes scaleUp {
            from {
                transform: scale(0.95);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .animate-slide-up {
            animation: slideUp 0.8s ease-out;
        }

        .animate-scale-up {
            animation: scaleUp 0.5s ease-out;
        }

        .animate-pulse {
            animation: pulse 2s infinite;
        }

        /* Hero Section */
        .hero-section {
            height: 90vh;
            min-height: 600px;
            max-height: 800px;
        }

        .hero-slide {
            height: 90vh;
            min-height: 600px;
            max-height: 800px;
        }

        .hero-background {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .hero-overlay {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.3) 100%);
        }

        .hero-content {
            max-width: 700px;
        }

        .hero-indicator {
            width: 12px;
            height: 12px;
            border: 2px solid white;
            background-color: transparent;
            border-radius: 50%;
            margin: 0 5px;
            opacity: 0.5;
            transition: all 0.3s ease;
        }

        .hero-indicator.active {
            opacity: 1;
            background-color: white;
            transform: scale(1.2);
        }

        .mobile-indicator {
            width: 8px;
            height: 8px;
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            margin: 0 4px;
        }

        .mobile-indicator.active {
            background-color: white;
            transform: scale(1.3);
        }

        .hero-btn {
            transition: all 0.3s ease;
        }

        .hero-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        /* Features */
        .feature-card {
            background: white;
            border-radius: 12px;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1);
        }

        /* Product Card */
        .product-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 16px;
            background: white;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12) !important;
        }

        .product-img-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 12px 12px 0 0;
        }

        .product-img {
            height: 280px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-img {
            transform: scale(1.05);
        }

        .product-hover-overlay {
            background: rgba(0, 0, 0, 0.7);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .product-card:hover .product-hover-overlay {
            opacity: 1;
        }

        .add-to-cart-hover {
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .product-card:hover .add-to-cart-hover {
            transform: translateY(0);
            opacity: 1;
        }

        .product-badges {
            z-index: 2;
        }

        .product-actions {
            z-index: 3;
            transform: translateX(20px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .product-card:hover .product-actions {
            transform: translateX(0);
            opacity: 1;
        }

        .btn-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .quick-view-btn:hover {
            background: var(--primary-color) !important;
            color: white;
        }

        .wishlist-btn:hover {
            background: var(--danger-color) !important;
            color: white;
        }

        .category-link:hover {
            color: var(--primary-dark) !important;
        }

        .product-title a:hover {
            color: var(--primary-color) !important;
        }

        /* Banner Section */
        .banner-content {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            position: relative;
            overflow: hidden;
        }

        .banner-image {
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .banner-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent 0%, rgba(0, 0, 0, 0.1) 100%);
        }

        .countdown-timer {
            display: flex;
            gap: 15px;
        }

        .countdown-item {
            text-align: center;
        }

        .countdown-value {
            width: 70px;
            height: 70px;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .countdown-label {
            font-size: 0.875rem;
            opacity: 0.9;
        }

        /* Category Cards */
        .category-card {
            transition: all 0.3s ease;
            background: white;
            overflow: hidden;
        }

        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
        }

        .category-icon-wrapper {
            position: relative;
            z-index: 1;
        }

        .category-icon {
            width: 90px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(67, 97, 238, 0.1);
            transition: all 0.3s ease;
        }

        .category-card:hover .category-icon {
            background: var(--primary-color);
            transform: scale(1.1);
        }

        .category-card:hover .category-icon i {
            color: white !important;
        }

        .category-hover-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(67, 97, 238, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .category-card:hover .category-hover-overlay {
            opacity: 1;
        }

        /* Testimonials */
        .testimonial-card {
            transition: all 0.3s ease;
            background: white;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
        }

        .testimonial-text {
            line-height: 1.6;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
        }

        /* Newsletter */
        .newsletter-form .form-control {
            border: none;
            padding-left: 25px;
        }

        .newsletter-form .form-control:focus {
            box-shadow: none;
        }

        /* Quantity Selector */
        .quantity-selector .input-group {
            max-width: 140px;
        }

        .quantity-input {
            max-width: 60px;
            border-color: #dee2e6;
            font-weight: 600;
        }

        .quantity-input:focus {
            box-shadow: none;
            border-color: var(--primary-color);
        }

        .quantity-decrease:hover,
        .quantity-increase:hover {
            background-color: #f8f9fa;
        }

        /* Stock Progress */
        .stock-progress {
            border-radius: 10px;
            overflow: hidden;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section {
                height: 60vh;
                min-height: 400px;
            }

            .hero-slide {
                height: 60vh;
                min-height: 400px;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-content .lead {
                font-size: 1rem;
            }

            .product-img {
                height: 200px;
            }

            .countdown-value {
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
            }

            .feature-card {
                margin-bottom: 20px;
            }

            .section-header h2 {
                font-size: 2rem;
            }
        }

        @media (max-width: 576px) {
            .hero-section {
                height: 50vh;
                min-height: 300px;
            }

            .hero-slide {
                height: 50vh;
                min-height: 300px;
            }

            .countdown-timer {
                gap: 8px;
            }

            .countdown-value {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .product-actions-bottom .d-flex {
                flex-direction: column;
            }

            .quantity-selector {
                width: 100%;
                margin-bottom: 10px;
            }

            .add-to-cart-btn {
                width: 50%;
            }
        }

        /* Loading states */
        .loading {
            position: relative;
            overflow: hidden;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        /* Accessibility */
        :focus-visible {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        /* Touch device optimizations */
        @media (hover: none) and (pointer: coarse) {

            .product-hover-overlay,
            .add-to-cart-hover {
                display: none !important;
            }

            .product-actions {
                opacity: 1;
                transform: translateX(0);
            }

            .btn-icon {
                min-width: 44px;
                min-height: 44px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize animations
            initAnimations();

            // Initialize countdown timer
            initCountdown();

            // Initialize product interactions
            initProductInteractions();

            // Initialize newsletter form
            initNewsletter();

            // Initialize carousel
            initCarousel();
        });

        function initAnimations() {
            // Add animation classes on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in');
                    }
                });
            }, observerOptions);

            // Observe elements for animation
            document.querySelectorAll('.animate-on-scroll').forEach(el => {
                observer.observe(el);
            });
        }

        function initCountdown() {
            // Set end date (7 days from now)
            const countdownDate = new Date();
            countdownDate.setDate(countdownDate.getDate() + 7);

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = countdownDate - now;

                if (distance < 0) {
                    document.querySelectorAll('.countdown-timer').forEach(timer => {
                        timer.innerHTML = '<div class="text-white fw-bold">Sale Ended!</div>';
                    });
                    return;
                }

                // Calculate time
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Update display
                document.querySelectorAll('.days').forEach(el => el.textContent = days.toString().padStart(2, '0'));
                document.querySelectorAll('.hours').forEach(el => el.textContent = hours.toString().padStart(2, '0'));
                document.querySelectorAll('.minutes').forEach(el => el.textContent = minutes.toString().padStart(2, '0'));
                document.querySelectorAll('.seconds').forEach(el => el.textContent = seconds.toString().padStart(2, '0'));
            }

            // Update every second
            updateCountdown();
            setInterval(updateCountdown, 1000);
        }

        // Product Quantity Controls
        function initProductQuantityControls() {
            // Plus button
            document.querySelectorAll('.quantity-plus').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const input = document.getElementById(`quantity-${productId}`);
                    const display = document.querySelector(
                        `.quantity-display[data-product-id="${productId}"]`);
                    const max = parseInt(input.getAttribute('max'));
                    let currentValue = parseInt(input.value) || 1;

                    if (currentValue < max) {
                        input.value = currentValue + 1;
                        if (display) display.textContent = input.value;
                    }
                });
            });

            // Minus button
            document.querySelectorAll('.quantity-minus').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const input = document.getElementById(`quantity-${productId}`);
                    const display = document.querySelector(
                        `.quantity-display[data-product-id="${productId}"]`);
                    const min = parseInt(input.getAttribute('min'));
                    let currentValue = parseInt(input.value) || 1;

                    if (currentValue > min) {
                        input.value = currentValue - 1;
                        if (display) display.textContent = input.value;
                    }
                });
            });

            // Add to cart form submission
            document.querySelectorAll('.add-to-cart-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    const productId = this.getAttribute('data-product-id');
                    const button = this.querySelector('.add-to-cart-btn');
                    const originalText = button.innerHTML;

                    // Show loading state
                    button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Adding...';
                    button.disabled = true;

                    // You can optionally add AJAX submission here
                    // For now, let the form submit normally

                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }, 2000);
                });
            });
        }

        // Call this function on DOMContentLoaded
        document.addEventListener('DOMContentLoaded', function() {
            initProductQuantityControls();
            // ... rest of your existing code ...
        });

        function initNewsletter() {
            const form = document.querySelector('.newsletter-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const email = this.querySelector('input[type="email"]').value.trim();

                    if (!email) {
                        showToast('Please enter your email address', 'warning');
                        return;
                    }

                    if (!validateEmail(email)) {
                        showToast('Please enter a valid email address', 'warning');
                        return;
                    }

                    // Simulate subscription
                    const button = this.querySelector('button');
                    const originalText = button.innerHTML;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Subscribing...';
                    button.disabled = true;

                    setTimeout(() => {
                        showToast('Thank you for subscribing to our newsletter!', 'success');
                        this.reset();
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }, 1500);
                });
            }
        }

        function initCarousel() {
            const carousel = document.getElementById('heroCarousel');
            if (carousel) {
                // Auto-play
                new bootstrap.Carousel(carousel, {
                    interval: 5000,
                    ride: 'carousel',
                    wrap: true
                });

                // Update mobile indicators
                carousel.addEventListener('slide.bs.carousel', function(e) {
                    const indicators = document.querySelectorAll('.mobile-indicator');
                    indicators.forEach((indicator, index) => {
                        indicator.classList.toggle('active', index === e.to);
                    });
                });
            }
        }

        // Wishlist toggle function
        function toggleWishlist(button, productId) {
            @if (auth()->check())
                const originalHTML = button.innerHTML;
                const originalTitle = button.title;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                button.disabled = true;

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
                            // Update button
                            if (data.action === 'added') {
                                button.innerHTML = '<i class="fas fa-heart text-danger"></i>';
                                button.title = 'Remove from Wishlist';
                                button.classList.add('active');

                                // Show success message
                                showToast('Added to wishlist!', 'success');

                                // Optional: Add animation
                                button.classList.add('animate__animated', 'animate__heartBeat');
                                setTimeout(() => {
                                    button.classList.remove('animate__animated', 'animate__heartBeat');
                                }, 1000);
                            } else {
                                button.innerHTML = '<i class="far fa-heart"></i>';
                                button.title = 'Add to Wishlist';
                                button.classList.remove('active');

                                // Show info message
                                showToast('Removed from wishlist', 'info');
                            }

                            // Update wishlist count in navbar if function exists
                            if (typeof updateWishlistCount === 'function') {
                                updateWishlistCount();
                            }

                            // Alternative: Check if navbar has update function
                            if (window.Navbar && window.Navbar.updateWishlistCount) {
                                window.Navbar.updateWishlistCount();
                            }
                        } else {
                            // If API returns error
                            button.innerHTML = originalHTML;
                            button.title = originalTitle;
                            showToast(data.message || 'Something went wrong', 'error');
                        }
                    })
                    // .catch(error => {
                    //     console.error('Error:', error);
                    //     button.innerHTML = originalHTML;
                    //     button.title = originalTitle;
                    //     showToast('Failed to update wishlist', 'error');
                    // })
                    .finally(() => {
                        button.disabled = false;
                    });
            @else
                showToast('Please login to add items to wishlist', 'warning');
                setTimeout(() => {
                    window.location.href = '{{ route('login') }}?redirect=' + encodeURIComponent(window.location
                        .href);
                }, 1500);
            @endif
        }

        // Add to cart function
        function addToCart(productId, quantity, button) {
            const input = document.querySelector(`.quantity-input[data-product-id="${productId}"]`);
            const qty = input ? parseInt(input.value) : quantity;

            const originalHTML = button ? button.innerHTML : null;
            if (button) {
                button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Adding...';
                button.disabled = true;
            }

            // Use your existing Cart.add function if available
            if (window.Cart && window.Cart.add) {
                window.Cart.add(productId, qty, button);
            } else {
                // Fallback to form submission
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/cart/add/${productId}`;
                form.style.display = 'none';

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = document.querySelector('meta[name="csrf-token"]').content;
                form.appendChild(csrf);

                const quantityInput = document.createElement('input');
                quantityInput.type = 'hidden';
                quantityInput.name = 'quantity';
                quantityInput.value = qty;
                form.appendChild(quantityInput);

                document.body.appendChild(form);
                form.submit();
            }
        }

        // Quick view function
        function quickView(productId) {
            // You can implement modal or redirect
            showToast('Quick view feature coming soon!', 'info');
        }

        // Notify when available
        function notifyMe(productId) {
            showToast('We\'ll notify you when this product is back in stock!', 'info');
        }

        // Email validation
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        // Toast notification function
        function showToast(message, type = 'info') {
            const toastContainer = document.getElementById('toastContainer') || createToastContainer();

            const toast = document.createElement('div');
            toast.className =
                `toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : type === 'warning' ? 'warning' : 'info'} border-0`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');

            const icon = type === 'success' ? 'check-circle' :
                type === 'error' ? 'exclamation-circle' :
                type === 'warning' ? 'exclamation-triangle' : 'info-circle';

            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-${icon} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;

            toastContainer.appendChild(toast);

            const bsToast = new bootstrap.Toast(toast, {
                autohide: true,
                delay: 3000
            });

            bsToast.show();

            toast.addEventListener('hidden.bs.toast', () => {
                toast.remove();
            });
        }

        function createToastContainer() {
            const container = document.createElement('div');
            container.id = 'toastContainer';
            container.className = 'toast-container position-fixed';
            container.style.cssText =
                'z-index: 99999; bottom: 20px; right: 20px; left: 20px; max-width: 400px; margin-left: auto; margin-right: auto;';
            document.body.appendChild(container);
            return container;
        }

        // Lazy loading for images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src || img.src;
                        img.classList.add('loaded');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => imageObserver.observe(img));
        }

        // Mobile menu improvements
        const navbarToggler = document.querySelector('.navbar-toggler');
        if (navbarToggler) {
            navbarToggler.addEventListener('click', function() {
                this.classList.toggle('collapsed');
            });
        }
    </script>
@endpush
