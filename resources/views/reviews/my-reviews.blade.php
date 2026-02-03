@extends('layouts.app')

@section('title', 'My Reviews')

@section('content')
    <div class="container mt-5 pt-5">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="h2 fw-bold text-dark mb-2">My Reviews</h1>
                <p class="text-muted mb-0">Manage and track all your product reviews in one place</p>
            </div>
            <div>
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="bi bi-bag me-2"></i>Browse Products
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center py-4">
                        <h3 class="fw-bold text-primary">{{ $reviews->count() }}</h3>
                        <p class="text-muted mb-0">Total Reviews</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center py-4">
                        <h3 class="fw-bold text-success">{{ $reviews->where('status', 'approved')->count() }}</h3>
                        <p class="text-muted mb-0">Approved</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center py-4">
                        <h3 class="fw-bold text-warning">{{ $reviews->where('status', 'pending')->count() }}</h3>
                        <p class="text-muted mb-0">Pending</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center py-4">
                        @php
                            $avgRating = $reviews->avg('rating') ?? 0;
                        @endphp
                        <h3 class="fw-bold text-info">{{ number_format($avgRating, 1) }}/5</h3>
                        <p class="text-muted mb-0">Average Rating</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Table -->
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-semibold mb-0">Review History</h5>
                    <div class="d-flex gap-2">
                        {{-- <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-filter me-1"></i>Filter
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}">All Reviews</a></li>
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'approved']) }}">Approved Only</a></li>
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}">Pending Only</a></li>
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'rejected']) }}">Rejected Only</a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-sort-down me-1"></i>Sort
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Newest First</a></li>
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}">Oldest First</a></li>
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'rating_high']) }}">Highest Rating</a></li>
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'rating_low']) }}">Lowest Rating</a></li>
                        </ul>
                    </div> --}}
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                @if ($reviews->count() > 0)
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4 pb-3 text-uppercase small fw-semibold text-secondary">Product</th>
                                    <th class="pb-3 text-uppercase small fw-semibold text-secondary">Review Details</th>
                                    <th class="text-center pb-3 text-uppercase small fw-semibold text-secondary">Rating</th>
                                    <th class="text-center pb-3 text-uppercase small fw-semibold text-secondary">Status</th>
                                    <th class="text-center pb-3 text-uppercase small fw-semibold text-secondary">Reviewed On
                                    </th>
                                    <th class="text-end pe-4 pb-3 text-uppercase small fw-semibold text-secondary">Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reviews as $review)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                @if ($review->product->image)
                                                    <img src="{{ asset('uploads/products/' . $review->product->image) }}"
                                                        alt="{{ $review->product->name }}" class="rounded me-3"
                                                        style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="rounded bg-light d-flex align-items-center justify-content-center me-3"
                                                        style="width: 50px; height: 50px;">
                                                        <i class="bi bi-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="fw-semibold mb-1">
                                                        {{ Str::limit($review->product->name, 30) }}</h6>
                                                    <small class="text-muted">SKU:
                                                        {{ $review->product->sku ?? 'N/A' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="fw-semibold mb-1">{{ Str::limit($review->title, 40) }}</h6>
                                            <p class="text-muted mb-0 small">{{ Str::limit($review->comment, 50) }}</p>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} 
                                                    {{ $i <= $review->rating ? 'text-warning' : 'text-light' }}"></i>
                                                @endfor
                                                <span class="ms-2 small fw-semibold">{{ $review->rating }}/5</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge rounded-pill py-2 px-3 fw-normal
                                            {{ $review->status == 'approved'
                                                ? 'bg-success bg-opacity-10 text-success'
                                                : ($review->status == 'pending'
                                                    ? 'bg-warning bg-opacity-10 text-warning'
                                                    : 'bg-danger bg-opacity-10 text-danger') }}">
                                                <i
                                                    class="bi bi-{{ $review->status == 'approved' ? 'check-circle' : ($review->status == 'pending' ? 'clock' : 'x-circle') }} me-1"></i>
                                                {{ ucfirst($review->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">{{ $review->created_at->format('d M') }}</span>
                                                <small class="text-muted">{{ $review->created_at->format('Y') }}</small>
                                            </div>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-sm btn-outline-info d-flex align-items-center gap-2"
                                                    data-bs-toggle="modal" data-bs-target="#viewModal{{ $review->id }}">
                                                    <i class="bi bi-eye"></i>
                                                    <span class="d-none d-md-inline">View</span>
                                                </button>
                                                <a href="{{ route('reviews.edit', $review->id) }}"
                                                    class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2">
                                                    <i class="bi bi-pencil"></i>
                                                    <span class="d-none d-md-inline">Edit</span>
                                                </a>
                                                <button
                                                    class="btn btn-sm btn-outline-danger d-flex align-items-center gap-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $review->id }}">
                                                    <i class="bi bi-trash"></i>
                                                    <span class="d-none d-md-inline">Delete</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($reviews->hasPages())
                        <div class="border-top">
                            <div class="d-flex justify-content-between align-items-center p-4">
                                <div class="text-muted small">
                                    Showing {{ $reviews->firstItem() }} to {{ $reviews->lastItem() }} of
                                    {{ $reviews->total() }} reviews
                                </div>
                                <div>
                                    {{ $reviews->withQueryString()->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-chat-square-text display-1 text-light"></i>
                        </div>
                        <h4 class="fw-semibold mb-3">No Reviews Yet</h4>
                        <p class="text-muted mb-4">You haven't reviewed any products. Share your thoughts to help other
                            shoppers!</p>
                        <a href="{{ route('home') }}" class="btn btn-primary px-4">
                            <i class="bi bi-bag me-2"></i>Start Shopping
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- View Modals -->
    @foreach ($reviews as $review)
        <!-- View Modal -->
        <div class="modal fade" id="viewModal{{ $review->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold">Review Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="row">
                            <div class="col-md-4 border-end">
                                <div class="text-center mb-4">
                                    @if ($review->product->image)
                                        <img src="{{ asset('uploads/products/' . $review->product->image) }}"
                                            alt="{{ $review->product->name }}" class="img-fluid rounded mb-3"
                                            style="max-height: 200px;">
                                    @endif
                                    <h6 class="fw-bold">{{ $review->product->name }}</h6>
                                    <div class="mb-3">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} 
                                        {{ $i <= $review->rating ? 'text-warning' : 'text-light' }} fs-5"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <h6 class="text-muted mb-2">REVIEW TITLE</h6>
                                    <h5 class="fw-bold">{{ $review->title }}</h5>
                                </div>
                                <div class="mb-4">
                                    <h6 class="text-muted mb-2">REVIEW COMMENT</h6>
                                    <p class="mb-0" style="line-height: 1.6;">{{ $review->comment }}</p>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <h6 class="text-muted mb-2">STATUS</h6>
                                        <span
                                            class="badge rounded-pill py-2 px-3 fw-normal
                                    {{ $review->status == 'approved'
                                        ? 'bg-success bg-opacity-10 text-success'
                                        : ($review->status == 'pending'
                                            ? 'bg-warning bg-opacity-10 text-warning'
                                            : 'bg-danger bg-opacity-10 text-danger') }}">
                                            {{ ucfirst($review->status) }}
                                        </span>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="text-muted mb-2">REVIEWED ON</h6>
                                        <p class="fw-semibold mb-0">{{ $review->created_at->format('F d, Y') }}</p>
                                        <small class="text-muted">{{ $review->created_at->format('h:i A') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-2"></i>Edit Review
                        </a>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal{{ $review->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold text-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>Delete Review
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        <div class="mb-4">
                            <i class="bi bi-trash display-4 text-danger opacity-50"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Are you sure?</h5>
                        <p class="text-muted mb-4">
                            This will permanently delete your review for
                            <span class="fw-semibold">"{{ Str::limit($review->product->name, 40) }}"</span>.
                            This action cannot be undone.
                        </p>
                        <div class="bg-light rounded p-3 mb-4 text-start">
                            <p class="mb-2 small text-muted">REVIEW PREVIEW:</p>
                            <p class="mb-1 fw-semibold">{{ Str::limit($review->title, 60) }}</p>
                            <p class="mb-0 small">{{ Str::limit($review->comment, 100) }}</p>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-2"></i>Delete Review
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@push('styles')
    <style>
        .table> :not(caption)>*>* {
            padding: 1rem 0.75rem;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(var(--bs-primary-rgb), 0.05);
        }

        .bi-star-fill,
        .bi-star {
            font-size: 1.1rem;
        }

        .modal-header {
            padding: 1.5rem 1.5rem 0.5rem;
        }

        .modal-footer {
            padding: 1rem 1.5rem 1.5rem;
        }

        .btn-group .btn {
            border-radius: 0.375rem !important;
            margin: 0 2px;
        }
    </style>
@endpush
