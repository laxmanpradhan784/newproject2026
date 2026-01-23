@extends('layouts.app')

@section('title', isset($category) ? $category->name : 'Products')

@section('content')

<section class="py-5">
    <div class="container pt-5">

                <h3 class="mb-4">
                    @if(isset($search))
                        Search results for "{{ $search }}"
                    @elseif(isset($category))
                        {{ $category->name }} Products
                    @else
                        All Products
                    @endif
                </h3>


        <!-- Category Filter -->
        <div class="mb-4">
            <h4 class="mb-3">Categories</h4>
            <div class="d-flex flex-wrap gap-2">
                @php
                    $allCategories = \App\Models\Category::where('status', 'active')->get();
                @endphp

                <a href="{{ route('products') }}" 
                   class="btn btn-sm {{ !isset($category) ? 'btn-primary' : 'btn-outline-primary' }}">
                    All
                </a>

                @foreach($allCategories as $cat)
                    <a href="{{ route('category.products', $cat->slug) }}" 
                       class="btn btn-sm {{ (isset($category) && $category->id === $cat->id) ? 'btn-primary' : 'btn-outline-primary' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Products Section -->
        <h3 class="mb-4">
            {{ isset($category) ? $category->name . ' Products' : 'All Products' }}
        </h3>

       <div class="row g-4">

            @forelse($products as $product)
                <div class="col-md-3">
                    <a href="{{ route('product.show', $product->id) }}" class="text-decoration-none text-dark">
                        <div class="card h-100 shadow-sm border-0">

                            <!-- Product Image -->
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" 
                                    class="card-img-top" style="height:200px;object-fit:cover;">
                            @endif

                            <div class="product-body p-4">
                                <!-- Title and badge -->
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="mb-0">{{ $product->name }}</h5>
                                    @if($product->is_new ?? true)
                                        <span class="badge bg-success">New</span>
                                    @endif
                                </div>

                                <!-- Category Name -->
                                @if($product->category)
                                    <p class="text-muted small mb-2">
                                        Category: 
                                        <a href="{{ route('category.products', $product->category->slug) }}" class="text-decoration-none">
                                            {{ $product->category->name }}
                                        </a>
                                    </p>
                                @endif

                                <!-- Short Description -->
                                <p class="text-muted small mb-3">
                                    {{ $product->short_description ?? 'Premium quality product.' }}
                                </p>

                                <!-- Price and Add to Cart -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="h5 text-primary">₹{{ $product->price }}</span>
                                        @if($product->old_price)
                                            <span class="text-muted text-decoration-line-through ms-2">₹{{ $product->old_price }}</span>
                                        @endif
                                    </div>
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fas fa-cart-plus me-1"></i> Add to Cart
                                    </button>
                                </div>
                            </div>

                        </div>
                    </a>
                </div>

            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No products found{{ isset($category) ? ' in this category' : '' }}.</p>
                </div>
            @endforelse

        </div>


    </div>
</section>

@endsection
