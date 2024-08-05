<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');
    
        if (Auth::attempt($credentials)) {
            // return redirect()->intended('/');
            return $this->sendLoginResponse($request);
        }
    
        return redirect()->route('login')->with('error','Username atau Password Salah');
    }
    
    protected function sendLoginResponse(Request $request)
    {
        $user = Auth::user()->username;
    
        $success = ["type" => "success", "text" => "Selamat Datang, $user"];
    
        return redirect('/')->with($success);
    }

    public function logout()
{
    Auth::logout();

    return redirect('/login');
}
}