<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Show logged-in user profile (only for users, not admin)
     */
    public function profile()
    {
        $user = Auth::user();

        // Check if logged-in user is an admin
        if (!$user || $user->role === 'admin') {
            return redirect()->route('home')->with('error', 'Admins cannot access user profile.');
        }

        // Pass the logged-in user to the view
        return view('profile', compact('user'));
    }
}
