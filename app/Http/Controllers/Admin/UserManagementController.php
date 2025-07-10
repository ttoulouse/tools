<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User; // Laravel 5.3 default User model is in App\User
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    // List all users
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Show the form to create a new user
    public function create()
    {
        return view('admin.users.create');
    }

    // Store a newly created user

public function store(Request $request)
{
    // Validate the form data
    $this->validate($request, [
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $user = new User();
    $user->name     = $request->input('name');
    $user->email    = $request->input('email');
    $user->password = bcrypt($request->input('password'));

    // Only allow super admins to set a new user as admin
    if (auth()->user()->is_super_admin && $request->has('is_admin')) {
        $user->is_admin = true;
    } else {
        $user->is_admin = false;
    }

    // No need to manually set created_at; Eloquent does that automatically.
    $user->save();

    return redirect()->route('admin.users.index')
                     ->with('success', 'User created successfully.');
}


    // Delete a user
public function destroy($id)
{
    $user = User::findOrFail($id);

    // If the user to be deleted is an admin, only allow deletion if the current user is super admin.
    if ($user->is_admin && !auth()->user()->is_super_admin) {
        return redirect()->back()->with('error', 'Only super admins can delete admin accounts.');
    }

    $user->delete();

    return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
}

public function edit($id)
{
    // Find the user by ID or throw a 404 if not found
    $user = \App\User::findOrFail($id);
    
    // Return the edit view with the user data
    return view('admin.users.edit', compact('user'));
}

public function update(Request $request, $id)
{
    $user = \App\User::findOrFail($id);

    // Validate the incoming data. Note: for email, we exclude the current user's email.
    $this->validate($request, [
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email,' . $user->id,
        // Password is optional, but if provided it must be confirmed and at least 6 characters long.
        'password' => 'nullable|string|min:6|confirmed',
    ]);

    // Update user information
    $user->name  = $request->input('name');
    $user->email = $request->input('email');

    // Update password only if a new one is provided.
    if (!empty($request->input('password'))) {
        $user->password = bcrypt($request->input('password'));
    }

    // Allow only super admins to update the admin flag
    if (auth()->user()->is_super_admin) {
        $user->is_admin = $request->has('is_admin');
    }

    $user->save();

    return redirect()->route('admin.users.index')
                     ->with('success', 'User updated successfully.');
}
}

