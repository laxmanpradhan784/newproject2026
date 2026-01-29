@extends('admin.layouts.app')

@section('title', 'Review Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Review Details #{{ $review->id }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-default">
                            <i class="fas fa-arrow-left"></i> Back to Reviews
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Review Header -->
                            <div class="d-flex align-items-center mb-4">
                                <div class="mr-3">
                                    @if($review->user->avatar)
                                        <img src="{{ $review->user->avatar }}" alt="{{ $review->user->name }}" width="60" height="60" class="rounded-circle">
                                    @else
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 24px;">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="mb-0">{{ $review->user->name }}</h4>
                                    <p class="text-muted mb-1">{{ $review->user->email }}</p>
                                    @if($review->is_verified_purchase)
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle"></i> Verified Purchase
                                    </span>
                                    @endif
                                </div>
                                <div class="ml-auto">
                                    <div class="text-right">
                                        <div class="rating-stars mb-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-light' }}"></i>
                                            @endfor
                                            <span class="ml-1">({{ $review->rating }}/5)</span>
                                        </div>
                                        <span class="badge badge-{{ $review->status == 'approved' ? 'success' : ($review->status == 'pending' ? 'warning' : ($review->status == 'rejected' ? 'danger' : 'secondary')) }}">
                                            {{ ucfirst($review->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="card card-outline card-primary mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Product Information</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex">
                                        @if($review->product->image)
                                        <img src="{{ asset('storage/' . $review->product->image) }}" alt="{{ $review->product->name }}" width="80" height="80" class="mr-3 rounded">
                                        @endif
                                        <div>
                                            <h5 class="mb-1">
                                                <a href="{{ route('product.show', $review->product->slug) }}" target="_blank" class="text-dark">
                                                    {{ $review->product->name }}
                                                </a>
                                            </h5>
                                            <p class="text-muted mb-1">Category: {{ $review->product->category->name }}</p>
                                            <p class="mb-0">Price: ₹{{ number_format($review->product->price, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Review Content -->
                            <div class="card card-outline card-info mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Review Content</h3>
                                    <div class="card-tools">
                                        <small class="text-muted">{{ $review->created_at->format('F d, Y \a\t h:i A') }}</small>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if($review->title)
                                    <h5 class="mb-3">{{ $review->title }}</h5>
                                    @endif
                                    <p class="mb-0">{{ $review->comment }}</p>
                                </div>
                            </div>

                            <!-- Helpful Votes -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="info-box bg-success">
                                        <span class="info-box-icon"><i class="fas fa-thumbs-up"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Helpful</span>
                                            <span class="info-box-number">{{ $review->helpful_yes }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-box bg-danger">
                                        <span class="info-box-icon"><i class="fas fa-thumbs-down"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Not Helpful</span>
                                            <span class="info-box-number">{{ $review->helpful_no }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Information (if available) -->
                            @if($review->order)
                            <div class="card card-outline card-secondary mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Order Information</h3>
                                </div>
                                <div class="card-body">
                                    <p><strong>Order Number:</strong> {{ $review->order->order_number }}</p>
                                    <p><strong>Order Date:</strong> {{ $review->order->created_at->format('F d, Y') }}</p>
                                    <p><strong>Order Total:</strong> ₹{{ number_format($review->order->total, 2) }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Status Update Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Status</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.reviews.update-status', $review->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label>Change Status</label>
                            <select name="status" class="form-control" required>
                                <option value="pending" {{ $review->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $review->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $review->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="spam" {{ $review->status == 'spam' ? 'selected' : '' }}>Spam</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-sync-alt"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Admin Response Card -->
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Admin Response</h3>
                </div>
                <div class="card-body">
                    @if($review->admin_response)
                    <div class="alert alert-info">
                        <strong>Your Response:</strong>
                        <p class="mb-0 mt-2">{{ $review->admin_response }}</p>
                        <small class="text-muted">Posted on {{ $review->response_date->format('M d, Y') }}</small>
                    </div>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.reviews.add-response', $review->id) }}">
                        @csrf
                        <div class="form-group">
                            <label>Add/Update Response</label>
                            <textarea name="admin_response" class="form-control" rows="4" placeholder="Enter your response here...">{{ old('admin_response', $review->admin_response) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-reply"></i> {{ $review->admin_response ? 'Update' : 'Add' }} Response
                        </button>
                    </form>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Quick Actions</h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($review->status != 'approved')
                        <form method="POST" action="{{ route('admin.reviews.update-status', $review->id) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-check"></i> Approve Review
                            </button>
                        </form>
                        @endif

                        @if($review->status != 'rejected')
                        <form method="POST" action="{{ route('admin.reviews.update-status', $review->id) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="btn btn-danger btn-block">
                                <i class="fas fa-times"></i> Reject Review
                            </button>
                        </form>
                        @endif

                        <button type="button" class="btn btn-warning btn-block" onclick="window.print()">
                            <i class="fas fa-print"></i> Print Review
                        </button>

                        <form method="POST" action="{{ route('admin.reviews.destroy', $review->id) }}" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-outline-danger btn-block" onclick="confirmDelete()">
                                <i class="fas fa-trash"></i> Delete Review
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Report Info -->
            @if($review->report_count > 0)
            <div class="card card-danger mt-3">
                <div class="card-header">
                    <h3 class="card-title">Reports</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger">
                        <i class="fas fa-flag mr-2"></i>
                        This review has been reported {{ $review->report_count }} time(s) by users.
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmDelete() {
        if (confirm('Are you sure you want to delete this review? This action cannot be undone.')) {
            document.getElementById('deleteForm').submit();
        }
    }

    // Auto-expand textarea
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.querySelector('textarea[name="admin_response"]');
        if (textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = (textarea.scrollHeight) + 'px';
            
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        }
    });
</script>

<style>
.rating-stars {
    font-size: 18px;
    letter-spacing: 3px;
}
.rating-stars .fa-star {
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
</style>
@endsection