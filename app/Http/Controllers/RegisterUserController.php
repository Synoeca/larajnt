<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterUserController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }
    
    public function store(Request $request)
    {
        $request -> validate([
            'name' => ['required', 'max:255', 'min:5', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed', Password::defaults()]
        ]);
        
        // create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request -> password)
        ]);

        Profile::create([
            'first_name' => $request->name,
            'last_name' => $request->name,
            'phone' => 123,
            'email' => 'jiwoo@jntcompany.com',
            'address1' => 'Roof Drive',
            'address2' => 'Jardine',
            'city' => 'Manhattan',
            'state' => 'KS',
            'zip' => 123
        ]);

        auth() -> login($user);
        return to_route('posts.index');
    }
}