<?php

namespace App\Http\Controllers;

class LogoutController extends Controller
{
    public static function logout()
    {
         auth()->logout();
    }
}
