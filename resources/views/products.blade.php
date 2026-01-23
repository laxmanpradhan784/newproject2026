@extends('layouts.app')

@section('title', isset($category) ? $category->name : 'Products')

@section('content')

<section class="py-5">
    <div class="container pt-5">
        <h3 class="mb-4">
            {{ isset($category) ? $category->name . ' Products' : 'All Products' }}
        </h3>

        <div class="row g-4">

            @forelse($products as $product)
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm">
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" 
                                 class="card-img-top" style="height:200px;object-fit:cover;">
                        @endif
                        <div class="card-body text-center">
                            <h6>{{ $product->name }}</h6>
                            <p class="fw-bold text-success">₹{{ $product->price }}</p>
                            <small class="text-muted">Stock: {{ $product->stock }}</small>
                        </div>
                    </div>
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
