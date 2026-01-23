<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Show admin profile
    public function profile()
    {
        // Get current logged-in admin
        $admin = Auth::user();

        // Check if user is admin
        if ($admin->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        return view('admin.profile', compact('admin'));
    }

    // Show all admins (optional)
    public function allAdmins()
    {
        $admins = User::where('role', 'admin')->get();
        return view('admin.all_admins', compact('admins'));
    }
}
