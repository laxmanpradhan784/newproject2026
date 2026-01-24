<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AUserController extends Controller
{
    public function index()
    {
        // Get all users and separate by role
        $users = User::orderByRaw("FIELD(role, 'admin', 'user')")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'role' => 'required|in:user,admin',
        ]);

        $user = User::find($request->id);

        // Prevent last admin from being demoted
        if ($user->role == 'admin' && $request->role == 'user') {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                return back()->with('error', 'Cannot demote the last admin user.');
            }
        }

        $user->role = $request->role;
        $user->save();

        // If the logged-in user changed their own role
        if ($user->id == auth()->id()) {
            // Refresh the authenticated user data in session
            Auth::login($user->fresh());
        }

        return back()->with('success', 'User role updated successfully!');
    }

    public function delete($id)
    {
        $user = User::find($id);

        // Prevent deleting the last admin
        if ($user->role == 'admin') {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                return back()->with('error', 'Cannot delete the last admin user.');
            }
        }

        // Prevent deleting yourself
        if ($user->id == auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully!');
    }


}
