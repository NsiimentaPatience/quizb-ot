<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Admin; // Import the Admin model
use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    // Show login view with both login and signup forms
    public function showLogin()
    {
        return view('login');  // This view contains both login and signup forms
    }

    // Handle the user login process
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',  // Accept either username or email
            'password' => 'required',
        ]);

        // Determine if the login field is an email or a username
        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Attempt to log the user in using either email or username
        if (Auth::attempt([$fieldType => $request->login, 'password' => $request->password])) {
            // Check if the user has accepted the user agreement
            if (!Auth::user()->user_agreement_accepted) {
                return redirect()->route('user-agreement'); // Redirect to user agreement if not accepted
            }

            return redirect()->intended('books')->with('success', 'Successfully logged in.');
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ]);
    }

    // Handle admin login process
    public function adminLogin(Request $request)
    {
        $request->validate([
            'admin_username' => 'required',
            'admin_password' => 'required',
        ]);

        // Attempt to log in the admin using the 'name' and 'password' columns
        if (Auth::guard('admin')->attempt(['name' => $request->admin_username, 'password' => $request->admin_password])) {
            return redirect()->intended('/admin/dashboard')->with('success', 'Admin logged in successfully.');
        }

        return back()->withErrors([
            'admin_username' => 'Admin credentials do not match our records.',
        ]);
    }

    // Handle the signup process (registration)
    public function signup(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'country' => 'required|string|max:255',
        ]);

        // Create a new user
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'country' => $request->country,
            'user_agreement_accepted' => false,
        ]);

        Auth::login($user);

        return redirect()->route('user-agreement')->with('success', 'Successfully signed up.');
    }

    // Handle logout
    public function logout()
    {
        Auth::logout();
        return redirect('login')->with('success', 'Successfully logged out.');
    }
}
