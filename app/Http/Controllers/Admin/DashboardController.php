<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Contact;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {

        // Count created in the last 30 days
        $totalCategories = Category::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $totalProducts   = Product::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $totalSliders    = Slider::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $totalContacts   = Contact::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $totalUsers      = User::where('role', 'user')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->count();

        // Pass to view - CORRECTED
        return view('admin.dashboard', compact(
            'totalCategories',
            'totalProducts',
            'totalSliders',
            'totalContacts',
            'totalUsers'
        ));
    }
}
