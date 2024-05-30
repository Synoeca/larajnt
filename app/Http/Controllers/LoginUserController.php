<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginUserController extends Controller
{
    public function login(Request $request)
    {
        // Store the previous URL in the session
        $request->session()->put('url.intended', url()->previous());
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request -> validate ([
            'email' => 'required|email',
            'password' => 'required|min:8, string'
        ]);

        if (Auth::guard('web') -> attempt(['email'=>$request->email, 'password'=>$request->password])) {
            //return redirect()->intended(route('posts.index'));
            $request->session()->regenerate();
            return redirect()->intended($request->session()->get('url.intended', route('posts.index')));
        } else {
            return back() -> withErrors([
                'email' => 'The provided credentials do not match our records.'
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web') -> logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('posts.index');
    }
}
