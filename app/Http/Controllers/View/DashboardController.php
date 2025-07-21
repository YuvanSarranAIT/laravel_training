<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $token = Session::get('jwt_token');
        if (!$token) return redirect()->route('login');

        $response = Http::withToken($token)->get(url('/api/items'));

        $items = $response->ok() ? $response->json() : [];

        return view('dashboard', ['items' => $items]);
    }
}
