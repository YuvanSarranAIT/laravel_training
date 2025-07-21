<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {

        try {
            // Log input data
            Log::info('User store request received', $request->all());

            $rules = [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $request->id,
                'phonenumber' => 'required|digits:10',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'zipcode' => 'required',
                'role' => 'required|integer',
                'gender' => 'required',
                'dob' => 'required|date',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

            User::updateOrCreate(
                ['id' => $request->id],
                $request->except(['_token'])
            );

            return response()->json(['success' => 'User saved successfully.']);

        } catch (\Exception $e) {
            // Log the error
            Log::error('Error saving user: ' . $e->getMessage());

            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function destroy($id)
    {
        try {
            User::findOrFail($id)->delete();
            return response()->json(['success' => 'User deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Delete failed!'], 500);
        }
    }
}
