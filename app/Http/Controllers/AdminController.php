<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Support\Facades\DB; // Import DB for querying sessions
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::all();
        $totalUsers = $users->count();
        $activeUserIds = $this->getActiveSessionCount();
        
        // Count of active sessions based on distinct active user IDs
        $activeSessions = count($activeUserIds);

        // Determine active status for each user
        $users->each(function ($user) use ($activeUserIds) {
            $user->isActive = in_array($user->id, $activeUserIds);
        });

        // Pass data to the view
        return view('dashboard', compact('users', 'totalUsers', 'activeSessions'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'active' => 'required|boolean',
        ]);

        $user = User::findOrFail($id);
        $user->username = $request->username;
        $user->email = $request->email;
        $user->active = $request->active;
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully');
    }

    private function getActiveSessionCount()
    {
        // Retrieve user IDs with active sessions
        return DB::table('sessions')
            ->distinct()
            ->pluck('user_id')
            ->toArray();
    }

}
