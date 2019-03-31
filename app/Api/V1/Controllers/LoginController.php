<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;
use App\Api\V1\Responses\Response;

class LoginController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return Response::get('Bearer ' . $token);
        }

        return Response::error('Email and/or password is incorrect!', 401);
    }

    /**
     * @return Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}
