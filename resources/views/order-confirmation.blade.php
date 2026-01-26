@extends('layouts.app')

@section('title', 'Order Confirmation')

@section('content')
<section class="order-confirmation py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-5 text-center">
                        <!-- Success Icon -->
                        <div class="mb-4">
                            <div class="success-icon bg-success text-white rounded-circle mx-auto d-flex align-items-center justify-content-center" 
                                 style="width: 100px; height: 100px;">
                                <i class="fas fa-check fa-3x"></i>
                            </div>
                        </div>
                        
                        <!-- Order Confirmation -->
                        <h1 class="fw-bold text-success mb-3">Order Confirmed!</h1>
                        <p class="lead mb-4">Thank you for your purchase. Your order has been placed successfully.</p>
                        
                        <!-- Order Details -->
                        <div class="order-details bg-light rounded-3 p-4 mb-4">
                            <h4 class="mb-3">Order Details</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Order Number:</strong></p>
                                    <h5 class="text-primary">{{ $order->order_number }}</h5>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Order Date:</strong></p>
                                    <h5>{{ $order->created_at->format('d M Y, h:i A') }}</h5>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Payment Method:</strong></p>
                                    <h5 class="text-capitalize">{{ $order->payment_method }}</h5>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Total Amount:</strong></p>
                                    <h3 class="text-success fw-bold">₹{{ number_format($order->total, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Next Steps -->
                        <div class="next-steps mb-5">
                            <h4 class="mb-3">What's Next?</h4>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="step-card p-3 border rounded-3 text-center h-100">
                                        <i class="fas fa-envelope fa-2x text-primary mb-3"></i>
                                        <h6 class="fw-bold">Email Confirmation</h6>
                                        <p class="small mb-0">Check your email for order details</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="step-card p-3 border rounded-3 text-center h-100">
                                        <i class="fas fa-truck fa-2x text-info mb-3"></i>
                                        <h6 class="fw-bold">Order Processing</h6>
                                        <p class="small mb-0">Your order is being processed</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="step-card p-3 border rounded-3 text-center h-100">
                                        <i class="fas fa-home fa-2x text-success mb-3"></i>
                                        <h6 class="fw-bold">Delivery</h6>
                                        <p class="small mb-0">Items will be shipped soon</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <a href="{{ route('order.details', $order->order_number) }}" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-eye me-2"></i> View Order Details
                            </a>
                            <a href="{{ route('orders') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-list me-2"></i> My Orders
                            </a>
                            <a href="{{ route('products') }}" class="btn btn-success btn-lg">
                                <i class="fas fa-shopping-bag me-2"></i> Continue Shopping
                            </a>
                        </div>
                        
                        <!-- Shipping Info -->
                        <div class="mt-5 pt-4 border-top">
                            <h5 class="mb-3">Shipping Information</h5>
                            <div class="text-start bg-white p-3 rounded-3">
                                <p class="mb-1"><strong>{{ $order->shipping_name }}</strong></p>
                                <p class="mb-1">{{ $order->shipping_address }}</p>
                                <p class="mb-1">{{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_zip }}</p>
                                <p class="mb-1">{{ $order->shipping_country }}</p>
                                <p class="mb-0"><i class="fas fa-phone me-2"></i>{{ $order->shipping_phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.order-confirmation {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: calc(100vh - 200px);
}
.success-icon {
    animation: bounceIn 1s ease;
}
@keyframes bounceIn {
    0% { transform: scale(0.3); opacity: 0; }
    50% { transform: scale(1.05); }
    70% { transform: scale(0.9); }
    100% { transform: scale(1); opacity: 1; }
}
.step-card {
    transition: transform 0.3s ease;
}
.step-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
</style>
@endpush