@extends('admin.layouts.app')

@section('title', 'Product Reviews')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Product Reviews</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                    placeholder="Search">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="card-body border-bottom">
                        <form method="GET" action="{{ route('admin.reviews.index') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control" onchange="this.form.submit()">
                                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All
                                                Status</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="approved"
                                                {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected"
                                                {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            <option value="spam" {{ request('status') == 'spam' ? 'selected' : '' }}>Spam
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Rating</label>
                                        <select name="rating" class="form-control" onchange="this.form.submit()">
                                            <option value="all" {{ request('rating') == 'all' ? 'selected' : '' }}>All
                                                Ratings</option>
                                            <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>★★★★★
                                                (5)</option>
                                            <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>★★★★☆
                                                (4)</option>
                                            <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>★★★☆☆
                                                (3)</option>
                                            <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>★★☆☆☆
                                                (2)</option>
                                            <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>★☆☆☆☆
                                                (1)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Search</label>
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search reviews..." value="{{ request('search') }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Bulk Actions -->
                    <form method="POST" action="{{ route('admin.reviews.bulk') }}" id="bulkForm">
                        @csrf
                        <div class="card-header bg-light">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <select name="action" class="form-control form-control-sm d-inline-block w-auto"
                                        required>
                                        <option value="">Bulk Actions</option>
                                        <option value="approve">Approve</option>
                                        <option value="reject">Reject</option>
                                        <option value="mark_spam">Mark as Spam</option>
                                        <option value="delete">Delete</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary ml-2"
                                        onclick="return confirmBulkAction()">
                                        Apply
                                    </button>
                                </div>
                                <div class="col-md-6 text-right">
                                    <span class="text-muted">Showing {{ $reviews->firstItem() }} to
                                        {{ $reviews->lastItem() }} of {{ $reviews->total() }} reviews</span>
                                </div>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th width="50">
                                            <input type="checkbox" id="selectAll">
                                        </th>
                                        <th width="80">ID</th>
                                        <th>Product & Review</th>
                                        <th>Customer</th>
                                        <th width="100">Rating</th>
                                        <th width="120">Status</th>
                                        <th width="150">Date</th>
                                        <th width="120">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($reviews as $review)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="review_ids[]" value="{{ $review->id }}"
                                                    class="review-checkbox">
                                            </td>
                                            <td>{{ $review->id }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    @if ($review->product->image)
                                                        <img src="{{ asset('storage/' . $review->product->image) }}"
                                                            alt="{{ $review->product->name }}" width="40"
                                                            height="40" class="mr-2 rounded">
                                                    @endif
                                                    <div>
                                                        <a href="{{ route('product.show', $review->product->slug) }}"
                                                            target="_blank" class="font-weight-bold d-block">
                                                            {{ Str::limit($review->product->name, 40) }}
                                                        </a>
                                                        @if ($review->title)
                                                            <small class="text-dark">{{ $review->title }}</small><br>
                                                        @endif
                                                        <small
                                                            class="text-muted">{{ Str::limit($review->comment, 80) }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <span class="font-weight-bold">{{ $review->user->name }}</span><br>
                                                    <small class="text-muted">{{ $review->user->email }}</small>
                                                    @if ($review->is_verified_purchase)
                                                        <span class="badge badge-success ml-1">Verified</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="rating-stars">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i
                                                            class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-light' }}"></i>
                                                    @endfor
                                                    <br>
                                                    <small class="text-muted">({{ $review->rating }}/5)</small>
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $review->status == 'approved' ? 'success' : ($review->status == 'pending' ? 'warning' : ($review->status == 'rejected' ? 'danger' : 'secondary')) }}">
                                                    {{ ucfirst($review->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $review->created_at->format('M d, Y') }}<br>
                                                <small
                                                    class="text-muted">{{ $review->created_at->format('h:i A') }}</small>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.reviews.show', $review->id) }}"
                                                        class="btn btn-sm btn-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button"
                                                        class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split"
                                                        data-toggle="dropdown">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        @if ($review->status != 'approved')
                                                            <a href="#"
                                                                onclick="updateStatus({{ $review->id }}, 'approved')"
                                                                class="dropdown-item">
                                                                <i class="fas fa-check text-success mr-1"></i> Approve
                                                            </a>
                                                        @endif
                                                        @if ($review->status != 'rejected')
                                                            <a href="#"
                                                                onclick="updateStatus({{ $review->id }}, 'rejected')"
                                                                class="dropdown-item">
                                                                <i class="fas fa-times text-danger mr-1"></i> Reject
                                                            </a>
                                                        @endif
                                                        @if ($review->status != 'spam')
                                                            <a href="#"
                                                                onclick="updateStatus({{ $review->id }}, 'spam')"
                                                                class="dropdown-item">
                                                                <i class="fas fa-ban text-secondary mr-1"></i> Mark as Spam
                                                            </a>
                                                        @endif
                                                        <div class="dropdown-divider"></div>
                                                        <a href="#" onclick="deleteReview({{ $review->id }})"
                                                            class="dropdown-item text-danger">
                                                            <i class="fas fa-trash mr-1"></i> Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <i class="fas fa-comment-slash fa-2x text-muted mb-2"></i>
                                                <p class="text-muted">No reviews found.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer clearfix">
                            {{ $reviews->links() }}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <form id="statusForm" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
        <input type="hidden" name="status" id="statusInput">
    </form>

    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('scripts')
    <script>
        // Select All Checkboxes
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.review-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Bulk Action Confirmation
        function confirmBulkAction() {
            const selected = document.querySelectorAll('.review-checkbox:checked');
            const action = document.querySelector('select[name="action"]').value;

            if (selected.length === 0) {
                alert('Please select at least one review.');
                return false;
            }

            if (!action) {
                alert('Please select an action.');
                return false;
            }

            return confirm(`Are you sure you want to ${action} ${selected.length} review(s)?`);
        }

        // Update Single Review Status
        function updateStatus(reviewId, status) {
            if (confirm(`Are you sure you want to change status to ${status}?`)) {
                const form = document.getElementById('statusForm');
                form.action = `/admin/reviews/${reviewId}/status`;
                document.getElementById('statusInput').value = status;
                form.submit();
            }
        }

        // Delete Single Review
        function deleteReview(reviewId) {
            if (confirm('Are you sure you want to delete this review? This action cannot be undone.')) {
                const form = document.getElementById('deleteForm');
                form.action = `/admin/reviews/${reviewId}`;
                form.submit();
            }
        }

        // Initialize tooltips
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <style>
        .rating-stars {
            font-size: 14px;
            letter-spacing: 2px;
        }

        .rating-stars .fa-star {
            text-shadow: 0 0 1px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
