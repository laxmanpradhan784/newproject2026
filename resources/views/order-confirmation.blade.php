@extends('layouts.app')

@section('title', 'Order Confirmation')

@section('content')
    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow">
                    <div class="card-body p-5 text-center">
                        <!-- Success Icon -->
                        <div class="mb-4">
                            <div class="bg-success text-white rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px">
                                <i class="fas fa-check fa-2x"></i>
                            </div>
                        </div>

                        <!-- Order Confirmation -->
                        <h2 class="fw-bold text-success mb-3">Order Confirmed!</h2>
                        <p class="text-muted mb-4">Thank you for your purchase. Your order has been placed successfully.</p>

                        <!-- Order Details -->
                        <div class="p-0 mb-4">
                            <h5 class="text-center mb-4 text-secondary">Order Summary</h5>

                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr class="border-bottom">
                                            <td class="text-muted py-3">Order Number</td>
                                            <td class="text-end fw-bold py-3">
                                                {{ $order->order_number }}
                                            </td>
                                        </tr>
                                        <tr class="border-bottom">
                                            <td class="text-muted py-3">Order Date</td>
                                            <td class="text-end fw-bold py-3">
                                                {{ $order->created_at->format('d M Y, h:i A') }}
                                            </td>
                                        </tr>
                                        <tr class="border-bottom">
                                            <td class="text-muted py-3">Payment Method</td>
                                            <td class="text-end fw-bold text-capitalize py-3">
                                                {{ $order->payment_method }}
                                            </td>
                                        </tr>

                                        <!-- Coupon Applied -->
                                        @if ($order->coupon_code)
                                            <tr class="border-bottom bg-light">
                                                <td class="text-muted py-3">
                                                    <i class="fas fa-tag text-success me-2"></i> Coupon Applied
                                                </td>
                                                <td class="text-end fw-bold py-3">
                                                    <div class="d-flex flex-column align-items-end">
                                                        <span class="text-success">{{ $order->coupon_code }}</span>
                                                        <small
                                                            class="text-muted">-₹{{ number_format($order->discount_amount, 2) }}</small>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif

                                        <!-- Price Breakdown -->
                                        <tr class="border-bottom">
                                            <td class="text-muted py-3">Subtotal</td>
                                            <td class="text-end fw-bold py-3">₹{{ number_format($order->subtotal, 2) }}</td>
                                        </tr>
                                        @if ($order->discount_amount > 0)
                                            <tr class="border-bottom">
                                                <td class="text-muted py-3 text-success">Discount Applied</td>
                                                <td class="text-end fw-bold text-success py-3">
                                                    -₹{{ number_format($order->discount_amount, 2) }}</td>
                                            </tr>
                                        @endif
                                        <tr class="border-bottom">
                                            <td class="text-muted py-3">Shipping</td>
                                            <td class="text-end fw-bold py-3">
                                                @if ($order->shipping == 0)
                                                    <span class="text-success">FREE</span>
                                                @else
                                                    ₹{{ number_format($order->shipping, 2) }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr class="border-bottom">
                                            <td class="text-muted py-3">Tax (18%)</td>
                                            <td class="text-end fw-bold py-3">₹{{ number_format($order->tax, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted py-3 fs-5">Total Amount</td>
                                            <td class="text-end fw-bold text-success fs-4 py-3">
                                                ₹{{ number_format($order->total, 2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Savings Message -->
                            @if ($order->discount_amount > 0)
                                <div class="alert alert-success border-0 rounded-3 mt-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-piggy-bank me-3 fs-4"></i>
                                        <div class="text-start">
                                            <h6 class="mb-1 fw-bold">You saved
                                                ₹{{ number_format($order->discount_amount, 2) }}!</h6>
                                            <p class="mb-0 small">Thanks for using coupon code
                                                <strong>{{ $order->coupon_code }}</strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <a href="{{ route('products') }}" class="btn btn-primary px-4">
                                <i class="fas fa-shopping-bag me-2"></i> Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            border-radius: 15px;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .badge {
            font-size: 0.8rem;
            font-weight: 500;
        }

        .border-bottom {
            border-bottom: 1px solid #e9ecef !important;
        }

        .border-top {
            border-top: 1px solid #e9ecef !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0a58ca, #0d6efd);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
        }

        .btn-outline-primary {
            border-radius: 8px;
            padding: 10px 24px;
        }

        .table tbody tr:last-child {
            border-bottom: none !important;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(25, 135, 84, 0.1), rgba(25, 135, 84, 0.05));
            border: 1px solid rgba(25, 135, 84, 0.2);
        }
    </style>
@endpush
