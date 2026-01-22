@extends('layouts.app')

@section('title', 'Categories - E-Shop')

@section('content')
<!-- Hero Section -->
<section class="categories-hero py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold mb-3">Shop by Category</h1>
                <p class="lead mb-4">Browse through our wide range of product categories. Find exactly what you're looking for.</p>
                <div class="stats d-flex gap-4">
                    <div class="stat-item">
                        <h3 class="text-primary fw-bold mb-0">{{ $categories->count() }}+</h3>
                        <p class="text-muted mb-0">Categories</p>
                    </div>
                    <div class="stat-item">
                        <h3 class="text-primary fw-bold mb-0">1000+</h3>
                        <p class="text-muted mb-0">Products</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://picsum.photos/600/400?random=1&blur=1" 
                     alt="Categories" class="img-fluid rounded-3 shadow">
            </div>
        </div>
    </div>
</section>

<!-- Categories Grid -->
<section class="categories-grid py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>All Categories</h2>
            <p class="text-muted">Explore our product collections</p>
        </div>

        @if($categories->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-boxes fa-4x text-muted mb-4"></i>
                <h4 class="text-muted">No categories available</h4>
                <p class="text-muted">Check back later for updated categories.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($categories as $category)
                    <div class="col-md-4 col-lg-3">
                        <div class="category-card text-center">
                            <a href="{{ route('products.by.category', $category->id) }}" class="text-decoration-none">
                                <div class="category-image mb-3">
                                    <div class="image-wrapper rounded-3 overflow-hidden position-relative" style="height: 200px;">
                                        @if($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}" 
                                                 alt="{{ $category->name }}"
                                                 class="img-fluid w-100 h-100 object-fit-cover">
                                        @else
                                            <div class="bg-primary bg-opacity-10 h-100 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-box fa-3x text-primary"></i>
                                            </div>
                                        @endif
                                        <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-25 d-flex align-items-center justify-content-center opacity-0 transition-150">
                                            <span class="text-white fw-bold">View Products</span>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="fw-bold mb-2 text-dark">{{ $category->name }}</h5>
                                @php
                                    $productCount = \App\Models\Product::where('category_id', $category->id)
                                                                       ->where('status', 'active')
                                                                       ->count();
                                @endphp
                                <p class="text-muted small mb-0">{{ $productCount }} products</p>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- Featured Categories -->
<section class="featured-categories py-5 bg-light">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Featured Categories</h2>
            <p class="text-muted">Most popular collections</p>
        </div>

        <div class="row">
            @foreach($categories->take(4) as $category)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="featured-category-card bg-white rounded-3 overflow-hidden shadow-sm">
                        <a href="{{ route('products.by.category', $category->id) }}" class="text-decoration-none">
                            <div class="category-header p-4">
                                <div class="icon-wrapper bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                     style="width: 60px; height: 60px;">
                                    <i class="fas fa-box text-primary fa-lg"></i>
                                </div>
                                <h5 class="fw-bold mb-2 text-dark">{{ $category->name }}</h5>
                                @php
                                    $productCount = \App\Models\Product::where('category_id', $category->id)
                                                                       ->where('status', 'active')
                                                                       ->count();
                                @endphp
                                <p class="text-muted small">{{ $productCount }} products</p>
                            </div>
                            <div class="category-footer bg-light p-3 text-center">
                                <span class="text-primary fw-bold">Shop Now <i class="fas fa-arrow-right ms-1"></i></span>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-categories py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-3">Can't find what you're looking for?</h2>
                <p class="mb-0">Contact our support team for assistance in finding specific products.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('contact') }}" class="btn btn-light btn-lg px-5">
                    <i class="fas fa-headset me-2"></i> Contact Support
                </a>
            </div>
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
    
    .categories-hero {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
    
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
    
    .category-card {
        transition: transform 0.3s ease;
    }
    
    .category-card:hover {
        transform: translateY(-10px);
    }
    
    .category-image .image-wrapper {
        transition: all 0.3s ease;
    }
    
    .category-card:hover .category-image .image-wrapper {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
    
    .category-overlay {
        transition: opacity 0.3s ease;
    }
    
    .category-card:hover .category-overlay {
        opacity: 1;
    }
    
    .featured-category-card {
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .featured-category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(67, 97, 238, 0.15) !important;
    }
    
    .featured-category-card:hover .category-footer {
        background: var(--primary-color);
    }
    
    .featured-category-card:hover .category-footer span {
        color: white;
    }
    
    .cta-categories {
        background: linear-gradient(to right, var(--primary-color), #7209b7);
    }
    
    .stats .stat-item {
        text-align: center;
        padding: 15px 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        min-width: 120px;
    }
    
    @media (max-width: 768px) {
        .categories-hero h1 {
            font-size: 2.5rem;
        }
        
        .stats {
            flex-direction: column;
            gap: 15px;
        }
        
        .stats .stat-item {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Category card hover effects
        $('.category-card').hover(
            function() {
                $(this).find('.category-overlay').css('opacity', '1');
            },
            function() {
                $(this).find('.category-overlay').css('opacity', '0');
            }
        );
        
        // Featured category animation
        $('.featured-category-card').hover(
            function() {
                $(this).css('transform', 'translateY(-5px)');
            },
            function() {
                $(this).css('transform', 'translateY(0)');
            }
        );
    });
</script>
@endpush