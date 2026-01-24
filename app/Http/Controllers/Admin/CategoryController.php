<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('admin.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        $imgName = null;
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $imgName = 'category_' . time() . '_' . Str::random(10) . '.' . $img->getClientOriginalExtension();
            
            // Ensure directory exists
            $uploadPath = public_path('uploads/categories');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $img->move($uploadPath, $imgName);
        }

        // Create category
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'image' => $imgName,
            'status' => $request->status ?? 'active',
        ]);

        return back()->with('success', 'Category added successfully!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:categories,name,' . $request->id,
        ]);

        $category = Category::find($request->id);
        
        // Handle new image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image && file_exists(public_path('uploads/categories/' . $category->image))) {
                unlink(public_path('uploads/categories/' . $category->image));
            }
            
            // Upload new image
            $img = $request->file('image');
            $imgName = 'category_' . time() . '_' . Str::random(10) . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('uploads/categories'), $imgName);
            $category->image = $imgName;
        }

        // Update category data
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();

        return back()->with('success', 'Category updated successfully!');
    }

    public function delete($id)
    {
        $category = Category::find($id);
        
        // Delete image file
        if ($category->image && file_exists(public_path('uploads/categories/' . $category->image))) {
            unlink(public_path('uploads/categories/' . $category->image));
        }
        
        $category->delete();
        
        return back()->with('success', 'Category deleted successfully!');
    }
}