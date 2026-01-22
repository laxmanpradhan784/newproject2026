@extends('layouts.app')

@section('title', 'Home - E-Shop')

@section('content')
    <!-- Hero Slider -->
    <section class="hero-slider mt-5 pt-4">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            </div>
            
            <div class="carousel-inner rounded-3">
                <div class="carousel-item active">
                    <div class="carousel-content">
                        <h1 class="display-4 fw-bold mb-3">Summer Sale is Live!</h1>
                        <p class="lead mb-4">Get up to 50% off on all fashion items. Limited time offer.</p>
                        <a href="#" class="btn btn-primary btn-lg px-5 py-3">Shop Now</a>
                    </div>
                </div>
                
                <div class="carousel-item">
                    <div class="carousel-content">
                        <h1 class="display-4 fw-bold mb-3">New Tech Collection</h1>
                        <p class="lead mb-4">Latest smartphones, laptops, and gadgets at amazing prices.</p>
                        <a href="#" class="btn btn-primary btn-lg px-5 py-3">Explore Tech</a>
                    </div>
                </div>
                
                <div class="carousel-item">
                    <div class="carousel-content">
                        <h1 class="display-4 fw-bold mb-3">Free Shipping Worldwide</h1>
                        <p class="lead mb-4">On all orders above $50. Shop without worries.</p>
                        <a href="#" class="btn btn-primary btn-lg px-5 py-3">Start Shopping</a>
                    </div>
                </div>
            </div>
            
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-products py-5">
        <div class="container">
            <div class="section-title">
                <h2>Featured Products</h2>
                <p class="text-muted">Handpicked selection of our best products</p>
            </div>
            
            <div class="row">
                @for($i = 1; $i <= 6; $i++)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card">
                        <div class="product-image position-relative">
                            <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                                 class="img-fluid" alt="Product {{ $i }}">
                            <div class="product-actions position-absolute top-0 end-0 p-3">
                                <button class="btn btn-light btn-sm rounded-circle mb-2">
                                    <i class="fas fa-heart"></i>
                                </button>
                                <button class="btn btn-light btn-sm rounded-circle">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="product-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="mb-0">Wireless Headphones {{ $i }}</h5>
                                <span class="badge bg-success">New</span>
                            </div>
                            <p class="text-muted small mb-3">Premium quality wireless headphones with noise cancellation</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="h5 text-primary">${{ rand(50, 200) }}.99</span>
                                    @if(rand(0, 1))
                                    <span class="text-muted text-decoration-line-through ms-2">${{ rand(250, 400) }}.99</span>
                                    @endif
                                </div>
                                <button class="btn btn-primary btn-sm">
                                    <i class="fas fa-cart-plus me-1"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
            
            <div class="text-center mt-4">
                <a href="#" class="btn btn-outline-primary px-5">View All Products</a>
            </div>
        </div>
    </section>

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
            <div class="section-title">
                <h2>Popular Categories</h2>
                <p class="text-muted">Browse through our top categories</p>
            </div>
            
            <div class="row">
                @foreach(['Electronics', 'Fashion', 'Home & Kitchen', 'Books', 'Sports', 'Beauty'] as $category)
                <div class="col-md-4 col-lg-2 mb-4">
                    <div class="category-card text-center">
                        <div class="category-icon bg-light rounded-circle p-4 mb-3 mx-auto" style="width: 100px; height: 100px;">
                            <i class="fas fa-{{ 
                                $category == 'Electronics' ? 'tv' : 
                                ($category == 'Fashion' ? 'tshirt' : 
                                ($category == 'Home & Kitchen' ? 'home' : 
                                ($category == 'Books' ? 'book' : 
                                ($category == 'Sports' ? 'futbol' : 'spa')))) 
                            }} fa-2x text-primary"></i>
                        </div>
                        <h5>{{ $category }}</h5>
                        <p class="text-muted small mb-0">{{ rand(100, 500) }} Products</p>
                    </div>
                </div>
                @endforeach
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
        background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');
    }
    
    .hero-slider .carousel-item:nth-child(2) {
        background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');
    }
    
    .hero-slider .carousel-item:nth-child(3) {
        background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');
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