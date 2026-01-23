<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    // Show all categories
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('admin.categories', compact('categories'));
    }
}
