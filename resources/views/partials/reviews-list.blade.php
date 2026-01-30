@foreach($reviews as $review)
<div class="review-item mb-4 pb-4 border-bottom" data-rating="{{ $review->rating }}">
    <div class="d-flex justify-content-between align-items-start mb-2">
        <div>
            <h6 class="fw-bold mb-1">{{ $review->title }}</h6>
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
                @if($review->is_verified_purchase)
                    <span class="badge bg-success bg-opacity-10 text-success ms-2">
                        <i class="fas fa-check-circle"></i> Verified Purchase
                    </span>
                @endif
            </div>
        </div>
        <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
    </div>
    
    <div class="d-flex align-items-center mb-2">
        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2"
             style="width: 32px; height: 32px;">
            <i class="fas fa-user text-muted"></i>
        </div>
        <div>
            <small class="fw-bold">{{ $review->user->name ?? 'Anonymous' }}</small>
        </div>
    </div>
    
    <p class="mb-2">{{ $review->comment }}</p>
    
    <!-- Helpful Votes -->
    <div class="d-flex align-items-center mt-3">
        <small class="text-muted me-3">Was this review helpful?</small>
        <button class="btn btn-sm btn-outline-success me-1 helpful-btn" 
                data-review-id="{{ $review->id }}" data-type="yes">
            <i class="fas fa-thumbs-up"></i> Yes ({{ $review->helpful_yes }})
        </button>
        <button class="btn btn-sm btn-outline-danger helpful-btn" 
                data-review-id="{{ $review->id }}" data-type="no">
            <i class="fas fa-thumbs-down"></i> No ({{ $review->helpful_no }})
        </button>
        
        @if(Auth::check())
            <button class="btn btn-sm btn-outline-secondary ms-2 report-btn" 
                    data-bs-toggle="modal" data-bs-target="#reportModal"
                    data-review-id="{{ $review->id }}">
                <i class="fas fa-flag"></i> Report
            </button>
        @endif
    </div>
    
    <!-- Admin Response -->
    @if($review->admin_response)
        <div class="admin-response mt-3 p-3 bg-light rounded">
            <div class="d-flex align-items-center mb-2">
                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-2"
                     style="width: 28px; height: 28px;">
                    <i class="fas fa-user-tie text-white fa-sm"></i>
                </div>
                <small class="fw-bold">Admin Response</small>
                <small class="text-muted ms-2">{{ $review->response_date->format('M d, Y') }}</small>
            </div>
            <p class="mb-0 small">{{ $review->admin_response }}</p>
        </div>
    @endif
</div>
@endforeach

@if($reviews->hasMorePages())
<div class="text-center mt-4">
    <button class="btn btn-outline-primary load-more-reviews" 
            data-page="{{ $reviews->currentPage() + 1 }}"
            data-product-id="{{ $reviews->first()->product_id ?? '' }}">
        <i class="fas fa-spinner fa-spin d-none me-2"></i>
        Load More Reviews
    </button>
</div>
@endif