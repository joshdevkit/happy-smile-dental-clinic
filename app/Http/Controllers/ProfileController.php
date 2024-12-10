<?php

namespace App\Http\Controllers;

use App\Models\ClientSchedules;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        /**
         * @var App\Models\User
         */
        $user = Auth::user();

        $data = ClientSchedules::with(['service', 'schedule'])->where('user_id', Auth::user()->id)->get();
        if ($user->hasRole('Client')) {
            return view('auth.user-profile', compact('user', 'data'));
        } else {
            return view('auth.profile', compact('user'));
        }
    }


    public function update_password(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $userid = Auth::id();
        $user = User::find($userid);
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully!');
    }


    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'age' => 'nullable|integer|min:1|max:120',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:Male,Female',
            'occupation' => 'nullable|string|max:255',
            'civil_status' => 'required|string|in:Single,Married,Divorced,Widowed',
            'cellphone_no' => 'required|string|max:15',
        ]);

        $userid = Auth::id();
        $user = User::find($userid);
        $user->update([
            'first_name' => $validatedData['first_name'],
            'middle_name' => $validatedData['middle_name'],
            'last_name' => $validatedData['last_name'],
            'suffix' => $validatedData['suffix'],
            'email' => $validatedData['email'],
            'age' => $validatedData['age'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'gender' => $validatedData['gender'],
            'occupation' => $validatedData['occupation'],
            'civil_status' => $validatedData['civil_status'],
            'cellphone_no' => $validatedData['cellphone_no'],
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }


    public function updateAvatar(Request $request)
    {
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $user = User::find(auth()->id());

            if ($user->avatar && file_exists(public_path('avatar/' . $user->avatar))) {
                unlink(public_path('avatar/' . $user->avatar));
            }

            $avatar = $request->file('avatar');
            $fileName = time() . '_' . $avatar->getClientOriginalName();

            $avatar->move(public_path('avatar'), $fileName);

            $user->update(['avatar' => $fileName]);

            return redirect()->back()->with('success', 'Avatar has been Updated');
        }

        return redirect()->back()->with('error', 'Invalid avatar file');
    }
}
