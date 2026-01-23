@extends('layouts.app')

@section('title', $product->name)

@section('content')

<section class="py-5">
    <div class="container pt-5">
        <div class="row g-4">

            <!-- Product Image & Info -->
            <div class="col-lg-8">
                <div class="row g-4">
                    <!-- Product Image -->
                    <div class="col-md-12">
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" 
                                 class="img-fluid rounded shadow-sm" alt="{{ $product->name }}">
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="col-md-12 mt-3">
                        <h2 class="fw-bold">{{ $product->name }}</h2>
                        @if($product->is_new ?? true)
                            <span class="badge bg-success mb-2">New</span>
                        @endif

                        <p class="text-muted mb-2">Category: 
                            <a href="{{ route('category.products', $product->category->slug) }}">
                                {{ $product->category->name }}
                            </a>
                        </p>

                        <h4 class="text-primary">₹{{ $product->price }}
                            @if($product->old_price)
                                <span class="text-muted text-decoration-line-through ms-2">₹{{ $product->old_price }}</span>
                            @endif
                        </h4>

                        <p class="mb-3"><small class="text-muted">Stock: {{ $product->stock }}</small></p>

                        <p>{{ $product->description ?? 'No detailed description available.' }}</p>

                        <button class="btn btn-primary">
                            <i class="fas fa-cart-plus me-1"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar: Other Products in Same Category -->
            <div class="col-lg-4">
                <h5 class="mb-3">Other Products in {{ $product->category->name }}</h5>
                <div class="list-group">
                    @php
                        $relatedProducts = \App\Models\Product::where('category_id', $product->category_id)
                                                            ->where('id', '!=', $product->id)
                                                            ->where('status','active')
                                                            ->limit(5)
                                                            ->get();
                    @endphp

                    @forelse($relatedProducts as $related)
                        <a href="{{ route('product.show', $related->id) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            @if($related->image)
                                <img src="{{ asset('storage/'.$related->image) }}" 
                                     alt="{{ $related->name }}" style="width:50px;height:50px;object-fit:cover;" class="me-3 rounded">
                            @endif
                            <div>
                                <div class="fw-bold">{{ $related->name }}</div>
                                <small class="text-success">₹{{ $related->price }}</small>
                            </div>
                        </a>
                    @empty
                        <p class="text-muted">No other products in this category.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
