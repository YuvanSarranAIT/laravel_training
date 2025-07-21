<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthViewController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $response = Http::post(url('/api/login'), [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->status() === 200) {
            $data = $response->json();
            Session::put('jwt_token', $data['token']);
            return redirect()->route('dashboard');
        }

        return redirect()->back()->withErrors(['message' => 'Invalid credentials']);
    }

    public function register(Request $request)
    {
        $response = Http::post(url('/api/register'), [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'user',
        ]);

        if ($response->status() === 200 || $response->status() === 201) {
            return redirect()->route('login')->with('success', 'Registered successfully. Please login.');
        }

        return redirect()->back()->withErrors($response->json());
    }

    public function logout()
    {
        Session::forget('jwt_token');
        return redirect()->route('login');
    }
}
