<?php

namespace App\Services\Payment\Gateways;

use App\Models\Order;
use App\Enums\PaymentStatus;
use App\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\DB;

class PaypalGateway implements PaymentGatewayInterface
{
    public function process(Order $order): array
    {
        return [
            'status'                =>  PaymentStatus::Successful->value,
            'transaction_reference' =>  uniqid('PAYPAL_')
        ];
    }
}
