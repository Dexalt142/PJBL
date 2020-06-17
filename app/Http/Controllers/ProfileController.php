<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller {
    
    public function updateAccount(Request $request) {
        $user = auth()->user();
        $validated = $request->validate([
            'profile_picture' => ['nullable', 'sometimes', 'mimes:jpeg,jpg,png'],
            'email' => ['email', 'required', 'string'],
            'password' => ['nullable', 'string'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed']
        ]);
        
        if(isset($validated['profile_picture'])) {

        }

        if($validated['email'] != $user->email) {
            $emailCheck = User::where('email', $validated['email'])->first();
            if($emailCheck) {
                return redirect()->back()->withErrors(['email' => 'Email sudah digunakan.']);
            }
            
            $user->email = $validated['email'];
        }
        
        if($validated['new_password']) {
            if(empty($validated['password'])) {
                return redirect()->back()->withErrors(['password' => 'Masukkan password anda saat ini.']);
            }
            if(!Hash::check($validated['password'], $user->password)) {
                return redirect()->back()->withErrors(['password' => 'Password anda salah.']);
            }

            $user->password = Hash::make($validated['password']);
        }
        
        if($user->save()) {
            return redirect()->back();
        }
    }

}
