<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->postJson(
            '/api/auth/register',
            [
                'name'                  =>'test',
                'email'                 =>'test@gmail.com',
                'password'              =>'123456789a@',
                'password_confirmation' =>'123456789a@'
            ]
        );

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data'=>[
                    'user',
                    'token'
                ]
            ]);
    }

    public function test_user_can_login()
    {
        $this->postJson('/api/auth/register',[
            'name'                  =>'test',
            'email'                 =>'test@gmail.com',
            'password'              =>'123456789a@',
            'password_confirmation' =>'123456789a@'
        ]);

        $response=$this->postJson(
            '/api/auth/login',
            [
                'email'     =>'test@gmail.com',
                'password'  =>'123456789a@'
            ]
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'=>[
                    'token'
                ]
            ]);
    }
}
