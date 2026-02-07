@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Payment Analytics Dashboard</h1>
        <div>
            <a href="{{ route('admin.payments.index') }}" class="btn btn-primary">
                <i class="fas fa-list"></i> All Payments
            </a>
            <a href="{{ route('admin.payments.export') }}" class="btn btn-secondary">
                <i class="fas fa-file-export"></i> Export
            </a>
        </div>
    </div>

    <!-- Summary Row -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Revenue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ₹{{ number_format($stats['all_time']['amount'], 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-rupee-sign fa-2x text-gray-300"></i>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ₹{{ number_format($stats['this_month']['amount'], 2) }}
                            </div>
                            <div class="mt-2 text-xs">{{ $stats['this_month']['count'] }} Payments</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
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
                                Success Rate</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $successCount = $stats['status_counts']['captured'] ?? 0;
                                    $failedCount = $stats['status_counts']['failed'] ?? 0;
                                    $total = $successCount + $failedCount;
                                    $rate = $total > 0 ? round(($successCount / $total) * 100, 1) : 0;
                                @endphp
                                {{ $rate }}%
                            </div>
                            <div class="mt-2 text-xs">{{ $successCount }} Success / {{ $failedCount }} Failed</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
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
                                Average Payment</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $avg = $stats['all_time']['count'] > 0 ? 
                                           $stats['all_time']['amount'] / $stats['all_time']['count'] : 0;
                                @endphp
                                ₹{{ number_format($avg, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calculator fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Revenue Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Revenue Last 30 Days</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Methods Distribution -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Payment Methods</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4">
                        <canvas id="methodChart"></canvas>
                    </div>
                    <div class="mt-4">
                        @foreach($methodDistribution as $method)
                        <div class="mb-2">
                            <span class="badge badge-info">{{ ucfirst($method->payment_method) }}</span>
                            <span class="float-right">
                                {{ $method->count }} payments (₹{{ number_format($method->amount, 2) }})
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Payments</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Order</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPayments as $payment)
                                <tr>
                                    <td>#{{ $payment->id }}</td>
                                    <td>
                                        @if($payment->order)
                                            <a href="{{ route('admin.order.details', $payment->order->id) }}">
                                                {{ $payment->order->order_number }}
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ $payment->user->name ?? 'Guest' }}</td>
                                    <td>₹{{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ ucfirst($payment->payment_method ?? 'N/A') }}</td>
                                    <td>
                                        @if($payment->status == 'captured')
                                            <span class="badge badge-success">Success</span>
                                        @else
                                            <span class="badge badge-danger">Failed</span>
                                        @endif
                                    </td>
                                    <td>{{ $payment->created_at->format('d M, h:i A') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Revenue Chart
var ctx = document.getElementById('revenueChart').getContext('2d');
var revenueChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [
            @foreach($dailyData as $data)
                '{{ \Carbon\Carbon::parse($data->date)->format("d M") }}',
            @endforeach
        ],
        datasets: [{
            label: 'Revenue (₹)',
            data: [
                @foreach($dailyData as $data)
                    {{ $data->amount ?? 0 }},
                @endforeach
            ],
            borderColor: '#4e73df',
            backgroundColor: 'rgba(78, 115, 223, 0.05)',
            tension: 0.4
        }]
    },
    options: {
        maintainAspectRatio: false,
        scales: {
            x: {
                grid: {
                    display: false
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '₹' + value.toLocaleString();
                    }
                }
            }
        }
    }
});

// Method Distribution Chart
var ctx2 = document.getElementById('methodChart').getContext('2d');
var methodChart = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: [
            @foreach($methodDistribution as $method)
                '{{ ucfirst($method->payment_method) }}',
            @endforeach
        ],
        datasets: [{
            data: [
                @foreach($methodDistribution as $method)
                    {{ $method->count }},
                @endforeach
            ],
            backgroundColor: [
                '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e',
                '#e74a3b', '#858796', '#6f42c1', '#fd7e14'
            ],
            hoverBackgroundColor: [
                '#2e59d9', '#17a673', '#2c9faf', '#f4b619',
                '#e02d1b', '#6c757d', '#6610f2', '#fd8e2e'
            ]
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>
@endsection