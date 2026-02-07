<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    /**
     * Main manager page
     */
    public function manager(Request $request)
    {
        $products = Product::with(['images', 'category'])
            ->withCount('images')
            ->latest()
            ->get();
        
        $selectedProduct = null;
        
        if ($request->has('product_id')) {
            $selectedProduct = Product::with('images')
                ->find($request->get('product_id'));
        }
        
        return view('admin.product-image-manager', compact('products', 'selectedProduct'));
    }
    
    /**
     * Upload images for a product - FIXED VERSION
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);
        
        try {
            $product = Product::findOrFail($request->product_id);
            
            // Check current image count
            $currentCount = $product->images()->count();
            if ($currentCount >= 5) {
                return redirect()->route('admin.product.image.manager', ['product_id' => $product->id])
                    ->with('error', 'Maximum 5 images allowed per product.');
            }
            
            $uploadedCount = 0;
            $maxUpload = 5 - $currentCount;
            
            foreach ($request->file('images') as $index => $image) {
                if ($uploadedCount >= $maxUpload) break;
                
                // Generate unique filename
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                
                // Store image
                $image->storeAs('uploads/product-images', $filename);
                
                // Save to database - REMOVED 'order' field
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $filename
                    // No 'order' field - your table doesn't have it
                ]);
                
                $uploadedCount++;
            }
            
            return redirect()->route('admin.product.image.manager', ['product_id' => $product->id])
                ->with('success', $uploadedCount . ' image(s) uploaded successfully.');
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to upload images: ' . $e->getMessage());
        }
    }
    
    /**
     * Delete a product image
     */
    public function destroy(Request $request, $id)
    {
        try {
            // Find the image
            $image = ProductImage::findOrFail($id);
            $productId = $image->product_id;
            
            // Delete the file from storage
            $filePath = 'uploads/product-images/' . $image->image;
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
            
            // Delete from database
            $image->delete();
            
            return redirect()->route('admin.product.image.manager', ['product_id' => $productId])
                ->with('success', 'Image deleted successfully');
                
        } catch (\Exception $e) {
            \Log::error('Failed to delete product image: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Failed to delete image. Please try again.');
        }
    }
}