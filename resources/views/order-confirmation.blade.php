@extends('layouts.app') @section('title', 'Order Confirmation')
@section('content')
    <div class="container py-5">
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
                        <p class="text-muted mb-4">Thank you for your purchase.</p>

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
                                        <tr>
                                            <td class="text-muted py-3 fs-5">Total Amount</td>
                                            <td class="text-end fw-bold text-success fs-4 py-3">
                                                ₹{{ number_format($order->total, 2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Simple Button -->
                        <div class="mt-4">
                            <button class="btn btn-primary">Continue Shopping</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
