@extends('layouts.app')

@section('title', 'My Reviews')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Review Stats</h6>
                    <div class="text-center">
                        <h3 class="text-primary">{{ $reviews->total() }}</h3>
                        <p class="text-muted small mb-0">Total Reviews</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">My Reviews</h5>
                </div>
                
                <div class="card-body">
                    @forelse($reviews as $review)
                        <div class="review-item mb-4 pb-4 border-bottom">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-bold mb-1">
                                        <a href="{{ route('product.show', $review->product_id) }}" class="text-decoration-none">
                                            {{ $review->title }}
                                        </a>
                                    </h6>
                                    <div class="d-flex align-items-center">
                                        <div class="rating-stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star text-warning fa-sm"></i>
                                                @else
                                                    <i class="far fa-star text-warning fa-sm"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="badge ms-2 {{ $review->status == 'approved' ? 'bg-success' : ($review->status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                            {{ ucfirst($review->status) }}
                                        </span>
                                    </div>
                                </div>
                                <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                            </div>
                            
                            <p class="mb-2">{{ $review->comment }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">
                                    Product: {{ $review->product->name }}
                                </small>
                                
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $review->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $review->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Delete Review</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete your review?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                            <h5>No reviews yet</h5>
                            <p class="text-muted mb-4">You haven't written any reviews yet.</p>
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-bag me-2"></i> Browse Products
                            </a>
                        </div>
                    @endforelse
                    
                    @if($reviews->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $reviews->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection