
@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <i class="fas fa-truck fa-4x text-primary mb-4"></i>
                <h1 class="mb-3">Checkout Coming Soon!</h1>
                <p class="lead mb-4">We're working on our checkout system. In the meantime, you can continue shopping.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('cart') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i> Back to Cart
                    </a>
                    <a href="{{ route('products') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-bag me-2"></i> Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection