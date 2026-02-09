@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Payment Details #{{ $payment->id }}</h1>
        <div>
            <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Payment Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Payment ID:</th>
                                    <td>{{ $payment->id }}</td>
                                </tr>
                                <tr>
                                    <th>Order:</th>
                                    <td>
                                        @if($payment->order)
                                            <a href="{{ route('admin.order.details', $payment->order->id) }}">
                                                {{ $payment->order->order_number }}
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Customer:</th>
                                    <td>
                                        @if($payment->user)
                                            <div>{{ $payment->user->name }}</div>
                                            <small class="text-muted">{{ $payment->user->email }}</small>
                                        @else
                                            Guest
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Amount:</th>
                                    <td class="font-weight-bold text-primary">₹{{ number_format($payment->amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Currency:</th>
                                    <td>{{ $payment->currency }}</td>
                                </tr>
                                <tr>
                                    <th>Date:</th>
                                    <td>{{ $payment->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Status:</th>
                                    <td>
                                        @if($payment->status == 'captured')
                                            <span class="badge text-primary badge-success">Successful</span>
                                        @elseif($payment->status == 'failed')
                                            <span class="badge text-primary badge-danger">Failed</span>
                                        @elseif($payment->status == 'refunded')
                                            <span class="badge text-primary badge-warning">Refunded</span>
                                        @else
                                            <span class="badge text-primary badge-secondary">{{ ucfirst($payment->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Payment Method:</th>
                                    <td>{{ ucfirst($payment->payment_method ?? 'N/A') }}</td>
                                </tr>
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

                    <!-- Refund Information -->
                    @if($payment->refund_amount)
                    <div class="alert alert-warning mt-4">
                        <h5><i class="fas fa-undo"></i> Refund Information</h5>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <strong>Refund Amount:</strong> ₹{{ number_format($payment->refund_amount, 2) }}
                            </div>
                            <div class="col-md-4">
                                <strong>Refund ID:</strong> {{ $payment->refund_id }}
                            </div>
                            <div class="col-md-4">
                                <strong>Refund Date:</strong> {{ $payment->refunded_at->format('d M Y, h:i A') }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Gateway Response -->
                    @if($payment->gateway_response)
                    <div class="mt-4">
                        <h6>Gateway Response</h6>
                        <pre class="bg-light p-3" style="max-height: 300px; overflow: auto;">
{{ json_encode($payment->gateway_response, JSON_PRETTY_PRINT) }}
                        </pre>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Refund Form -->
            @if($payment->status == 'captured' && !$payment->refund_amount)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Process Refund</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.payments.refund', $payment->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Payment Amount</label>
                                    <input type="text" class="form-control" 
                                           value="₹{{ number_format($payment->amount, 2) }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Refund Amount *</label>
                                    <input type="number" name="refund_amount" 
                                           class="form-control" step="0.01" 
                                           max="{{ $payment->amount }}" 
                                           value="{{ $payment->amount }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Refund Reason *</label>
                                    <select name="reason" class="form-control" required>
                                        <option value="">Select Reason</option>
                                        <option value="customer_request">Customer Request</option>
                                        <option value="duplicate_payment">Duplicate Payment</option>
                                        <option value="product_unavailable">Product Unavailable</option>
                                        <option value="order_cancelled">Order Cancelled</option>
                                        <option value="fraudulent_transaction">Fraudulent Transaction</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Additional Notes</label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-undo"></i> Process Refund
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Order Information -->
            @if($payment->order)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Order Information</h6>
                </div>
                <div class="card-body">
                    <p><strong>Order Status:</strong> 
                        <span class="badge text-primary badge-{{ $payment->order->status == 'delivered' ? 'success' : 'info' }}">
                            {{ ucfirst($payment->order->status) }}
                        </span>
                    </p>
                    <p><strong>Order Date:</strong> {{ $payment->order->created_at->format('d M Y') }}</p>
                    <p><strong>Payment Status:</strong> {{ ucfirst($payment->order->payment_status) }}</p>
                    <hr>
                    <h6>Order Items:</h6>
                    <ul class="list-group list-group-flush">
                        @foreach($payment->order->items as $item)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $item->product_name }} (x{{ $item->quantity }})</span>
                            <span>₹{{ number_format($item->total, 2) }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <!-- Actions Card -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($payment->order)
                        <a href="{{ route('admin.order.details', $payment->order->id) }}" 
                           class="btn btn-info btn-block">
                            <i class="fas fa-shopping-cart"></i> View Order
                        </a>
                        @endif
                        @if($payment->status != 'captured')
                        <form action="{{ route('admin.payments.destroy', $payment->id) }}" 
                              method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block" 
                                    onclick="return confirm('Delete this payment record?')">
                                <i class="fas fa-trash"></i> Delete Payment
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection