<?php

namespace App\Http\Controllers;

use App\Models\TradeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'min:3'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255', 'min:10'],
        ]);

        if ($validator->fails())  {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ]);
        }

        $user = User::create($validator->validated());

        if ($user) {
            auth()->login($user);
            return response()->json([
                'status' => '200',
                'message' => 'user created successfully'
            ]);
        }

        return response()->json([
            'status' => '500',
            'message' => 'Something went wrong'
        ]);
    }
}
