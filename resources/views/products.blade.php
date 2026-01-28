@extends('layouts.app')

@section('title', isset($category) ? $category->name : 'Products')

@section('content')

    <section class="py-5">
        <div class="container pt-5">

            <h3 class="mb-4">
                @if (isset($search))
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

                    @foreach ($allCategories as $cat)
                        <a href="{{ route('category.products', $cat->slug) }}"
                            class="btn btn-sm {{ isset($category) && $category->id === $cat->id ? 'btn-primary' : 'btn-outline-primary' }}">
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
                        <div class="card h-100 shadow-sm border-0">
                            <!-- Product Image -->
                            <a href="{{ route('product.show', $product->id) }}" class="text-decoration-none text-dark">
                                @if ($product->image)
                                    <img src="{{ asset('uploads/products/' . $product->image) }}" class="card-img-top"
                                        style="height:200px;object-fit:cover;" alt="{{ $product->name }}">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                        style="height:200px;">
                                        <i class="fas fa-box fa-3x text-muted"></i>
                                    </div>
                                @endif
                            </a>

                            <div class="product-body p-4">
                                <!-- Title and badge -->
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="mb-0">
                                        <a href="{{ route('product.show', $product->id) }}"
                                            class="text-decoration-none text-dark">
                                            {{ $product->name }}
                                        </a>
                                    </h5>
                                    @if ($product->is_new ?? true)
                                        <span class="badge bg-success">New</span>
                                    @endif
                                </div>

                                <!-- Category Name -->
                                @if ($product->category)
                                    <p class="text-muted small mb-2">
                                        Category:
                                        <a href="{{ route('category.products', $product->category->slug) }}"
                                            class="text-decoration-none">
                                            {{ $product->category->name }}
                                        </a>
                                    </p>
                                @endif

                                <!-- Short Description -->
                                <p class="text-muted small mb-3">
                                    {{ $product->short_description ?? 'Premium quality product.' }}
                                </p>

                                <!-- Price and Add to Cart -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <span class="h5 text-primary">₹{{ number_format($product->price, 2) }}</span>
                                        @if ($product->old_price)
                                            <span
                                                class="text-muted text-decoration-line-through ms-2">₹{{ number_format($product->old_price, 2) }}</span>
                                        @endif
                                    </div>

                                    @if ($product->stock <= 0)
                                        <span class="badge bg-danger">Out of Stock</span>
                                    @endif
                                </div>

                                <!-- Quantity Selector and Add to Cart Button -->
                                @if ($product->stock > 0)
                                    @if ($product->inCart())
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="btn-group" role="group">
                                                <form action="{{ route('cart.decrease', $product->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </form>

                                                <span class="px-3 fw-bold">{{ $product->cartQuantity() }}</span>

                                                <form action="{{ route('cart.increase', $product->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-secondary btn-sm"
                                                        {{ $product->cartQuantity() >= $product->stock ? 'disabled' : '' }}>
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </form>
                                            </div>

                                            <a href="{{ route('cart') }}" class="btn btn-success btn-sm">
                                                <i class="fas fa-check me-1"></i> In Cart
                                            </a>
                                        </div>
                                    @else
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                            class="d-inline w-100">
                                            @csrf
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-outline-secondary quantity-minus"
                                                        data-id="{{ $product->id }}">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="number" name="quantity"
                                                    class="form-control text-center quantity-input" value="1"
                                                    min="1" max="{{ $product->stock }}"
                                                    data-id="{{ $product->id }}" style="max-width: 60px;">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-secondary quantity-plus"
                                                        data-id="{{ $product->id }}">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-primary"
                                                        style="margin-left: 60px;>
                                                    <i class="fas
                                                        fa-cart-plus me-1"></i> Add
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    @endif

                                    <!-- Stock Information -->
                                    <small class="text-muted d-block mt-2">
                                        <i class="fas fa-box me-1"></i>
                                        {{ $product->stock }} in stock
                                    </small>
                                @else
                                    <button class="btn btn-secondary btn-block" disabled>
                                        <i class="fas fa-times-circle me-1"></i> Out of Stock
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No products found{{ isset($category) ? ' in this category' : '' }}.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($products->hasPages())
                <div class="mt-5">
                    {{ $products->links() }}
                </div>
            @endif

        </div>
    </section>

    <!-- JavaScript for Quantity Controls -->
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Quantity plus button
                document.querySelectorAll('.quantity-plus').forEach(button => {
                    button.addEventListener('click', function() {
                        const productId = this.getAttribute('data-id');
                        const input = document.querySelector(`.quantity-input[data-id="${productId}"]`);
                        const max = parseInt(input.getAttribute('max'));
                        let value = parseInt(input.value) || 1;

                        if (value < max) {
                            input.value = value + 1;
                        }
                    });
                });

                // Quantity minus button
                document.querySelectorAll('.quantity-minus').forEach(button => {
                    button.addEventListener('click', function() {
                        const productId = this.getAttribute('data-id');
                        const input = document.querySelector(`.quantity-input[data-id="${productId}"]`);
                        const min = parseInt(input.getAttribute('min'));
                        let value = parseInt(input.value) || 1;

                        if (value > min) {
                            input.value = value - 1;
                        }
                    });
                });

                // Input validation
                document.querySelectorAll('.quantity-input').forEach(input => {
                    input.addEventListener('change', function() {
                        const min = parseInt(this.getAttribute('min'));
                        const max = parseInt(this.getAttribute('max'));
                        let value = parseInt(this.value) || min;

                        if (value < min) this.value = min;
                        if (value > max) this.value = max;
                    });
                });
            });
        </script>
    @endpush
@endsection
