<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'affiliation' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'author',
            'phone' => $validated['phone'],
            'affiliation' => $validated['affiliation'] ?? null,
        ]);

        // Send welcome email
        NotificationService::send('welcome_user', $user->email, [
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_role' => 'Author',
        ]);

        Auth::login($user);

        return redirect()->route('dashboard.index')->with('success', 'Registration successful! Welcome to SHARE IJ.');
    }
}