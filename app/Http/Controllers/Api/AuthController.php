<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AuthUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

// for sending emails
use App\Mail\SendReportMail;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
        public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = AuthUser::create([
            'name'     => $request->name,
            'email'    => $request->email,
            // 'role' => $request->role ?? 'user',
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['message' => 'User registered successfully.']);
    }

        public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json(['token' => $token]);
    }


    // This method is just an example of how to send an email with a file attachment
    // You can call this method from any route or controller where you need to send the email

    public function sendReport()
{
    $name = 'yuvan sarran';
    $filePath = storage_path('app/reports/monthly.pdf'); // Path to the file

    Mail::to('yuvansarran1001@gmail.com')->send(new SendReportMail($name, $filePath));

    return response()->json(['message' => 'Email sent successfully!']);
}
}
