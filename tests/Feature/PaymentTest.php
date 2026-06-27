<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\PaymentGateway;
use App\Enums\OrderStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_can_be_processed()
    {
        $user = User::factory()->create();

        $token = auth('api')->login($user);

        $gateway = PaymentGateway::create([
                'name'  => 'Paypal',
                'code'  => 'paypal'
            ]);

        $order = Order::factory()
            ->create([
                'user_id'   => $user->id,
                'status'    => OrderStatus::Confirmed
            ]);

        $response=
            $this
            ->withHeader(
                'Authorization',
                'Bearer '.$token
            )
            ->postJson(
                '/api/payments/process',
                [
                    'order_id'  => $order->id,
                    'gateway'   => 'paypal'
                ]
            );
        $response->assertStatus(201);

        $this->assertDatabaseHas(
            'payments',
            [
                'order_id' => $order->id
            ]
        );
    }

    public function test_payment_fails_for_pending_order()
    {
        $user = User::factory()->create();

        $token = auth('api')->login($user);

        PaymentGateway::create([
            'name'  => 'Paypal',
            'code'  => 'paypal'
        ]);

        $order=
            Order::factory()
            ->create([
                'user_id'   => $user->id,
                'status'    => OrderStatus::Pending
            ]);

        $response=
            $this
            ->withHeader(
                'Authorization',
                'Bearer '.$token
            )
            ->postJson(
                '/api/payments/process',
                [
                    'order_id'  => $order->id,
                    'gateway'   => 'paypal'
                ]
            );

        $response
            ->assertStatus(422);
    }
}
