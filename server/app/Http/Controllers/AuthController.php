<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Services\UserService;

class AuthController extends Controller
{
    private UserService $_service;

    public function __construct(UserService $service)
    {
        $this->_service = $service;
    }

    public function register(Request $request)
    {
        $user = $this->_service->registerUser($request->all());

        if ($this->_service->hasErrors()) {
            return response([
                'status' => 400,
                'message' => 'Validation error',
                'errors' => $this->_service->getErrors()
            ], 400);
        }

        return response()->json(
            [
                'message' => 'User created successfully',
                'data' => $user,
            ],
            201
        );
    }

    public function login(Request $request)
    {
        $token = $this->_service->login($request);
        if (!$token) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
                'errors' => $this->_service->getErrors()
            ], 401);
        }
        return response([
            "status" => "success",
            "token" => $token
        ], 200);
        /* Cookie didn't work in client but you could see it in the headers of the request
        ->withCookie(
            'token',
            $token,
            config('jwt.ttl'),
            '/',
            null,
            true,
            true,
            false,
            "None"
        );*/
    }
}
