<?php

namespace App\Services;

use App\Models\Order;
use App\Models\PaymentGateway;
use App\Models\Payment;
use App\Enums\OrderStatus;
use Illuminate\Support\Str;
use App\Services\Payment\PaymentGatewayFactory;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function __construct(protected PaymentGatewayFactory $factory)
    {

    }

    public function index()
    {
        return PaymentGateway::where('is_active', true)->paginate(20);
    }

    public function process(array $data)
    {
        return DB::transaction(function() use($data){

            $order = Order::findOrFail($data['order_id']);
            if($order->status != OrderStatus::Confirmed)
            {
                throw new Exception('Payments only for confirmed orders');
            }

            $gateway = PaymentGateway::where('code',$data['gateway'])->firstOrFail();
            $paymentGateway = $this->factory->make($gateway->code);

            $result = $paymentGateway->process($order);
            $payment = Payment::create([
                                            'payment_id'            => Str::uuid(),
                                            'order_id'              => $order->id,
                                            'payment_gateway_id'    => $gateway->id,
                                            'status'                => $result['status']
            ]);
            return $payment->load('gateway');
        });
    }
}
