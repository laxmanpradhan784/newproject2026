<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews.
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'product'])->latest();
        
        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        // Filter by rating
        if ($request->has('rating') && $request->rating != 'all') {
            $query->where('rating', $request->rating);
        }
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('comment', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('product', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $reviews = $query->paginate(20);
        
        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Show review details.
     */
    public function show($id)
    {
        $review = Review::with(['user', 'product', 'order'])->findOrFail($id);
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Update review status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,spam'
        ]);
        
        $review = Review::findOrFail($id);
        $oldStatus = $review->status;
        $review->status = $request->status;
        $review->save();
        
        return redirect()->back()->with('success', "Review status updated from {$oldStatus} to {$review->status}");
    }

    /**
     * Add admin response to review.
     */
    public function addResponse(Request $request, $id)
    {
        $request->validate([
            'admin_response' => 'required|string|min:5|max:1000'
        ]);
        
        $review = Review::findOrFail($id);
        $review->admin_response = $request->admin_response;
        $review->response_date = now();
        $review->save();
        
        return redirect()->back()->with('success', 'Response added successfully');
    }

    /**
     * Delete a review.
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        
        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully');
    }

    /**
     * Bulk actions.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete,mark_spam',
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,id'
        ]);
        
        $count = 0;
        
        switch ($request->action) {
            case 'approve':
                Review::whereIn('id', $request->review_ids)->update(['status' => 'approved']);
                $count = count($request->review_ids);
                break;
                
            case 'reject':
                Review::whereIn('id', $request->review_ids)->update(['status' => 'rejected']);
                $count = count($request->review_ids);
                break;
                
            case 'mark_spam':
                Review::whereIn('id', $request->review_ids)->update(['status' => 'spam']);
                $count = count($request->review_ids);
                break;
                
            case 'delete':
                Review::whereIn('id', $request->review_ids)->delete();
                $count = count($request->review_ids);
                break;
        }
        
        return redirect()->back()->with('success', "{$count} reviews processed successfully");
    }
}