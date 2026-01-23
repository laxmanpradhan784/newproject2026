@extends('layouts.app')

@section('title', 'Categories - E-Shop')

@section('content')

<!-- Hero Section -->
<section class="contact-hero py-5 bg-light">
    <div class="container pt-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="fw-bold">Shop by Categories</h1>
                <p class="text-muted">
                    Browse all product categories and find what you need.
                </p>
            </div>
            <div class="col-lg-6 text-end">
                <img src="{{ asset('images/categories-banner.png') }}" class="img-fluid" alt="Categories">
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">

            @forelse($categories as $cat)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 shadow-sm border-0">
                        @if($cat->image)
                            <img src="{{ asset('storage/'.$cat->image) }}" 
                                 class="card-img-top" style="height:200px;object-fit:cover;">
                        @endif
                        <div class="card-body text-center">
                            <a href="{{ route('category.products', $cat->slug) }}" class="text-decoration-none text-dark">
                                <h5 class="fw-bold">{{ $cat->name }}</h5>
                            </a>
                        </div>
                    </div>
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
