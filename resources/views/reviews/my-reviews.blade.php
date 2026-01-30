@extends('layouts.app')

@section('title', 'My Reviews')

@section('content')
    <div class="container py-4">
        <div class="row g-4">
            <div class="col-lg-3 col-md-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-star fa-2x text-warning bg-warning-subtle p-3 rounded-circle"></i>
                        </div>
                        <h2 class="display-6 fw-bold text-primary">{{ $reviews->total() }}</h2>
                        <p class="text-muted mb-0">Total Reviews</p>
                        <div class="mt-3">
                            @php
                                $approved = $reviews->where('status', 'approved')->count();
                                $pending = $reviews->where('status', 'pending')->count();
                            @endphp
                            <div class="d-flex justify-content-between small">
                                <span class="text-success">
                                    <i class="fas fa-check-circle me-1"></i> {{ $approved }} Approved
                                </span>
                                <span class="text-warning">
                                    <i class="fas fa-clock me-1"></i> {{ $pending }} Pending
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">Quick Actions</h6>
                        <div class="d-grid gap-2">
                            <a href="{{ route('home') }}" class="btn btn-outline-primary">
                                <i class="fas fa-shopping-bag me-2"></i> Browse Products
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 fw-bold">My Reviews
                            </h4>
                            <div class="dropdown">
                                {{-- <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('reviews.my') }}">All Reviews</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('reviews.my') }}?status=approved">Approved Only</a></li>
                                <li><a class="dropdown-item" href="{{ route('reviews.my') }}?status=pending">Pending Only</a></li>
                            </ul> --}}
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        @forelse($reviews as $review)
                            <div class="review-item card mb-3 border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <span
                                                    class="badge rounded-pill {{ $review->status == 'approved' ? 'bg-success' : ($review->status == 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                                    {{ ucfirst($review->status) }}
                                                </span>
                                                <small class="text-muted">
                                                    <i
                                                        class="far fa-calendar me-1"></i>{{ $review->created_at->format('M d, Y') }}
                                                </small>
                                            </div>

                                            <h5 class="card-title fw-bold mb-2">
                                                <a href="{{ route('product.show', $review->product_id) }}"
                                                    class="text-decoration-none text-dark hover-primary">
                                                    {{ $review->title }}
                                                </a>
                                            </h5>

                                            <div class="rating-stars mb-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $review->rating)
                                                        <i class="fas fa-star text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-warning"></i>
                                                    @endif
                                                @endfor
                                                <span class="ms-2 text-muted small">({{ $review->rating }}/5)</span>
                                            </div>
                                        </div>
                                        <div class="dropdown ms-2">
                                            <button class="btn btn-light rounded-circle p-2 shadow-sm" type="button"
                                                data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('reviews.edit', $review->id) }}">
                                                        <i class="fas fa-edit me-2"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $review->id }}">
                                                        <i class="fas fa-trash me-2"></i> Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <p class="card-text mb-3">{{ $review->comment }}</p>

                                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle p-2 me-2">
                                                <i class="fas fa-box text-primary"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Product</small>
                                                <span class="fw-semibold">{{ $review->product->name }}</span>
                                            </div>
                                        </div>

                                        <a href="{{ route('product.show', $review->product_id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-external-link-alt me-1"></i> View Product
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $review->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title fw-bold">
                                                <i class="fas fa-exclamation-triangle text-danger me-2"></i>Confirm Delete
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body py-4">
                                            <div class="text-center mb-4">
                                                <i class="fas fa-trash-alt fa-3x text-danger opacity-50 mb-3"></i>
                                                <h5>Delete this review?</h5>
                                                <p class="text-muted">This action cannot be undone. Your review will be
                                                    permanently removed.</p>
                                            </div>
                                            <div class="bg-light p-3 rounded">
                                                <small class="text-muted">Review Preview:</small>
                                                <p class="mb-0 fst-italic">"{{ Str::limit($review->comment, 100) }}"</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash me-1"></i> Delete Review
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="fas fa-star fa-4x text-light bg-warning-subtle p-4 rounded-circle"></i>
                                </div>
                                <h3 class="fw-bold mb-3">No Reviews Yet</h3>
                                <p class="text-muted mb-4">You haven't written any reviews yet. Share your experience with
                                    products!</p>
                                <div class="d-grid gap-2 d-md-block">
                                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg px-4 me-2">
                                        <i class="fas fa-shopping-bag me-2"></i> Browse Products
                                    </a>
                                    <a href="{{ route('orders.index') }}" class="btn btn-outline-primary btn-lg px-4">
                                        <i class="fas fa-receipt me-2"></i> View Orders
                                    </a>
                                </div>
                            </div>
                        @endforelse

                        @if ($reviews->hasPages())
                            <nav class="mt-4">
                                {{ $reviews->links('pagination::bootstrap-5') }}
                            </nav>
                        @endif
                    </div>
                </div>

                @if ($reviews->count() > 0)
                    <div class="alert alert-info border-0 shadow-sm mt-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle fa-2x me-3"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Review Guidelines</h6>
                                <p class="small mb-0">Your reviews help other customers make better decisions. Keep them
                                    honest and helpful!</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .hover-primary:hover {
            color: #0d6efd !important;
            transition: color 0.2s ease;
        }

        .rating-stars i {
            font-size: 1.1rem;
        }
    </style>
@endsection
