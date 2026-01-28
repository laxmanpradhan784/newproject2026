<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderBy('id', 'desc')->get();
        $categories = Category::where('status', 'active')->orderBy('name')->get();
        return view('admin.products', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        $imgName = null;
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $imgName = 'product_' . time() . '_' . Str::random(10) . '.' . $img->getClientOriginalExtension();

            // Ensure directory exists
            $uploadPath = public_path('uploads/products');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $img->move($uploadPath, $imgName);
        }

        // Create product
        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $imgName,
            'status' => $request->status ?? 'active',
        ]);

        return back()->with('success', 'Product added successfully!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::find($request->id);

        // Handle new image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
                unlink(public_path('uploads/products/' . $product->image));
            }

            // Upload new image
            $img = $request->file('image');
            $imgName = 'product_' . time() . '_' . Str::random(10) . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('uploads/products'), $imgName);
            $product->image = $imgName;
        }

        // Update product data
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->save();

        return back()->with('success', 'Product updated successfully!');
    }

    public function updateStatus(Request $request, Product $product)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);

        $product->status = $request->status;
        $product->save();

        return redirect()->back()->with('success', 'Product status updated successfully!');
    }

    public function delete($id)
    {
        $product = Product::find($id);

        // Delete image file
        if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
            unlink(public_path('uploads/products/' . $product->image));
        }

        $product->delete();

        return back()->with('success', 'Product deleted successfully!');
    }
}
