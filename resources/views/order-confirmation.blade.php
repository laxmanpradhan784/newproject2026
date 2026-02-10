@extends('layouts.app')

@section('title', 'Order Confirmed!')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Success Header -->
            <div class="text-center mb-5">
                <!-- Success Icon -->
                <div class="mb-4">
                    <div class="position-relative d-inline-block">
                        <div class="checkmark-circle">
                            <div class="checkmark"></div>
                        </div>
                        <div class="success-ring"></div>
                    </div>
                </div>
                
                <!-- Order Confirmation Message -->
                <h1 class="fw-bold mb-3 text-success">Order Confirmed!</h1>
                <p class="text-muted fs-5 mb-0">Thank you for your purchase. Your order has been successfully placed.</p>
                
                <!-- Order Number -->
                <div class="mt-3">
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 fs-6">
                        <i class="fas fa-receipt me-2"></i>
                        Order #{{ $order->order_number }}
                    </span>
                </div>
            </div>

            <!-- Order Summary Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-file-invoice text-primary me-2"></i>Order Summary
                        </h5>
                        <small class="text-muted">{{ $order->created_at->format('d M Y, h:i A') }}</small>
                    </div>
                </div>
                <div class="card-body p-4">
                    
                    <!-- Order Items Preview -->
                    @if($order->items && $order->items->count() > 0)
                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3 text-secondary">Items Ordered</h6>
                        <div class="row">
                            @foreach($order->items->take(2) as $item)
                            <div class="col-6 mb-3">
                                <div class="d-flex align-items-center">
                                    @if($item->product->image)
                                        <img src="{{ asset('uploads/products/' . $item->product->image) }}" 
                                             alt="{{ $item->product->name }}"
                                             class="rounded-2 me-3" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="rounded-2 me-3 d-flex align-items-center justify-content-center bg-light"
                                             style="width: 60px; height: 60px;">
                                            <i class="fas fa-box text-muted"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="fw-medium mb-1" style="font-size: 0.9rem;">{{ $item->product->name }}</h6>
                                        <div class="d-flex align-items-center">
                                            <small class="text-muted me-3">Qty: {{ $item->quantity }}</small>
                                            <small class="fw-bold">₹{{ number_format($item->price, 2) }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @if($order->items->count() > 2)
                            <div class="col-12">
                                <div class="text-center mt-2">
                                    <small class="text-muted">
                                        +{{ $order->items->count() - 2 }} more item{{ $order->items->count() - 2 > 1 ? 's' : '' }}
                                    </small>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Price Breakdown -->
                    <div class="bg-light rounded-3 p-3 mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-medium">₹{{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        
                        @if($order->discount_amount > 0)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">
                                <i class="fas fa-tag text-success me-1"></i> Coupon Discount
                                @if($order->coupon_code)
                                <small class="ms-1">({{ $order->coupon_code }})</small>
                                @endif
                            </span>
                            <span class="fw-bold text-success">-₹{{ number_format($order->discount_amount, 2) }}</span>
                        </div>
                        @endif
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Shipping</span>
                            <span class="fw-medium {{ $order->shipping == 0 ? 'text-success' : '' }}">
                                @if($order->shipping == 0)
                                    FREE
                                @else
                                    ₹{{ number_format($order->shipping, 2) }}
                                @endif
                            </span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Tax</span>
                            <span class="fw-medium">₹{{ number_format($order->tax, 2) }}</span>
                        </div>
                        
                        <hr class="my-3">
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold fs-5">Total Amount</span>
                            <span class="fw-bold display-6 text-success">₹{{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center mb-5">
                <p class="text-muted mb-3">What would you like to do next?</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('orders') }}" class="btn btn-primary px-4">
                        <i class="fas fa-list me-2"></i> View All Orders
                    </a>
                    <a href="{{ route('products') }}" class="btn btn-outline-primary px-4">
                        <i class="fas fa-shopping-bag me-2"></i> Continue Shopping
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-light px-4">
                        <i class="fas fa-home me-2"></i> Back to Home
                    </a>
                </div>
            </div>

            <!-- Auto-Redirect Notice -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="me-3">
                            <i class="fas fa-clock text-info fs-4"></i>
                        </div>
                        <div class="text-start">
                            <h6 class="fw-bold mb-1">Auto-Redirect Notice</h6>
                            <p class="text-muted mb-0">
                                This page will automatically redirect to your orders page in 
                                <span id="countdown-timer" class="fw-bold text-primary">10</span> seconds.
                                <br>
                                <small>This is a one-time confirmation page for your order.</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Success Animation */
    .checkmark-circle {
        width: 100px;
        height: 100px;
        position: relative;
        background: linear-gradient(135deg, #28a745, #20c997);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .checkmark {
        width: 40px;
        height: 20px;
        border-left: 5px solid white;
        border-bottom: 5px solid white;
        transform: rotate(-45deg);
        margin-top: -10px;
    }

    .success-ring {
        position: absolute;
        top: -5px;
        left: -5px;
        right: -5px;
        bottom: -5px;
        border: 2px solid rgba(40, 167, 69, 0.3);
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        100% { transform: scale(1.1); opacity: 0; }
    }

    /* Card Styles */
    .card {
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,0.05);
    }

    /* Button Styles */
    .btn-primary {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        border: none;
        border-radius: 8px;
        padding: 10px 24px;
        font-weight: 500;
    }

    .btn-outline-primary {
        border-radius: 8px;
        padding: 10px 24px;
        font-weight: 500;
    }

    .btn-light {
        border-radius: 8px;
        padding: 10px 24px;
        font-weight: 500;
    }

    /* Badge */
    .badge {
        border-radius: 20px;
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .checkmark-circle {
            width: 80px;
            height: 80px;
        }
        
        .checkmark {
            width: 30px;
            height: 15px;
            border-width: 3px;
        }
        
        h1 {
            font-size: 2rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let seconds = 10;
        const countdownElement = document.getElementById('countdown-timer');
        
        // Update countdown every second
        const countdownInterval = setInterval(() => {
            seconds--;
            countdownElement.textContent = seconds;
            
            if (seconds <= 0) {
                clearInterval(countdownInterval);
                redirectToOrders();
            }
        }, 1000);
        
        // Auto-redirect after 10 seconds (fallback)
        setTimeout(() => {
            redirectToOrders();
        }, 10000);
        
        // Function to redirect to orders page
        function redirectToOrders() {
            window.location.href = "{{ route('orders') }}";
        }
        
        // Optional: Clear session when leaving page (prevents going back)
        window.addEventListener('beforeunload', function() {
            // You can make an AJAX call here to clear the session if needed
            // fetch("{{ route('order.confirmation.clear') }}", {
            //     method: 'POST',
            //     headers: {
            //         'X-CSRF-TOKEN': '{{ csrf_token() }}',
            //         'Content-Type': 'application/json',
            //     },
            // });
        });
    });
</script>
@endpush