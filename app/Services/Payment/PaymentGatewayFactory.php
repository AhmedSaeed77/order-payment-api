<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Enums\PaymentStatus;
use App\Services\Payment\Gateways\PaypalGateway;
use App\Services\Payment\Gateways\CreditCardGateway;
use Illuminate\Support\Facades\DB;

class PaymentGatewayFactory
{
    public function make(string $gateway)
    {
        return match($gateway){
            'paypal'        => app(PaypalGateway::class),
            'credit_card'   => app(CreditCardGateway::class),
            default         => throw new Exception('Unsupported gateway')
        };
    }
}
