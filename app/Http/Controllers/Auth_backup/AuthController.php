<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    
    public function showLoginForm() {
        return view('login');
    }

    public function showRegisterForm() {
        return view('register');
    }

    /**
     * Handle a registration request for the application.
    */
    public function register(Request $request) {

        Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'user_type' => ['required', 'regex:(siswa|guru)']
        ])->validate();

        $newUser = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
        ]);

        event(new Registered($newUser));

        $this->guard()->login($newUser);

        if ($response = $this->registered($request, $newUser)) {
            return $response;
        }

        return $request->wantsJson() ? new Response('', 201) : redirect($this->redirectPath());
    }

    /**
     * Get the guard to be used.
     */
    protected function guard() {
        return Auth::guard();
    }

    // /**
    //  * The user has been registered.
    //  */
    // protected function registered(Request $request, $user) {
        
    // }
}
