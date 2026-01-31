@extends('admin.layouts.app')

@section('title', 'Coupon Details')
@section('page-title', 'Coupon Details: ' . $coupon->code)

@section('actions')
    <div class="btn-group btn-group-sm">
        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <!-- Left Column: Coupon Information -->
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header py-2 d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Coupon Information</h6>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                        data-bs-target="#usageStatisticsModal">
                        <i class="fas fa-chart-bar"></i> View Details
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                        data-bs-target="#deleteCouponModal">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="row g-2">
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-bold mb-1">Coupon Code</label>
                        <div class="form-control form-control-sm bg-light py-1">
                            <strong class="text-primary">{{ $coupon->code }}</strong>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-bold mb-1">Status</label>
                        <div>
                            @php
                                $statusClasses = [
                                    'active' => 'badge bg-success',
                                    'inactive' => 'badge bg-warning',
                                    'expired' => 'badge bg-danger',
                                ];
                            @endphp
                            <span class="{{ $statusClasses[$coupon->status] }} small">
                                {{ ucfirst($coupon->status) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="col-md-12 mb-2">
                        <label class="form-label small fw-bold mb-1">Coupon Name</label>
                        <div class="form-control form-control-sm bg-light py-1">{{ $coupon->name }}</div>
                    </div>
                    
                    <div class="col-md-12 mb-2">
                        <label class="form-label small fw-bold mb-1">Description</label>
                        <div class="form-control form-control-sm bg-light py-1" style="min-height: 40px;">
                            {{ $coupon->description ?? 'No description' }}
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-2">
                        <label class="form-label small fw-bold mb-1">Discount Type</label>
                        <div class="form-control form-control-sm bg-light py-1">
                            {{ ucfirst(str_replace('_', ' ', $coupon->discount_type)) }}
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-2">
                        <label class="form-label small fw-bold mb-1">Discount Value</label>
                        <div class="form-control form-control-sm bg-light py-1">
                            @if ($coupon->discount_type == 'percentage')
                                <span class="text-success fw-bold">{{ $coupon->discount_value }}%</span>
                            @else
                                <span class="text-primary fw-bold">₹{{ number_format($coupon->discount_value, 2) }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-2">
                        <label class="form-label small fw-bold mb-1">Max Discount</label>
                        <div class="form-control form-control-sm bg-light py-1">
                            @if ($coupon->max_discount_amount)
                                ₹{{ number_format($coupon->max_discount_amount, 2) }}
                            @else
                                <span class="text-muted small">No limit</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-bold mb-1">Minimum Order Amount</label>
                        <div class="form-control form-control-sm bg-light py-1">
                            ₹{{ number_format($coupon->min_order_amount, 2) }}
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-bold mb-1">Validity Period</label>
                        <div class="form-control form-control-sm bg-light py-1">
                            {{ $coupon->start_date->format('d M Y') }} to {{ $coupon->end_date->format('d M Y') }}
                            @if ($coupon->end_date < now())
                                <span class="badge bg-danger ms-2 small">Expired</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-bold mb-1">Usage Limit</label>
                        <div class="form-control form-control-sm bg-light py-1">
                            @if ($coupon->usage_limit)
                                {{ $coupon->usage_limit }} total uses
                            @else
                                <span class="text-success fw-bold">Unlimited</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-bold mb-1">Usage Limit Per User</label>
                        <div class="form-control form-control-sm bg-light py-1">
                            {{ $coupon->usage_limit_per_user }} time(s)
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-2">
                        <label class="form-label small fw-bold mb-1">User Scope</label>
                        <div class="form-control form-control-sm bg-light py-1">
                            {{ $coupon->user_scope == 'all' ? 'All Users' : 'Specific Users' }}
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-2">
                        <label class="form-label small fw-bold mb-1">Category Scope</label>
                        <div class="form-control form-control-sm bg-light py-1">
                            {{ $coupon->category_scope == 'all' ? 'All Categories' : 'Specific Categories' }}
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-2">
                        <label class="form-label small fw-bold mb-1">Product Scope</label>
                        <div class="form-control form-control-sm bg-light py-1">
                            {{ $coupon->product_scope == 'all' ? 'All Products' : 'Specific Products' }}
                        </div>
                    </div>
                    
                    <!-- Specific Users Section -->
                    @if($coupon->user_scope == 'specific' && $coupon->users->count() > 0)
                        <div class="col-12 mb-2">
                            <label class="form-label small fw-bold mb-1">Applicable Users ({{ $coupon->users->count() }})</label>
                            <div class="border rounded p-2 bg-light">
                                <div class="row g-1">
                                    @foreach($coupon->users as $user)
                                        <div class="col-md-6">
                                            <div class="d-flex justify-content-between align-items-center p-1 border-bottom">
                                                <div>
                                                    <span class="small">{{ $user->name }}</span><br>
                                                    <small class="text-muted">{{ $user->email }}</small>
                                                </div>
                                                <span class="badge bg-info small">
                                                    {{ $coupon->usages()->where('user_id', $user->id)->count() }} uses
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Specific Categories Section -->
                    @if($coupon->category_scope == 'specific' && $coupon->categories->count() > 0)
                        <div class="col-12 mb-2">
                            <label class="form-label small fw-bold mb-1">Applicable Categories ({{ $coupon->categories->count() }})</label>
                            <div class="border rounded p-2 bg-light">
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($coupon->categories as $category)
                                        <span class="badge bg-primary small">{{ $category->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Specific Products Section -->
                    @if($coupon->product_scope == 'specific' && $coupon->products->count() > 0)
                        <div class="col-12 mb-2">
                            <label class="form-label small fw-bold mb-1">Applicable Products ({{ $coupon->products->count() }})</label>
                            <div class="border rounded p-2 bg-light">
                                <div class="row g-1">
                                    @foreach($coupon->products as $product)
                                        <div class="col-md-6">
                                            <div class="p-1 border-bottom">
                                                <span class="small">{{ $product->name }}</span><br>
                                                <small class="text-muted">₹{{ number_format($product->price, 2) }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-bold mb-1">Created At</label>
                        <div class="form-control form-control-sm bg-light py-1">
                            {{ $coupon->created_at->format('d M Y, h:i A') }}
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-2">
                        <label class="form-label small fw-bold mb-1">Updated At</label>
                        <div class="form-control form-control-sm bg-light py-1">
                            {{ $coupon->updated_at->format('d M Y, h:i A') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Right Column: Recent Usage & Statistics -->
    <div class="col-md-4">
        <!-- Recent Usage Card -->
        <div class="card mb-3">
            <div class="card-header py-2">
                <h6 class="mb-0">Recent Usage</h6>
            </div>
            <div class="card-body p-3">
                @if ($coupon->usages->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach ($coupon->usages->take(5) as $usage)
                            <div class="list-group-item px-0 py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong class="small">Order #{{ $usage->order->order_number ?? 'N/A' }}</strong><br>
                                        <small class="text-muted">
                                            {{ $usage->user->name ?? 'User' }} • 
                                            {{ $usage->used_at->format('d M, h:i A') }}
                                        </small>
                                    </div>
                                    <span class="badge bg-success small">
                                        -₹{{ number_format($usage->discount_amount, 2) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if ($coupon->usages->count() > 5)
                        <div class="text-center mt-2">
                            <a href="#" class="btn btn-sm btn-outline-primary small">View All Usage</a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-history fa-2x text-muted mb-2"></i>
                        <p class="text-muted small mb-0">No usage history yet</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Usage Statistics Card -->
        <div class="card">
            <div class="card-header py-2">
                <h6 class="mb-0">Usage Statistics</h6>
            </div>
            <div class="card-body p-3">
                <div class="row g-2">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body text-center py-2">
                                <h4 class="text-primary mb-1">{{ $coupon->usages_count }}</h4>
                                <p class="text-muted mb-0 small">Total Uses</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body text-center py-2">
                                <h4 class="text-success mb-1">
                                    @if($coupon->usage_limit)
                                        {{ number_format(($coupon->usages_count / $coupon->usage_limit) * 100, 1) }}%
                                    @else
                                        0%
                                    @endif
                                </h4>
                                <p class="text-muted mb-0 small">Usage Rate</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($coupon->usage_limit)
                    <div class="mt-3">
                        <label class="small fw-bold mb-1">Usage Progress</label>
                        <div class="progress" style="height: 20px;">
                            @php
                                $usagePercentage = min(100, ($coupon->usages_count / $coupon->usage_limit) * 100);
                            @endphp
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: {{ $usagePercentage }}%">
                                <span class="small fw-bold">{{ $coupon->usages_count }} / {{ $coupon->usage_limit }}</span>
                            </div>
                        </div>
                        <div class="text-center small mt-1">
                            {{ $coupon->usages_count }} of {{ $coupon->usage_limit }} uses
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Usage Statistics Modal -->
<div class="modal fade" id="usageStatisticsModal" tabindex="-1" aria-labelledby="usageStatisticsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="usageStatisticsModalLabel">
                    <i class="fas fa-chart-bar me-2"></i>Detailed Usage Statistics: {{ $coupon->code }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Summary Cards -->
                    <div class="col-md-4 mb-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center py-3">
                                <h3 class="mb-2">{{ $coupon->usages_count }}</h3>
                                <p class="mb-0">Total Uses</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center py-3">
                                <h3 class="mb-2">
                                    @if ($coupon->usage_limit)
                                        {{ number_format(($coupon->usages_count / $coupon->usage_limit) * 100, 1) }}%
                                    @else
                                        0%
                                    @endif
                                </h3>
                                <p class="mb-0">Usage Rate</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center py-3">
                                <h3 class="mb-2">
                                    @if ($coupon->usages_count > 0)
                                        ₹{{ number_format($coupon->usages()->sum('discount_amount'), 2) }}
                                    @else
                                        ₹0.00
                                    @endif
                                </h3>
                                <p class="mb-0">Total Discount Given</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Statistics -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Usage Over Time</h6>
                            </div>
                            <div class="card-body">
                                @if ($coupon->usages_count > 0)
                                    <div class="text-center py-4">
                                        <canvas id="usageChart" height="200"></canvas>
                                    </div>
                                    <div class="small text-muted text-center">
                                        Last 30 days usage pattern
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No usage data available</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Top Users</h6>
                            </div>
                            <div class="card-body">
                                @if ($coupon->usages_count > 0)
                                    @php
                                        $topUsers = $coupon
                                            ->usages()
                                            ->selectRaw(
                                                'user_id, COUNT(*) as usage_count, SUM(discount_amount) as total_discount',
                                            )
                                            ->groupBy('user_id')
                                            ->orderBy('usage_count', 'desc')
                                            ->limit(5)
                                            ->with('user')
                                            ->get();
                                    @endphp
                                    <div class="list-group list-group-flush">
                                        @foreach ($topUsers as $usage)
                                            <div class="list-group-item px-0 py-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong
                                                            class="small">{{ $usage->user->name ?? 'Unknown User' }}</strong><br>
                                                        <small
                                                            class="text-muted">{{ $usage->user->email ?? 'N/A' }}</small>
                                                    </div>
                                                    <div class="text-end">
                                                        <span class="badge bg-primary">{{ $usage->usage_count }}
                                                            uses</span><br>
                                                        <small
                                                            class="text-muted">₹{{ number_format($usage->total_discount, 2) }}
                                                            saved</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No user data available</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usage Details Table -->
                @if ($coupon->usages_count > 0)
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Recent Usage Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>User</th>
                                            <th>Date</th>
                                            <th>Discount</th>
                                            <th>Order Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($coupon->usages->take(10) as $usage)
                                            <tr>
                                                <td>{{ $usage->order->order_number ?? 'N/A' }}</td>
                                                <td>{{ $usage->user->name ?? 'Unknown' }}</td>
                                                <td>{{ $usage->used_at->format('d M, h:i A') }}</td>
                                                <td class="text-danger">
                                                    -₹{{ number_format($usage->discount_amount, 2) }}</td>
                                                <td>₹{{ number_format($usage->final_total, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-primary">Back to Coupons</a>
            </div>
        </div>
    </div>
</div>

<!-- Delete Coupon Modal -->
<div class="modal fade" id="deleteCouponModal" tabindex="-1" aria-labelledby="deleteCouponModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteCouponModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-trash-alt fa-4x text-danger mb-3"></i>
                    <h5>Delete Coupon: <span class="text-primary">{{ $coupon->code }}</span></h5>
                </div>

                <div class="alert alert-warning">
                    <h6 class="alert-heading"><i class="fas fa-exclamation-circle"></i> Warning</h6>
                    <p class="mb-2">This action cannot be undone. The following data will be permanently deleted:</p>
                    <ul class="mb-0">
                        <li>Coupon record: <strong>{{ $coupon->name }}</strong></li>
                        <li>Usage history: <strong>{{ $coupon->usages_count }} records</strong></li>
                        <li>Associated data with orders</li>
                    </ul>
                </div>

                @if ($coupon->usages_count > 0)
                    <div class="alert alert-danger">
                        <h6 class="alert-heading"><i class="fas fa-ban"></i> Restrictions</h6>
                        <p class="mb-0">This coupon has been used <strong>{{ $coupon->usages_count }}
                                times</strong>.
                            Deleting it may affect order history and reporting.</p>
                    </div>
                @endif

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="confirmDelete">
                    <label class="form-check-label" for="confirmDelete">
                        I understand this action is irreversible and I want to proceed
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="deleteButton" disabled>
                        <i class="fas fa-trash"></i> Delete Permanently
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Delete confirmation checkbox
            const confirmCheckbox = document.getElementById('confirmDelete');
            const deleteButton = document.getElementById('deleteButton');

            if (confirmCheckbox && deleteButton) {
                confirmCheckbox.addEventListener('change', function() {
                    deleteButton.disabled = !this.checked;
                });

                // Reset on modal close
                const deleteModal = document.getElementById('deleteCouponModal');
                if (deleteModal) {
                    deleteModal.addEventListener('hidden.bs.modal', function() {
                        confirmCheckbox.checked = false;
                        deleteButton.disabled = true;
                    });
                }
            }

            // Usage Statistics Chart
            @if ($coupon->usages_count > 0)
                // Generate last 30 days data
                const usageData = {!! json_encode($coupon->usageStats ?? []) !!};

                // Prepare chart data
                const dates = [];
                const counts = [];

                // Generate last 30 days
                for (let i = 29; i >= 0; i--) {
                    const date = new Date();
                    date.setDate(date.getDate() - i);
                    const dateStr = date.toISOString().split('T')[0];
                    dates.push(date.toLocaleDateString('en-GB', {
                        day: 'numeric',
                        month: 'short'
                    }));

                    // Find usage for this date
                    const usageForDate = usageData.find(u => u.date === dateStr);
                    counts.push(usageForDate ? parseInt(usageForDate.count) : 0);
                }

                // Create chart
                const ctx = document.getElementById('usageChart');
                if (ctx) {
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: dates,
                            datasets: [{
                                label: 'Daily Usage',
                                data: counts,
                                borderColor: '#4361ee',
                                backgroundColor: 'rgba(67, 97, 238, 0.1)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    },
                                    title: {
                                        display: true,
                                        text: 'Number of Uses'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Date'
                                    }
                                }
                            }
                        }
                    });
                }
            @endif

            // Add animation to progress bar
            const progressBar = document.querySelector('.progress-bar');
            if (progressBar) {
                setTimeout(() => {
                    progressBar.style.transition = 'width 1.5s ease-in-out';
                }, 500);
            }
        });
    </script>
@endpush