<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // Show login page - redirect if already logged in
    public function showLogin()
    {
        // Check if user is already logged in
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        // Check if user is already logged in
        if (Auth::check()) {
            return $this->redirectBasedOnRole()->with('info', 'You are already logged in.');
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return $this->redirectBasedOnRole();
        }

        return back()->withErrors([
            'email' => 'Invalid credentials'
        ]);
    }

    // Show register page - redirect if already logged in
    public function showRegister()
    {
        // Check if user is already logged in
        if (Auth::check()) {
            return $this->redirectBasedOnRole()->with('info', 'You are already logged in.');
        }

        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        // Check if user is already logged in
        if (Auth::check()) {
            return $this->redirectBasedOnRole()->with('info', 'You are already logged in.');
        }

        // Validation
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'nullable|string|max:20',
            'password'   => 'required|confirmed|min:6',
        ]);

        // Create user
        $user = User::create([
            'name'     => $request->first_name . ' ' . $request->last_name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => bcrypt($request->password),
            'role'     => 'user', // default role = user
        ]);

        // Auto-login after registration
        Auth::login($user);
        $request->session()->regenerate();

        return $this->redirectBasedOnRole()->with('success', 'Registration successful!');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    // Google OAuth redirect
    public function googleRedirect()
    {
        // Check if user is already logged in
        if (Auth::check()) {
            return $this->redirectBasedOnRole()->with('info', 'You are already logged in.');
        }

        return Socialite::driver('google')->redirect();
    }

    // Google OAuth callback
    public function googleCallback()
    {
        // Check if user is already logged in
        if (Auth::check()) {
            return $this->redirectBasedOnRole()->with('info', 'You are already logged in.');
        }

        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if (!$user) {
                $user = User::create([
                    'name'      => $googleUser->name,
                    'email'     => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password'  => bcrypt(rand(100000, 999999)),
                    'role'      => 'user', // Force user role only for Google login
                ]);
            } else {
                // Update google_id if logging in with email
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->id]);
                }
            }

            Auth::login($user);

            return $this->redirectBasedOnRole()->with('success', 'Logged in successfully with Google!');

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google login failed. Please try again.');
        }
    }

    /**
     * Redirect user based on their role
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectBasedOnRole()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('profile'); // For regular users
        }
    }
}