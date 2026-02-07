@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Payment History</h1>
    
    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Payments</h5>
                    <h2>{{ $summary['total_payments'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Amount</h5>
                    <h2>₹{{ number_format($summary['total_amount'], 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Successful</h5>
                    <h2>{{ $summary['successful_payments'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Failed</h5>
                    <h2>{{ $summary['failed_payments'] }}</h2>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Payments Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Order No</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Razorpay ID</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                        <tr>
                            <td>#{{ $payment->id }}</td>
                            <td>
                                @if($payment->order)
                                    <a href="{{ route('order-details', $payment->order->order_number) }}">
                                        {{ $payment->order->order_number }}
                                    </a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="font-weight-bold">₹{{ number_format($payment->amount, 2) }}</td>
                            <td>
                                @if($payment->payment_method)
                                    <span class="badge bg-info">{{ ucfirst($payment->payment_method) }}</span>
                                @endif
                                @if($payment->bank)
                                    <small class="d-block">{{ $payment->bank }}</small>
                                @endif
                            </td>
                            <td>
                                @if($payment->status == 'captured')
                                    <span class="badge bg-success">Successful</span>
                                @elseif($payment->status == 'failed')
                                    <span class="badge bg-danger">Failed</span>
                                @else
                                    <span class="badge bg-warning">{{ ucfirst($payment->status) }}</span>
                                @endif
                            </td>
                            <td>{{ $payment->created_at->format('d M Y, h:i A') }}</td>
                            <td>
                                <small class="text-muted">{{ substr($payment->razorpay_payment_id, 0, 15) }}...</small>
                            </td>
                            <td>
                                <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-sm btn-info">
                                    Details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection