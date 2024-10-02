<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Show login view with both login and signup forms.
     */
    public function showLogin()
    {
        return view('login');  // This view contains both login and signup forms
    }

    /**
     * Handle the login process.
     */
    public function login(Request $request)
    {
        // Validate login credentials
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log the user in using the provided credentials
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Check if the user has accepted the user agreement
            if (!Auth::user()->user_agreement_accepted) {
                return redirect()->route('user-agreement'); // Redirect to user agreement if not accepted
            }

            // Authentication passed, redirect to the intended page
            return redirect()->intended('books.index'); 
        }

        // If authentication fails, return back with an error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Handle the signup process (registration).
     */
    public function signup(Request $request)
    {
        // Validate signup data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // Email should be unique in the users table
            'password' => 'required|string|min:8|confirmed', // Password confirmation is required
        ]);

        // Create a new user in the users table
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),  // Hash the password before saving
            'user_agreement_accepted' => false, // Set agreement status to false initially
        ]);

        // Automatically log the user in after signup
        Auth::login($user);

        // Redirect to user agreement page
        return redirect()->route('user-agreement');
    }

    /**
     * Handle the user agreement acceptance.
     */
    public function acceptAgreement(Request $request)
    {
        // Ensure the user is authenticated
        $user = Auth::user();
        
        if ($user) {
            // Update the user agreement status
            $user->user_agreement_accepted = true;
            $user->save();
        }

        // Redirect to the books after accepting the agreement
        return redirect()->intended('books.index'); 
    }

    /**
     * Handle logout 
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function index()
    {
        // Placeholder for index functionality
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Placeholder for create functionality
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Placeholder for store functionality
    }

    /**
     * Display the specified resource.
     */
    public function show(Login $login)
    {
        // Placeholder for show functionality
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Login $login)
    {
        // Placeholder for edit functionality
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Login $login)
    {
        // Placeholder for update functionality
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Login $login)
    {
        // Placeholder for destroy functionality
    }
}
