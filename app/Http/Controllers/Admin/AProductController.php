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
        $categories = Category::where('status', 'active')->get();
        return view('admin.products', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'image' => 'image'
        ]);

        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return back()->with('success', 'Product Added');
    }

    public function update(Request $request)
    {
        $product = Product::find($request->id);

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return back()->with('success', 'Product Updated');
    }

    public function delete($id)
    {
        Product::find($id)->delete();
        return back()->with('success', 'Product Deleted');
    }
}
