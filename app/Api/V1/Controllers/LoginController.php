<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Responses\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class LoginController extends Controller
{
    /**
     * @param Request $request
     * @param JWTAuth $jwtAuth
     * @return JsonResponse
     */
    public function login(Request $request, JWTAuth $jwtAuth)
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return Response::error('Unauthorised', 401);
        }

        try {
            $user = Auth::user();
            $token = $jwtAuth->fromUser($user, [implode(",", $user->toArray())]);

            if ($token) {
                return Response::get('Bearer ' . $token);
            }

            throw new AccessDeniedHttpException();
        } catch (JWTException $e) {
            throw new HttpException(500);
        }
    }
}
