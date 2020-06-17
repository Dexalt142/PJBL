<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller {
    
    public function updateAccount(Request $request) {
        $user = auth()->user();
        $validated = $request->validate([
            'profile_picture' => ['nullable', 'sometimes', 'mimes:jpeg,jpg,png'],
            'email' => ['email', 'required', 'string'],
            'password' => ['nullable', 'string'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed']
        ]);
        
        if($request->file('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = Str::orderedUuid()->toString().'.'.$file->extension();
            $path = Storage::disk('profile_pictures')->putFileAs('', $file, $filename);

            if($user->profile_picture) {
                Storage::disk('profile_pictures')->delete($user->profile_picture);    
            }
            $user->profile_picture = $filename;
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
