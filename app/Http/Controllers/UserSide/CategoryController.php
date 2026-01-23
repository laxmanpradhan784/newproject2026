<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Show all active categories on one page
     */
    public function allCategories()
    {
        $categories = Category::where('status', 'active')->get();
        return view('categories', compact('categories'));
    }
}
