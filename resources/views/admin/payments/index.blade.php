@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Payment Management</h1>
            <div>
                {{-- <a href="{{ route('admin.payments.export') }}" class="btn btn-secondary">
                <i class="fas fa-file-export"></i> Export CSV
            </a> --}}
                <a href="{{ route('admin.payments.dashboard') }}" class="btn btn-info">
                    <i class="fas fa-chart-line"></i> Analytics
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Today's Payments</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['today']['count'] }}</div>
                                <div class="mt-2 text-xs">₹{{ number_format($stats['today']['amount'], 2) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    This Month</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['this_month']['count'] }}
                                </div>
                                <div class="mt-2 text-xs">₹{{ number_format($stats['this_month']['amount'], 2) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    All Time Total</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['all_time']['count'] }}</div>
                                <div class="mt-2 text-xs">₹{{ number_format($stats['all_time']['amount'], 2) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-rupee-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Failed Payments</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $stats['status_counts']['failed'] ?? 0 }}</div>
                                <div class="mt-2 text-xs">{{ $stats['status_counts']['captured'] ?? 0 }} Successful</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payments Table -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">All Payments</h6>
                <form method="GET" class="d-flex" style="width: 300px;">
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Search order, customer, payment ID..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-sm btn-primary ms-2">
                        <i class="fas fa-search"></i>
                    </button>
                    @if (request('search'))
                        <a href="{{ route('admin.payments.index') }}" class="btn btn-sm btn-secondary ms-2">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </form>
            </div>

            <div class="card-body">
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr style="position: sticky; top: 0; background-color: #f8f9fc; z-index: 1;">
                                <th>ID</th>
                                <th>Order No</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Gateway</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>#{{ $payment->id }}</td>
                                    <td>
                                        @if ($payment->order)
                                            <a href="{{ route('admin.order.details', $payment->order->id) }}">
                                                {{ $payment->order->order_number }}
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if ($payment->user)
                                            <div>{{ $payment->user->name }}</div>
                                            <small class="text-muted">{{ $payment->user->email }}</small>
                                        @else
                                            Guest
                                        @endif
                                    </td>
                                    <td class="font-weight-bold">₹{{ number_format($payment->amount, 2) }}</td>
                                    <td>
                                        @if ($payment->payment_method)
                                            <span
                                                class="badge badge-info text-primary">{{ ucfirst($payment->payment_method) }}</span>
                                        @endif
                                        @if ($payment->bank)
                                            <small class="d-block">{{ $payment->bank }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($payment->status == 'captured')
                                            <span class="badge text-primary badge-success">Successful</span>
                                        @elseif($payment->status == 'failed')
                                            <span class="badge text-primary badge-danger">Failed</span>
                                        @elseif($payment->status == 'refunded')
                                            <span class="badge text-primary badge-warning">Refunded</span>
                                        @else
                                            <span
                                                class="badge text-primary badge-secondary">{{ ucfirst($payment->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $payment->created_at->format('d M Y, h:i A') }}</td>
                                    <td>
                                        <small class="text-muted d-block">ID:
                                            {{ substr($payment->razorpay_payment_id, 0, 10) }}...</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.payments.show', $payment->id) }}"
                                                class="btn btn-info btn-sm" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if ($payment->status == 'captured' && !$payment->refund_amount)
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                    data-target="#refundModal{{ $payment->id }}" title="Refund">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            @endif
                                            @if ($payment->status != 'captured')
                                                <form action="{{ route('admin.payments.destroy', $payment->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure?')" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                        <!-- Refund Modal -->
                                        <div class="modal fade" id="refundModal{{ $payment->id }}" tabindex="-1"
                                            role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin.payments.refund', $payment->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Process Refund</h5>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label>Payment Amount:</label>
                                                                <input type="text" class="form-control"
                                                                    value="₹{{ number_format($payment->amount, 2) }}"
                                                                    readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Refund Amount *</label>
                                                                <input type="number" name="refund_amount"
                                                                    class="form-control" step="0.01"
                                                                    max="{{ $payment->amount }}"
                                                                    value="{{ $payment->amount }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Reason *</label>
                                                                <textarea name="reason" class="form-control" rows="3" required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-warning">Process
                                                                Refund</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif
    @if (session('error'))
        <script>
            toastr.error("{{ session('error') }}");
        </script>
    @endif
@endsection
