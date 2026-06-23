<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('/pages/dashboard');
        }

        return view("autentikasi.login");
    }

    public function post_login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials['username'] = trim($credentials['username']);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()
                ->intended('/pages/dashboard')
                ->with('success', 'Anda Berhasil Login');
        }

        return back()
            ->withInput($request->only('username'))
            ->with('error', 'Username atau password tidak sesuai.');
    }
}
