@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Slider -->
    <section class="hero-section position-relative overflow-hidden mt-5 pt-4">
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
            <!-- Indicators -->
            <div class="carousel-indicators position-absolute bottom-0 mb-5">
                @foreach ($sliders as $key => $slider)
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $key }}"
                        class="{{ $key == 0 ? 'active' : '' }} rounded-circle"
                        style="width: 12px; height: 12px; border: 2px solid white; background-color: transparent;">
                    </button>
                @endforeach
            </div>

            <!-- Slides -->
            <div class="carousel-inner rounded-3">
                @foreach ($sliders as $key => $slider)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <a href="{{ route('products') }}" class="text-decoration-none">
                            <div class="hero-slide position-relative"
                                style="background-image:url('{{ asset('uploads/sliders/' . $slider->image) }}');
                                    background-size:cover;
                                    background-position:center;
                                    height:850px;">
                                <div class="container h-100 d-flex align-items-center">
                                    <div class="carousel-content text-white p-4 rounded">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>


    <!-- Featured Products -->
    <section class="featured-products py-5 bg-light">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Featured Products</h2>
                <p class="text-muted fs-5">Premium selection of our best-selling items</p>
            </div>

            <div class="row g-4">
                @forelse($products as $product)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card product-card border-0 shadow-sm h-100 overflow-hidden">
                            <!-- Product Image with Badges -->
                            <div class="product-img-wrapper position-relative">
                                <a href="{{ route('product.show', $product->id) }}" class="d-block">
                                    <div class="product-image position-relative" style="height: 280px; overflow: hidden;">
                                        @if ($product->image)
                                            <img src="{{ asset('uploads/products/' . $product->image) }}"
                                                class="img-fluid w-100 h-100 object-fit-cover transition-transform"
                                                alt="{{ $product->name }}">
                                        @else
                                            <img src="https://via.placeholder.com/400x280?text=No+Image"
                                                class="img-fluid w-100 h-100 object-fit-cover transition-transform"
                                                alt="{{ $product->name }}">
                                        @endif
                                    </div>
                                </a>

                                <!-- Top Badges -->
                                <div class="position-absolute top-0 start-0 p-3">
                                    @if ($product->stock <= 0)
                                        <span class="badge bg-danger px-3 py-2 rounded-pill fw-normal">Sold Out</span>
                                    @elseif ($product->is_new ?? true)
                                        <span class="badge bg-success px-3 py-2 rounded-pill fw-normal">New</span>
                                    @endif
                                </div>

                                <!-- Quick Actions -->
                                <div class="product-actions position-absolute top-0 end-0 p-3 d-flex flex-column gap-2">
                                    <button class="btn btn-light btn-icon rounded-circle shadow-sm" title="Add to Wishlist">
                                        <i class="fas fa-heart text-danger"></i>
                                    </button>
                                    <button class="btn btn-light btn-icon rounded-circle shadow-sm" title="Quick View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>

                                <!-- Hover Add to Cart -->
                                <div
                                    class="product-hover-actions position-absolute bottom-0 start-0 w-100 p-3 bg-white bg-opacity-95 translate-y-100 transition-all">
                                    @if ($product->stock > 0)
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-primary w-100 py-3 fw-semibold rounded-pill">
                                                <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="card-body p-4">
                                <!-- Category -->
                                @if ($product->category)
                                    <div class="mb-2">
                                        <a href="{{ route('category.products', $product->category->slug) }}"
                                            class="text-decoration-none text-muted small">
                                            <i class="fas fa-tag me-1"></i>{{ $product->category->name }}
                                        </a>
                                    </div>
                                @endif

                                <!-- Product Title -->
                                <h5 class="card-title mb-2">
                                    <a href="{{ route('product.show', $product->id) }}"
                                        class="text-decoration-none text-dark fw-semibold hover-primary">
                                        {{ $product->name }}
                                    </a>
                                </h5>

                                <!-- Rating -->
                                {{-- <div class="product-rating mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="star-rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= 4 ? 'text-warning' : 'text-light' }}"></i>
                                            @endfor
                                        </div>
                                        <small class="text-muted ms-2">({{ rand(20, 500) }} reviews)</small>
                                    </div>
                                </div> --}}

                                <!-- Short Description -->
                                <p class="card-text text-muted small mb-3">
                                    {{ $product->short_description ?? Str::limit($product->description, 60, '...') }}
                                </p>

                                <!-- Price -->
                                <div class="product-price d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <span
                                            class="h4 fw-bold text-primary">₹{{ number_format($product->price, 2) }}</span>
                                        @if ($product->old_price)
                                            <span
                                                class="text-muted text-decoration-line-through ms-2">₹{{ number_format($product->old_price, 2) }}</span>
                                        @endif
                                    </div>
                                    @if ($product->stock <= 0)
                                        <span
                                            class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2 rounded-pill">Out
                                            of Stock</span>
                                    @endif
                                </div>

                                <!-- Stock Progress -->
                                @if ($product->stock > 0 && $product->stock < 20)
                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small class="text-muted">Hurry! Only {{ $product->stock }} left</small>
                                            <small class="text-muted">{{ round(($product->stock / 50) * 100) }}%</small>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-warning"
                                                style="width: {{ ($product->stock / 50) * 100 }}%"></div>
                                        </div>
                                    </div>
                                @endif

                                <!-- In Cart Controls (if item already in cart) -->
                                @if ($product->stock > 0 && $product->inCart())
                                    <div class="cart-controls mt-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="btn-group shadow-sm">
                                                <form action="{{ route('cart.decrease', $product->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-secondary px-3 py-2">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </form>

                                                <span
                                                    class="px-3 py-2 bg-light fw-bold min-w-40">{{ $product->cartQuantity() }}</span>

                                                <form action="{{ route('cart.increase', $product->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-secondary px-3 py-2"
                                                        {{ $product->cartQuantity() >= $product->stock ? 'disabled' : '' }}>
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </form>
                                            </div>

                                            <a href="{{ route('cart') }}" class="btn btn-success px-4 py-2">
                                                <i class="fas fa-check me-1"></i> In Cart
                                            </a>
                                        </div>
                                    </div>
                                @elseif ($product->stock > 0)
                                    <!-- Quantity Selector -->
                                    <div class="mt-3">
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <div class="input-group shadow-sm">
                                                <button type="button"
                                                    class="btn btn-outline-secondary quantity-minus px-3"
                                                    data-id="{{ $product->id }}">
                                                    <i class="fas fa-minus"></i>
                                                </button>

                                                <input type="number" name="quantity"
                                                    class="form-control text-center quantity-input border-0 bg-light"
                                                    value="1" min="1" max="{{ $product->stock }}"
                                                    data-id="{{ $product->id }}">

                                                <button type="button"
                                                    class="btn btn-outline-secondary quantity-plus px-3"
                                                    data-id="{{ $product->id }}">
                                                    <i class="fas fa-plus"></i>
                                                </button>

                                                <button type="submit" class="btn btn-primary px-4">
                                                    <i class="fas fa-cart-plus me-2"></i>Add
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @else
                                    <!-- Out of Stock -->
                                    <button class="btn btn-outline-secondary w-100 mt-3 py-3" disabled>
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

    <!-- Custom CSS -->
    <style>
        .product-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 16px;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
        }

        .product-img-wrapper {
            overflow: hidden;
            border-radius: 16px 16px 0 0;
        }

        .transition-transform {
            transition: transform 0.5s ease;
        }

        .product-card:hover .transition-transform {
            transform: scale(1.05);
        }

        .product-hover-actions {
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-hover-actions {
            transform: translateY(0);
        }

        .btn-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .hover-primary:hover {
            color: #0d6efd !important;
        }

        .star-rating i {
            font-size: 0.875rem;
        }

        .min-w-40 {
            min-width: 40px;
        }

        .translate-y-100 {
            transform: translateY(100%);
        }

        /* Quantity Input Styling */
        .quantity-input {
            max-width: 60px;
            font-weight: 600;
        }

        .quantity-input:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }

        .btn-outline-secondary:hover {
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }

        /* Badge Styles */
        .badge {
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Progress Bar */
        .progress {
            border-radius: 3px;
            background-color: #f1f3f5;
        }

        .progress-bar {
            border-radius: 3px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .product-card {
                max-width: 400px;
                margin: 0 auto;
            }

            .product-image {
                height: 220px !important;
            }

            .input-group .btn {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
        }
    </style>

    <!-- Banner Section -->
    <section class="banner-section py-5">
        <div class="container">
            <div class="row align-items-center bg-primary rounded-3 p-5 text-white">
                <div class="col-md-8">
                    <h2 class="display-6 fw-bold">Limited Time Offer!</h2>
                    <p class="lead">Get 30% off on all electronics. Use code: TECH30</p>
                    <p class="small mb-0">Offer valid until December 31, 2024</p>
                </div>
                <div class="col-md-4 text-center text-md-end">
                    <a href="#" class="btn btn-light btn-lg px-5">Shop Electronics</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Categories -->
    <section class="categories py-5">
        <div class="container">
            <div class="section-title text-center mb-4">
                <h2>Popular Categories</h2>
                <p class="text-muted">Browse through our top categories</p>
            </div>

            <div class="row justify-content-center">
                @php
                    // Fetch only 6 active categories
                    $allCategories = \App\Models\Category::where('status', 'active')->take(6)->get();
                @endphp

                @forelse($allCategories as $category)
                    <div class="col-md-4 col-lg-2 mb-4">
                        <a href="{{ route('category.products', $category->slug) }}"
                            class="text-decoration-none text-dark">
                            <div class="category-card text-center border rounded p-3 h-100 shadow-sm">
                                <div class="category-icon bg-light rounded-circle p-4 mb-3 mx-auto"
                                    style="width: 100px; height: 100px;">
                                    @php
                                        // Choose icon based on category name
                                        $icon = match ($category->name) {
                                            'Electronics' => 'tv',
                                            'Fashion' => 'tshirt',
                                            'Home & Kitchen' => 'home',
                                            'Books' => 'book',
                                            'Sports' => 'futbol',
                                            'Beauty' => 'spa',
                                            default => 'layer-group',
                                        };
                                    @endphp
                                    <i class="fas fa-{{ $icon }} fa-2x text-primary"></i>
                                </div>
                                <h5 class="mb-1">{{ $category->name }}</h5>
                                <p class="text-muted small mb-0">{{ $category->products()->count() }} Products</p>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No categories found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>



@endsection

@push('styles')
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-dark: #3a56d4;
        }

        /* Hero Slider */
        .hero-slider .carousel-item {
            height: 500px;
            background-size: cover;
            background-position: center;
            border-radius: 15px;
        }

        .hero-slider .carousel-item:nth-child(1) {
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');
        }

        .hero-slider .carousel-item:nth-child(2) {
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');
        }

        .hero-slider .carousel-item:nth-child(3) {
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');
        }

        .carousel-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            width: 80%;
        }

        /* Section Title */
        .section-title {
            text-align: center;
            margin: 60px 0 40px;
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

        /* Product Card */
        .product-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            margin-bottom: 30px;
            background: white;
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

        /* Category Card */
        .category-card {
            transition: transform 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-5px);
        }

        .category-icon {
            transition: all 0.3s ease;
        }

        .category-card:hover .category-icon {
            background: var(--primary-color) !important;
        }

        .category-card:hover .category-icon i {
            color: white !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-slider .carousel-item {
                height: 300px;
            }

            .carousel-content h1 {
                font-size: 2rem;
            }

            .carousel-content .lead {
                font-size: 1rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Auto-play carousel
            $('#heroCarousel').carousel({
                interval: 5000
            });

            // Add to cart animation
            $('.btn-primary').on('click', function() {
                const cartCount = $('.badge.bg-danger');
                let count = parseInt(cartCount.text()) || 0;
                cartCount.text(count + 1);

                // Animation
                $(this).html('<i class="fas fa-check me-1"></i> Added');
                $(this).removeClass('btn-primary').addClass('btn-success');

                setTimeout(() => {
                    $(this).html('<i class="fas fa-cart-plus me-1"></i> Add to Cart');
                    $(this).removeClass('btn-success').addClass('btn-primary');
                }, 1500);
            });
        });
    </script>
@endpush
