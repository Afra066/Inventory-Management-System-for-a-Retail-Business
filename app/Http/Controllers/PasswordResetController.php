<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    // Show forgot password form
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // Send reset link
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $email = $request->email;

        // Delete old tokens
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        // Generate token
        $token = Str::random(64);

        // Save token
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        // Redirect to reset form with token
        return redirect()->route('password.reset', ['token' => $token, 'email' => $email])
            ->with('success', 'Please reset your password.');
    }

    // Show reset password form
    public function showResetForm($token)
    {
        $email = request()->email;
        return view('auth.reset-password', compact('token', 'email'));
    }

    // Reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required'
        ]);

        // Check token
        $tokenRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$tokenRecord) {
            return back()->withErrors(['email' => 'Invalid or expired token.']);
        }

        // Check token expiry (1 hour)
        $createdAt = Carbon::parse($tokenRecord->created_at);
        if ($createdAt->diffInMinutes(Carbon::now()) > 60) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Token has expired. Please request a new link.']);
        }

        // FIXED: Using full namespace directly (no import needed)
        $user = \App\Models\User::where('email', $request->email)->first();
        
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
        } else {
            return back()->withErrors(['email' => 'User not found.']);
        }

        // Delete token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password has been reset successfully!');
    }
}