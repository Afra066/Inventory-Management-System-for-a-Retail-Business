<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Only Admin can access this page.');
        }
        
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Only Admin can access this page.');
        }
        
        return view('users.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Only Admin can access this page.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:accountant,sales_staff', // Admin role removed
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Employee added successfully!');
    }

    public function edit(User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Only Admin can access this page.');
        }
        
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Only Admin can access this page.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:accountant,sales_staff', // Admin role removed
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:8|confirmed',
            ]);
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('users.index')
            ->with('success', 'Employee updated successfully!');
    }

    public function destroy(User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Only Admin can access this page.');
        }

        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete('');
        return redirect()->route('users.index')
            ->with('success', 'Employee deleted successfully!');
    }
}