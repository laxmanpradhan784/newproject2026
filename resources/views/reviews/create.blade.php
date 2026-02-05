@extends('layouts.app')

@section('title', 'Write Review - ' . $product->name)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-4">
                    <div class="d-flex align-items-center">
                        @if($product->image)
                            <img src="{{ asset('uploads/products/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 style="width: 80px; height: 80px; object-fit: cover;" 
                                 class="rounded me-3">
                        @endif
                        <div>
                            <h5 class="mb-1">{{ $product->name }}</h5>
                            <p class="text-muted mb-0">Write your honest review about this product</p>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <!-- Rating -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Overall Rating *</label>
                            <div class="rating-input mb-3">
                                <select name="rating" class="form-select" required>
                                    <option value="">Select Rating</option>
                                    <option value="5">5 Stars - Excellent</option>
                                    <option value="4">4 Stars - Very Good</option>
                                    <option value="3">3 Stars - Good</option>
                                    <option value="2">2 Stars - Fair</option>
                                    <option value="1">1 Star - Poor</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Review Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Review Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" 
                                   value="{{ old('title') }}"
                                   placeholder="Summarize your experience" maxlength="255" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Review Comment -->
                        <div class="mb-3">
                            <label for="comment" class="form-label fw-bold">Your Review *</label>
                            <textarea class="form-control @error('comment') is-invalid @enderror" 
                                      id="comment" name="comment" rows="5" 
                                      placeholder="Share your experience with this product. What did you like or dislike?"
                                      required>{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Minimum 10 characters</div>
                        </div>
                        
                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Product
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-paper-plane me-2"></i>Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection