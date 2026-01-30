@extends('admin.layouts.app')

@section('title', 'Review Details')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-primary">Review Details</h3>
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
                                <div class="d-flex align-items-center mb-4 px-3">
                                    <!-- Avatar -->
                                    <div class="me-3">
                                        @if ($review->user->avatar)
                                            <img src="{{ $review->user->avatar }}" alt="{{ $review->user->name }}"
                                                width="60" height="60" class="rounded-circle">
                                        @else
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 60px; height: 60px; font-size: 24px;">
                                                {{ substr($review->user->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Name & Email -->
                                    <div class="flex-grow-1 ps-2">
                                        <h4 class="mb-1">{{ $review->user->name }}</h4>
                                        <p class="text-muted mb-1">{{ $review->user->email }}</p>

                                        @if ($review->is_verified_purchase)
                                            <span class="badge bg-success text-dark">
                                                <i class="fas fa-check-circle"></i> Verified Purchase
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Rating & Status -->
                                    <div class="text-end ms-4">
                                        <div class="rating-stars mb-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-light' }}"></i>
                                            @endfor
                                            <span class="ms-2">({{ $review->rating }}/5)</span>
                                        </div>

                                        <span
                                            class="badge bg-{{ $review->status == 'approved' ? 'success' : ($review->status == 'pending' ? 'warning' : ($review->status == 'rejected' ? 'danger' : 'secondary')) }}">
                                            {{ ucfirst($review->status) }}
                                        </span>
                                    </div>
                                </div>


                                <div class="row">
                                    <!-- Left Column: Product Info -->
                                    <div class="col-md-6 mb-4">
                                        <div class="card card-outline card-primary h-100">
                                            <div class="card-header">
                                                <h3 class="card-title">Product Information</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    @if ($review->product->image)
                                                        <div class="col-md-4 mb-3 mb-md-0">
                                                            <img src="{{ asset('uploads/products/' . $review->product->image) }}"
                                                                alt="{{ $review->product->name }}"
                                                                class="img-fluid rounded border"
                                                                style="max-height: 80px; width: auto;">
                                                        </div>
                                                    @endif

                                                    <div
                                                        class="{{ $review->product->image ? 'col-md-8' : 'col-12' }} text-end pe-4">
                                                        <h5 class="mb-2">
                                                            <a href="{{ route('product.show', $review->product->id) }}"
                                                                target="_blank" class="text-dark text-decoration-none">
                                                                {{ $review->product->name }}
                                                            </a>
                                                        </h5>
                                                        <p class="text-muted mb-2">
                                                            <strong>Category:</strong>
                                                            {{ $review->product->category->name }}
                                                        </p>
                                                        <p class="mb-2">
                                                            <strong>Price:</strong>
                                                            ₹{{ number_format($review->product->price, 2) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Column: Review Content -->
                                    <div class="col-md-6 mb-4">
                                        <div class="card card-outline card-info h-100">
                                            <div class="card-header d-flex align-items-center justify-content-between px-4">
                                                <h3 class="card-title mb-0">
                                                    Review Content
                                                </h3>

                                                <small class="text-muted ms-3">
                                                    {{ $review->created_at->format('F d, Y \a\t h:i A') }}
                                                </small>
                                            </div>

                                            <div class="card-body px-4 py-3">
                                                @if ($review->title)
                                                    <h5 class="mb-3">{{ $review->title }}</h5>
                                                @endif

                                                <p class="mb-0">{{ $review->comment }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Helpful Votes -->
                                <div class="row mb-4 g-3">
                                    <div class="col-md-6">
                                        <div class="info-box bg-success px-3 py-2 rounded">
                                            <span class="info-box-icon me-3">
                                                <i class="fas fa-thumbs-up"></i>
                                            </span>

                                            <div class="info-box-content">
                                                <span class="info-box-text">Helpful</span>
                                                <span class="info-box-number">{{ $review->helpful_yes }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-box bg-danger px-3 py-2 rounded">
                                            <span class="info-box-icon me-3">
                                                <i class="fas fa-thumbs-down"></i>
                                            </span>

                                            <div class="info-box-content">
                                                <span class="info-box-text">Not Helpful</span>
                                                <span class="info-box-number">{{ $review->helpful_no }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                @if ($review->order)
                                    <div class="card card-outline card-secondary mb-2 rounded-3 shadow-sm">
                                        <div class="card-header d-flex align-items-center justify-content-between px-4">
                                            <h3 class="card-title mb-0">
                                                <i class="fas fa-receipt me-2 text-secondary"></i>
                                                Order Information
                                            </h3>
                                        </div>

                                        <div class="card-body px-4 py-3">
                                            <div class="row mb-2">
                                                <div class="col-6 text-muted">Order Number</div>
                                                <div class="col-6 text-end fw-semibold">
                                                    {{ $review->order->order_number }}
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-6 text-muted">Order Date</div>
                                                <div class="col-6 text-end">
                                                    {{ $review->order->created_at->format('F d, Y') }}
                                                </div>
                                            </div>

                                            <div class="row pt-2 border-top">
                                                <div class="col-6 fw-bold">Order Total</div>
                                                <div class="col-6 text-end fw-bold text-success">
                                                    ₹{{ number_format($review->order->total, 2) }}
                                                </div>
                                            </div>
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
                <div class="card card-outline card-primary rounded-3 shadow-sm">
                    <div class="card-header d-flex align-items-center px-4">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-edit me-2"></i>
                            Update Review Status
                        </h3>
                    </div>

                    <div class="card-body px-4 py-3">
                        <form method="POST" action="{{ route('admin.reviews.update-status', $review->id) }}">
                            @csrf
                            @method('PATCH')

                            <div class="form-group mb-3">
                                <label class="fw-semibold mb-1">Change Status</label>
                                <select name="status" class="form-control rounded-2" required>
                                    <option value="pending" {{ $review->status == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="approved" {{ $review->status == 'approved' ? 'selected' : '' }}>
                                        Approved
                                    </option>
                                    <option value="rejected" {{ $review->status == 'rejected' ? 'selected' : '' }}>
                                        Rejected
                                    </option>
                                    <option value="spam" {{ $review->status == 'spam' ? 'selected' : '' }}>
                                        Spam
                                    </option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-2 py-2">
                                <i class="fas fa-sync-alt me-2"></i>
                                Update Status
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="card card-outline card-secondary mt-3 rounded-3 shadow-sm">
                    <div class="card-header d-flex align-items-center px-4">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-bolt me-2"></i>
                            Quick Actions
                        </h3>
                    </div>

                    <div class="card-body px-4 py-3">
                        <div class="d-grid gap-3">

                            @if ($review->status != 'approved')
                                <form method="POST" action="{{ route('admin.reviews.update-status', $review->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-success w-100 rounded-2 py-2">
                                        <i class="fas fa-check me-2"></i>
                                        Approve Review
                                    </button>
                                </form>
                            @endif

                            @if ($review->status != 'rejected')
                                <form method="POST" action="{{ route('admin.reviews.update-status', $review->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-danger w-100 rounded-2 py-2">
                                        <i class="fas fa-times me-2"></i>
                                        Reject Review
                                    </button>
                                </form>
                            @endif

                            <button type="button" class="btn btn-warning w-100 rounded-2 py-2" onclick="window.print()">
                                <i class="fas fa-print me-2"></i>
                                Print Review
                            </button>

                            <form method="POST" action="{{ route('admin.reviews.destroy', $review->id) }}"
                                id="deleteForm">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-outline-danger w-100 rounded-2 py-2"
                                    onclick="confirmDelete()">
                                    <i class="fas fa-trash me-2"></i>
                                    Delete Review
                                </button>

                                <!-- Admin Response Button (Triggers Modal) -->
                                <button type="button" class="btn btn-success w-100 rounded-2 mt-3 py-2"
                                    data-bs-toggle="modal" data-bs-target="#adminResponseModal">
                                    <i class="fas fa-reply me-2"></i>
                                    {{ $review->admin_response ? 'Give' : 'Add' }} Response
                                </button>
                            </form>

                        </div>
                    </div>
                </div>

                <!-- Admin Response Modal -->
                <div class="modal fade" id="adminResponseModal" tabindex="-1" aria-labelledby="adminResponseModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('admin.reviews.add-response', $review->id) }}">
                                @csrf

                                <div class="modal-header">
                                    <h5 class="modal-title" id="adminResponseModalLabel">
                                        <i class="fas fa-reply me-2"></i>
                                        Give Response
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    @if ($review->admin_response)
                                        <div class="alert alert-info rounded-3 mb-4">
                                            <strong class="d-block mb-2">Current Response</strong>
                                            <p class="mb-2">{{ $review->admin_response }}</p>
                                            <small class="text-muted">
                                                <i class="far fa-clock me-1"></i>
                                                Posted on {{ $review->response_date->format('M d, Y') }}
                                            </small>
                                        </div>
                                    @endif

                                    <div class="form-group mb-3">
                                        <label class="fw-semibold mb-1">
                                            {{ $review->admin_response ? 'Update Response' : 'Add Response' }}
                                        </label>
                                        <textarea name="admin_response" class="form-control rounded-2" rows="5"
                                            placeholder="Enter your response here...">{{ old('admin_response', $review->admin_response) }}</textarea>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-paper-plane me-2"></i>
                                        {{ $review->admin_response ? 'Update' : 'Save' }} Response
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Info -->
            @if ($review->report_count > 0)
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
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
