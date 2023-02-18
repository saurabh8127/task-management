<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|max:64',
        ]);
        if ($validated->fails()) {
            return response()->json(array(
                'data' => array(),
                'status' => false,
                'message' => 'Enter valid value',
            ), 400);
        } else {
            if (Auth::attempt($request->only('email', 'password'))) {

                $token = auth()->user()->createToken('Api token')->accessToken;

                return response()->json([
                    'token' => $token,
                    'data' => auth()->user(),
                    'status' => true,
                    'message' => 'Login, Welcome',
                ], 200);
            } else {
                return response()->json([
                    'data' => [],
                    'status' => false,
                    'message' => 'Your email is not verified!',
                ], 400);
            }
        }
    }
}
