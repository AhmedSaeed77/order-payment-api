<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    public function run()
    {
        \App\Models\PaymentGateway::insert([

            [
                'name'=>'Paypal',
                'code'=>'paypal',
            ],

            [
                'name'=>'Credit Card',
                'code'=>'credit_card',
            ]

        ]);
    }
}
