<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('orders')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required', 'in:customer,moderator,admin'],
            'status' => ['required', 'in:active,inactive,pending,blocked'],
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        AuditLog::record('admin.user.created', "Admin created user {$user->email}", $user);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:customer,moderator,admin'],
            'status' => ['required', 'in:active,inactive,pending,blocked'],
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        $user->update($data);

        AuditLog::record('admin.user.updated', "Admin updated user {$user->email}", $user);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        AuditLog::record('admin.user.deleted', "Admin deleted user {$user->email}", $user);
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}
