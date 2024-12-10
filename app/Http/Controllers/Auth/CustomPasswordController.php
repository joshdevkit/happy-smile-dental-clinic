<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class CustomPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.passwords.email');
    }


    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $otp = rand(100000, 999999);

            session(['email' => $user->email]);
            session(['reset_otp' => $otp]);
            session(['otp_created_at' => now()]);

            Mail::to($user->email)->send(new ResetPasswordOtpMail($otp));

            return redirect()->route('verifyOtpForm');
        }

        return back()->withErrors(['email' => 'The provided email is not registered.']);
    }
    public function showOtpForm()
    {
        return view('auth.passwords.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $email = session('email');
        $storedOtp = session('reset_otp');
        $otpCreatedAt = session('otp_created_at');

        if ($storedOtp && $storedOtp == $request->otp) {
            if ($otpCreatedAt && now()->diffInMinutes($otpCreatedAt) <= 5) {
                return redirect()->route('resetPasswordForm')->with('email', $email);
            } else {
                return back()->withErrors(['otp' => 'The OTP has expired.']);
            }
        }

        return back()->withErrors(['otp' => 'The OTP is incorrect.']);
    }

    public function showResetPasswordForm()
    {
        $email = session('email');
        return view('auth.passwords.reset', compact('email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            session()->forget(['email', 'reset_otp', 'otp_created_at']);

            return redirect()->route('login')->with('success', 'Your password has been reset successfully.');
        }

        return back()->withErrors(['email' => 'User not found.']);
    }
}
