<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
            // Check user role to redirect appropriately
            if (Auth::user()->role === 'admin') {
                // Redirect admins to the admin dashboard immediately
                return redirect()->intended('/admin/dashboard')->with('success', 'Admin logged in successfully.');
            }

            // Check if the user has accepted the user agreement
            if (!Auth::user()->user_agreement_accepted) {
                return redirect()->route('user-agreement'); // Redirect to user agreement if not accepted
            }

            // Redirect normal users to the books page
            return redirect()->intended('books')->with('success', 'Successfully logged in.');
        }

        // If login fails
        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
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

        // Create a new user with the default role of 'user'
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'country' => $request->country,
            'user_agreement_accepted' => false,
            'role' => 'user', // Default role for normal users
        ]);

        Auth::login($user);

        return redirect()->route('user-agreement')->with('success', 'Successfully signed up.');
    }
    
 
    public function update(Request $request)
    {
        // Validate the profile picture input
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Get the authenticated user's ID
        $userId = Auth::id();

        // Fetch the user's current profile picture path directly from DB
        $userProfilePicture = DB::table('users')->where('id', $userId)->value('profile_picture');

        if ($request->hasFile('profile_picture')) {
            // Delete the old profile picture if it exists in storage
            if ($userProfilePicture && Storage::disk('public')->exists($userProfilePicture)) {
                Storage::disk('public')->delete($userProfilePicture);
            }

            // Store the new profile picture
            $filePath = $request->file('profile_picture')->store('profile_pictures', 'public');

            // Update the user's profile picture path in the database
            DB::table('users')->where('id', $userId)->update([
                'profile_picture' => $filePath,
            ]);
        }

        return redirect()->back()->with('success', 'Profile picture updated successfully!');
    }

    // Handle logout
    public function logout()
    {
        Auth::logout();
        return redirect('login')->with('success', 'Successfully logged out.');
    }

    // Handle user agreement acceptance
    public function acceptAgreement(Request $request)
    {
        // Validate the incoming request to ensure the checkbox is checked
        $request->validate([
            'acceptAgreement' => 'required|accepted',
        ]);

        // Retrieve the authenticated user
        $user = Auth::user();

        if ($user) {
            // Update the user agreement status directly
            DB::table('users')
                ->where('id', $user->id)
                ->update(['user_agreement_accepted' => true]);
        }

        // Return a response to indicate success
        return response()->json(['success' => true]);
    }

    // Placeholder methods for other CRUD operations (if needed)
    
    public function index()
    {
        // Placeholder for index functionality
    }

    public function create()
    {
        // Placeholder for create functionality
    }

    public function store(Request $request)
    {
        // Placeholder for store functionality
    }

    public function show(Login $login)
    {
        // Placeholder for show functionality
    }

    public function edit(Login $login)
    {
        // Placeholder for edit functionality
    }

    public function destroy(Login $login)
    {
        // Placeholder for destroy functionality
    }
}
