<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class LoginController extends Controller
{
    const COMBINATION_NOT_FOUND = 'Your email and password combination could not be found in our system';
    const LOGGED_IN = 'user logged in successfully';
    const HTTP_CODE_OK = '200';
    const HTTP_CODE_ERROR = '500';
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($validator->validated())) {
            return response()->json([
                'status' => self::HTTP_CODE_OK,
                'message' => self::LOGGED_IN
            ]);
        }

        // convert to constants
        return response()->json([
            'status' => self::HTTP_CODE_ERROR,
            'message' => self::COMBINATION_NOT_FOUND
        ]);
    }
}
