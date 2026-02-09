@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Payment Details #{{ $payment->id }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Payment Information</h5>
                            <table class="table table-sm">
                                <tr>
                                    <th>Amount:</th>
                                    <td class="font-weight-bold">₹{{ number_format($payment->amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Currency:</th>
                                    <td>{{ $payment->currency }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @if($payment->status == 'captured')
                                            <span class="badge bg-success">Successful</span>
                                        @elseif($payment->status == 'failed')
                                            <span class="badge bg-danger">Failed</span>
                                        @else
                                            <span class="badge bg-warning">{{ ucfirst($payment->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Payment Method:</th>
                                    <td>{{ ucfirst($payment->payment_method) ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Date:</th>
                                    <td>{{ $payment->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Gateway Details</h5>
                            <table class="table table-sm">
                                <tr>
                                    <th>Gateway:</th>
                                    <td>{{ ucfirst($payment->payment_gateway) }}</td>
                                </tr>
                                <tr>
                                    <th>Razorpay ID:</th>
                                    <td><small>{{ $payment->razorpay_payment_id }}</small></td>
                                </tr>
                                @if($payment->bank)
                                <tr>
                                    <th>Bank:</th>
                                    <td>{{ $payment->bank }}</td>
                                </tr>
                                @endif
                                @if($payment->card_type)
                                <tr>
                                    <th>Card Type:</th>
                                    <td>{{ ucfirst($payment->card_type) }}</td>
                                </tr>
                                @endif
                                @if($payment->wallet)
                                <tr>
                                    <th>Wallet:</th>
                                    <td>{{ $payment->wallet }}</td>
                                </tr>
                                @endif
                                @if($payment->vpa)
                                <tr>
                                    <th>UPI ID:</th>
                                    <td>{{ $payment->vpa }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    
                    @if($payment->order)
                    <hr>
                    <h5>Order Information</h5>
                    <div class="row">
                        <div class="col-md-12">
                            <p><strong>Order Number:</strong> 
                                <a href="{{ route('order-details', $payment->order->order_number) }}">
                                    {{ $payment->order->order_number }}
                                </a>
                            </p>
                        </div>
                    </div>
                    @endif
                    
                    {{-- @if($payment->gateway_response)
                    <hr>
                    <h5>Gateway Response</h5>
                    <pre class="bg-light p-3" style="max-height: 300px; overflow: auto;">
{{ json_encode($payment->gateway_response, JSON_PRETTY_PRINT) }}
                    </pre>
                    @endif --}}
                </div>
                <div class="card-footer">
                    <a href="{{ route('payments.index') }}" class="btn btn-secondary">
                        ← Back to Payment History
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('orders') }}" class="btn btn-outline-primary">
                            View All Orders
                        </a>
                        <a href="{{ route('profile') }}" class="btn btn-outline-secondary">
                            My Profile
                        </a>
                        @if($payment->status == 'captured' && $payment->order)
                        <a href="{{ route('order-details', $payment->order->order_number) }}" class="btn btn-outline-success">
                            View Order Details
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection