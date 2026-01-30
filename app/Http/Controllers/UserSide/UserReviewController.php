<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserReviewController extends Controller
{
    /**
     * Show the form for creating a new review
     */
    public function create($productId)
    {
        $product = Product::findOrFail($productId);
        
        // Check if user has already reviewed this product
        $existingReview = Review::where('product_id', $productId)
            ->where('user_id', Auth::id())
            ->first();
            
        if ($existingReview) {
            return redirect()->route('reviews.edit', $existingReview->id);
        }
        
        return view('reviews.create', compact('product'));
    }

    /**
     * Store a newly created review
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string|min:10|max:2000',
        ]);

        // Check if user has already reviewed this product
        $existingReview = Review::where('product_id', $request->product_id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'You have already reviewed this product.');
        }

        // Check if user purchased this product
        $hasPurchased = OrderItem::whereHas('order', function($query) {
            $query->where('user_id', Auth::id())
                ->whereIn('status', ['delivered', 'completed']);
        })
        ->where('product_id', $request->product_id)
        ->exists();

        // Create review
        Review::create([
            'product_id' => $request->product_id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'is_verified_purchase' => $hasPurchased,
            'status' => 'pending'
        ]);

        return redirect()->route('product.show', $request->product_id)
            ->with('success', 'Review submitted successfully! It will appear after approval.');
    }

    /**
     * Show the form for editing a review
     */
    public function edit($id)
    {
        $review = Review::with('product')->findOrFail($id);
        
        // Check if user owns the review
        if ($review->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'You can only edit your own reviews.');
        }

        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified review
     */
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        
        // Check if user owns the review
        if ($review->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'You can only edit your own reviews.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string|min:10|max:2000',
        ]);

        $review->update([
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'status' => 'pending' // Reset to pending for admin approval
        ]);

        return redirect()->route('product.show', $review->product_id)
            ->with('success', 'Review updated successfully! It will appear after approval.');
    }

    /**
     * Remove the specified review
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        
        // Check if user owns the review
        if ($review->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'You can only delete your own reviews.');
        }

        $productId = $review->product_id;
        $review->delete();

        return redirect()->route('product.show', $productId)
            ->with('success', 'Review deleted successfully.');
    }

    /**
     * Vote on a review (helpful/not helpful)
     */
    public function vote(Request $request)
    {
        $request->validate([
            'review_id' => 'required|exists:reviews,id',
            'type' => 'required|in:yes,no'
        ]);

        $review = Review::findOrFail($request->review_id);
        
        // Use session to prevent multiple votes
        $voteKey = 'review_vote_' . $review->id;
        
        if (session()->has($voteKey)) {
            return redirect()->back()->with('error', 'You have already voted on this review.');
        }

        if ($request->type === 'yes') {
            $review->increment('helpful_yes');
        } else {
            $review->increment('helpful_no');
        }

        // Store vote in session
        session([$voteKey => true]);

        return redirect()->back()->with('success', 'Thank you for your vote!');
    }

    /**
     * Show user's reviews
     */
    public function myReviews()
    {
        $reviews = Review::with('product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('reviews.my-reviews', compact('reviews'));
    }
}