<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function register(array $data): array
    {
        $user = User::create([
            'name'      =>  $data['name'],
            'email'     =>  $data['email'],
            'password'  =>  Hash::make($data['password'])
        ]);

        $token = JWTAuth::fromUser($user);

        return [
            'user'  =>  $user,
            'token' =>  $token
        ];
    }

    public function login(array $credentials): array
    {
        if (!$token = auth()->attempt($credentials))
        {
            throw new \Exception('Invalid credentials');
        }

        return [
            'user'  =>  auth()->user(),
            'token' =>  $token
        ];
    }

    public function logout(): void
    {
        auth()->logout();
    }

    public function me()
    {
        return auth()->user();
    }
}
