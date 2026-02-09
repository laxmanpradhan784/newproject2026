<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Show logged-in user profile
     */
    public function profile()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to view your profile.');
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('info', 'Admins should use the admin dashboard.');
        }

        return view('profile', compact('user'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[\d\s\-\+\(\)]+$/'],
        ], [
            'phone.regex' => 'Please enter a valid phone number.',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!',
                'user' => $user
            ]);
        }

        return redirect()->route('profile')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update user avatar
     */
    public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validator = Validator::make($request->all(), [
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
        ], [
            'avatar.max' => 'The profile image should not exceed 2MB.',
            'avatar.mimes' => 'Only JPG, PNG, GIF and WebP images are allowed.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Delete old profile image if exists
        if ($user->profile_image && file_exists(public_path('uploads/profile-images/' . $user->profile_image))) {
            unlink(public_path('uploads/profile-images/' . $user->profile_image));
        }

        // Store new profile image in public folder
        $image = $request->file('avatar');
        $imageName = 'profile_' . $user->id . '_' . time() . '.' . $image->getClientOriginalExtension();

        // Store in public/uploads/profile-images directory
        $image->move(public_path('uploads/profile-images'), $imageName);

        // Update user record
        $user->profile_image = $imageName;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile image updated successfully!',
            'profile_image' => asset('uploads/profile-images/' . $imageName),
            'initials' => strtoupper(substr($user->name, 0, 1))
        ]);
    }

    /**
     * Remove user profile image
     */
    public function removeAvatar()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if ($user->profile_image) {
            // Delete from public folder
            $filePath = public_path('uploads/profile-images/' . $user->profile_image);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Update database
            $user->profile_image = null;
            $user->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile image removed successfully!',
            'initials' => strtoupper(substr($user->name, 0, 1))
        ]);
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed', 'different:current_password'],
        ], [
            'new_password.min' => 'Password must be at least 6 characters.',
            'new_password.different' => 'New password must be different from current password.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Current password is incorrect.'])
                ->withInput();
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        // Optional: Logout other devices
        // Auth::logoutOtherDevices($request->new_password);

        return redirect()->route('profile')
            ->with('success', 'Password updated successfully!');
    }

    /**
     * Resend verification email
     */
    public function resendVerificationEmail(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('profile')
                ->with('info', 'Email is already verified.');
        }

        $user->sendEmailVerificationNotification();

        return redirect()->route('profile')
            ->with('success', 'Verification email sent! Please check your inbox.');
    }

    /**
     * Delete user account
     */
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'password' => ['required', 'string'],
        ]);

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withErrors(['password' => 'Incorrect password.'])
                ->withInput();
        }

        // Delete avatar if exists
        if ($user->avatar) {
            Storage::delete('public/avatars/' . $user->avatar);
        }

        // Delete user
        $user->delete();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('info', 'Your account has been deleted successfully.');
    }
}
