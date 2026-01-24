<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    // Change admin password
    public function changePassword(Request $request)
    {
        // Only allow admin users
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Logout other devices (optional)
        // Auth::logoutOtherDevices($request->new_password);

        return back()->with('success', 'Password changed successfully!');
    }

    // Update admin profile information
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }
}