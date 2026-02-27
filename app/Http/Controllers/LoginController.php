<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login() 
    {
        return view('auth.login');
    }
    public function registration() 
    {
        return view('auth.registration');
    }

    public function store(Request $request) 
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|',
            'email' => 'required|email|unique:users|email:dns',
            'username' => 'required|string|min:3|max:255|unique:users',
            'password' => 'required|string|min:5',
            'role' => 'required'
        ]);
        User::create($validatedData);

        return redirect('/login')->with('success', 'Registrasi Akun Berhasil! Please Login');
        //dd($request->all());
        
     }

     public function authenticate(Request $request)
     {
        $credentials = $request->validate([
            'username' => 'required|string|min:3|max:255',
             'password' => 'required|string|min:5'
        ]);

        if (Auth::attempt($credentials)) {
           $request->session()->regenerate();

           return redirect()->intended('/dashboard');
        }

        return back()->with('error', 'Login Gagal!!');
     }
}
