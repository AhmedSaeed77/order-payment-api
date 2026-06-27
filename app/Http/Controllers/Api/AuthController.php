<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {

    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try
        {
            $data = $this->authService->register($request->validated());
            return response()->json([
                'success'   =>  true,
                'message'   =>  'Registered successfully',
                'data'      =>  $data
            ],201);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success'   =>  false,
                'message'   =>  $e->getMessage()
            ],500);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try
        {
            $data = $this->authService->login($request->validated());
            return response()->json([
                'success'   =>  true,
                'message'   =>  'Login successful',
                'data'      =>  $data
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success'   =>  false,
                'message'   =>  $e->getMessage()
            ],401);
        }
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return response()->json([
            'success'   =>  true,
            'message'   =>  'Logged out'
        ]);
    }

    public function me(): JsonResponse
    {
        return response()->json([
            'success'   =>  true,
            'data'      =>  $this->authService->me()
        ]);
    }
}
