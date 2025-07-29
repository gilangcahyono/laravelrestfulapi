<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register()
    {
        return request()->all();
    }

    public function login(Request $request)
    {
        return $request->all();
    }
}
