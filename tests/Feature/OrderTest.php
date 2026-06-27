<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Order;
use App\Enums\OrderStatus;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_order()
    {
        $user = User::factory()->create();

        $token = auth('api')->login($user);

        $response=$this
            ->withHeader(
                'Authorization',
                'Bearer '.$token
            )
            ->postJson('/api/orders',[
                'status'=>'pending',
                'items'=>[
                    [
                        'product_name'  =>'Laptop',
                        'quantity'      =>2,
                        'price'         =>5000
                    ]
                ]
            ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas(
            'orders',
            [
                'user_id' => $user->id
            ]
        );
    }

    public function test_user_can_update_order()
    {
        $user = User::factory()->create();

        $token = auth('api')->login($user);

        $order = Order::factory()
            ->confirmed()
            ->create([
                'user_id' => $user->id
            ]);

        $response=$this
            ->withHeader(
                'Authorization',
                'Bearer '.$token
            )
            ->putJson(
                "/api/orders/$order->id",
                [
                    'status' => 'confirmed'
                ]
            );

        $response
            ->assertStatus(200);

        $this->assertDatabaseHas(
            'orders',
            [
                'id'    => $order->id,
                'status'=> 'confirmed'
            ]
        );
    }

    public function test_payment_fails_for_pending_order()
    {
        $user = User::factory()->create();
        $token = auth('api')->login($user);
        $order = Order::factory()
            ->pending()
            ->create([
                'user_id'=>$user->id
            ]);

        $response = $this
            ->withHeader(
                'Authorization',
                'Bearer '.$token
            )
            ->postJson(
                '/api/payments/process',
                [
                    'order_id'=>$order->id,
                    'gateway'=>'paypal'
                ]
            );

        $response->assertStatus(422);
    }
}
