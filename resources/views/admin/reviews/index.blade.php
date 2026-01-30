@extends('admin.layouts.app')

@section('title', 'Product Reviews')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-primary ">Product Reviews</h3>
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

                    <div class="card-body table-responsive p-0" style="max-height: 600px; overflow-y: auto;">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <thead class="sticky-top" style="background-color: #f8f9fa; z-index: 10;">
                                    <tr>
                                        <th width="80" class="text-center align-middle">
                                            <span class="text-uppercase" style="font-size: 0.85rem;">Sr No</span>
                                        </th>
                                        <th class="align-middle">
                                            <span class="text-uppercase" style="font-size: 0.85rem;">Product &
                                                Review</span>
                                        </th>
                                        <th class="align-middle">
                                            <span class="text-uppercase" style="font-size: 0.85rem;">Customer</span>
                                        </th>
                                        <th width="100" class="text-center align-middle">
                                            <span class="text-uppercase" style="font-size: 0.85rem;">Rating</span>
                                        </th>
                                        <th width="120" class="text-center align-middle">
                                            <span class="text-uppercase" style="font-size: 0.85rem;">Status</span>
                                        </th>
                                        <th width="150" class="text-center align-middle">
                                            <span class="text-uppercase" style="font-size: 0.85rem;">Date</span>
                                        </th>
                                        <th width="120" class="text-center align-middle">
                                            <span class="text-uppercase" style="font-size: 0.85rem;">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                            </thead>
                            <tbody>
                                @forelse($reviews as $review)
                                    <tr>
                                        <td class="ps-4 py-3 align-middle">
                                            <div class="d-flex align-items-center gap-2">
                                                <span
                                                    class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-3 py-1">
                                                    {{ $loop->iteration }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-start gap-3">

                                                <!-- Product Image -->
                                                @if ($review->product->image)
                                                    <img src="{{ asset('uploads/products/' . $review->product->image) }}"
                                                        alt="{{ $review->product->name }}" width="45" height="45"
                                                        class="rounded-2 border" style="object-fit: cover;">
                                                @else
                                                    <div class="bg-light text-center rounded-2 border d-flex align-items-center justify-content-center"
                                                        style="width: 45px; height: 45px;">
                                                        <i class="fas fa-box text-muted fa-sm"></i>
                                                    </div>
                                                @endif

                                                <!-- Product Info -->
                                                <div class="flex-grow-1">
                                                    <a href="{{ route('product.show', $review->product->id) }}"
                                                        target="_blank"
                                                        class="fw-semibold text-dark text-decoration-none d-block mb-1"
                                                        title="{{ $review->product->name }}">
                                                        {{ Str::limit($review->product->name, 40) }}
                                                    </a>

                                                    @if ($review->title)
                                                        <small class="d-block text-dark mb-1" title="{{ $review->title }}">
                                                            “{{ Str::limit($review->title, 60) }}”
                                                        </small>
                                                    @endif

                                                    <small class="text-muted d-block" title="{{ $review->comment }}">
                                                        {{ Str::limit($review->comment, 60) }}
                                                    </small>
                                                </div>

                                            </div>
                                        </td>

                                        <td class="align-middle">
                                            <div class="d-flex flex-column gap-2">

                                                <!-- Name + Avatar -->
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center fw-semibold text-secondary"
                                                        style="width: 32px; height: 32px;">
                                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                                    </div>

                                                    <span class="fw-semibold text-dark" style="font-size: 0.95rem;">
                                                        {{ $review->user->name }}
                                                    </span>
                                                </div>

                                                <!-- Email -->
                                                <small class="text-muted d-flex align-items-center">
                                                    <i class="fas fa-envelope fa-xs me-1"></i>
                                                    {{ Str::limit($review->user->email, 25) }}
                                                </small>

                                                <!-- Verified Badge -->
                                                @if ($review->is_verified_purchase)
                                                    <span
                                                        class="badge bg-success-subtle text-success d-inline-flex align-items-center w-fit"
                                                        style="font-size: 0.75rem;">
                                                        <i class="fas fa-check-circle fa-xs me-1"></i>
                                                        Verified Purchase
                                                    </span>
                                                @endif

                                                <!-- Review Count -->
                                                <small class="text-muted d-flex align-items-center">
                                                    <i class="fas fa-star fa-xs text-warning me-1"></i>
                                                    {{ $review->user->reviews->count() ?? 0 }} reviews
                                                </small>

                                            </div>
                                        </td>

                                        <td class="text-center align-middle">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <!-- Stars -->
                                                <div class="mb-1">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $review->rating)
                                                            <i class="fas fa-star text-warning"
                                                                style="font-size: 1rem;"></i>
                                                        @else
                                                            <i class="far fa-star text-light"
                                                                style="font-size: 1rem;"></i>
                                                        @endif
                                                    @endfor
                                                </div>

                                                <!-- Rating Number -->
                                                <div class="rating-number">
                                                    <span class="badge badge-light border font-weight-medium"
                                                        style="font-size: 0.85rem; min-width: 40px; color:#4a5568">
                                                        {{ $review->rating }}/5
                                                    </span>
                                                </div>

                                                <!-- Rating Label -->
                                                <div class="rating-label mt-1">
                                                    @php
                                                        $ratingLabels = [
                                                            1 => 'Poor',
                                                            2 => 'Fair',
                                                            3 => 'Good',
                                                            4 => 'Very Good',
                                                            5 => 'Excellent',
                                                        ];
                                                    @endphp
                                                    <small class="text-muted" style="font-size: 0.8rem;">
                                                        {{ $ratingLabels[$review->rating] ?? '' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="d-flex flex-column align-items-center">
                                                <!-- Status Badge -->
                                                @php
                                                    $statusConfig = [
                                                        'pending' => [
                                                            'class' => 'warning',
                                                            'icon' => 'clock',
                                                            'label' => 'Pending',
                                                        ],
                                                        'approved' => [
                                                            'class' => 'success',
                                                            'icon' => 'check-circle',
                                                            'label' => 'Approved',
                                                        ],
                                                        'rejected' => [
                                                            'class' => 'danger',
                                                            'icon' => 'times-circle',
                                                            'label' => 'Rejected',
                                                        ],
                                                        'spam' => [
                                                            'class' => 'secondary',
                                                            'icon' => 'ban',
                                                            'label' => 'Spam',
                                                        ],
                                                    ];
                                                    $config =
                                                        $statusConfig[$review->status] ?? $statusConfig['pending'];
                                                @endphp

                                                <span class="badge badge-pill badge-{{ $config['class'] }} px-3 py-2 mb-1"
                                                    style="font-size: 0.85rem; min-width: 100px; color:#4a5568">
                                                    <i class="fas fa-{{ $config['icon'] }} mr-1"></i>
                                                    {{ $config['label'] }}
                                                </span>

                                                <!-- Status Change Time (if applicable) -->
                                                @if ($review->status == 'approved' || $review->status == 'rejected')
                                                    <small class="text-muted" style="font-size: 0.75rem;">
                                                        {{ $review->updated_at->diffForHumans() }}
                                                    </small>
                                                @endif

                                                <!-- Pending since -->
                                                @if ($review->status == 'pending')
                                                    <small class="text-muted" style="font-size: 0.75rem;">
                                                        Waiting {{ $review->created_at->diffForHumans() }}
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="d-flex flex-column align-items-center">
                                                <!-- Date -->
                                                <div class="date-container mb-1">
                                                    <span class="font-weight-medium text-dark" style="font-size: 0.9rem;">
                                                        {{ $review->created_at->format('d M Y') }}
                                                    </span>
                                                </div>

                                                <!-- Time -->
                                                <div class="time-container mb-2">
                                                    <small class="text-muted" style="font-size: 0.8rem;">
                                                        <i class="far fa-clock mr-1"></i>
                                                        {{ $review->created_at->format('h:i A') }}
                                                    </small>
                                                </div>

                                                <!-- Time Ago -->
                                                <div class="time-ago-container">
                                                    <small class="badge badge-light border px-2 py-1"
                                                        style="font-size: 0.75rem; color:#4a5568">
                                                        {{ $review->created_at->diffForHumans() }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="d-flex flex-column align-items-center">
                                                <!-- View Button -->
                                                <a href="{{ route('admin.reviews.show', $review->id) }}"
                                                    class="btn btn-sm btn-outline-info border-end-1 rounded-start"
                                                    title="View Details" data-toggle="tooltip">
                                                    <i class="fas fa-eye"></i>
                                                </a>
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
