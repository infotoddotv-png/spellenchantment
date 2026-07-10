<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $existingGuest = User::where('email', $request->input('email'))->where('is_guest', true)->first();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'email', 'max:255',
                $existingGuest
                    ? 'unique:users,email,' . $existingGuest->id
                    : 'unique:users,email',
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // A guest record was auto-created for this email from a past checkout (no login
        // was ever possible on it — random password). Claim it instead of failing on the
        // unique-email constraint, so a real customer is never blocked from registering.
        if ($existingGuest) {
            $existingGuest->update([
                'name' => $data['name'],
                'password' => Hash::make($data['password']),
                'is_guest' => false,
            ]);
            $user = $existingGuest;
        } else {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'customer',
                'status' => 'active',
            ]);
        }

        Auth::login($user);

        AuditLog::record('auth.register', "New account registered ({$user->email})", $user);

        return redirect('/')->with('success', 'Welcome to Spell Enchantment!');
    }
}
