<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function create(array $data)
    {
        return DB::transaction(function() use($data){
            $total=0;
            foreach($data['items'] as $item)
            {
                $total +=$item['quantity'] * $item['price'];
            }

            $order=Order::create([
                                    'user_id'   =>  auth()->id(),
                                    'status'    =>  $data['status'] ?? 'pending',
                                    'total'     =>  $total
                                ]);

            foreach($data['items'] as $item)
            {
                $order->items()->create([
                                            'product_name'  => $item['product_name'],
                                            'quantity'      => $item['quantity'],
                                            'price'         => $item['price'],
                                            'total'         => $item['quantity'] * $item['price']
                                        ]);
            }
            return $order->load('items');
        });
    }

    public function update(Order $order,array $data)
    {
        return DB::transaction(function() use($order,$data){

            if(isset($data['status']))
            {
                $order->update(['status'=>$data['status']]);
            }

            if(isset($data['items']))
            {
                $order->items()->delete();
                $total=0;
                foreach($data['items'] as $item)
                {
                    $itemTotal = $item['quantity'] * $item['price'];
                    $total += $itemTotal;
                    $order->items()->create([
                                                'product_name'  => $item['product_name'],
                                                'quantity'      => $item['quantity'],
                                                'price'         => $item['price'],
                                                'total'         => $itemTotal
                                            ]);
                }
                $order->update(['total'=>$total]);
            }
            return $order->load('items');
        });
    }

    public function delete(Order $order)
    {
        if($order->payments()->exists())
        {
            throw new \Exception('Cannot delete order with payments');
        }
        $order->delete();
        return true;
    }

}
