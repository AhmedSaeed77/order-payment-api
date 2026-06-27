<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService)
    {

    }

    public function index(Request $request)
    {
        $orders = Order::with(['items','user','payments.gateway'])->where('user_id',auth()->id())
                            ->when($request->status,fn($q)=>$q->where('status',$request->status))
                            ->latest()
                            ->paginate(20);

        return response()->json([
                'success'   =>  true,
                'message'   =>  'Success',
                'data'      =>  OrderResource::collection($orders)
            ],200);
    }

    public function store(StoreOrderRequest $request)
    {
        $order = $this->orderService->create($request->validated());
        return response()->json([
            'message'   =>  'Order created',
            'data'      =>  new OrderResource($order)
        ],201);
    }

    public function show(Order $order)
    {
        return response()->json(new OrderResource($order->load('items')));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order = $this->orderService->update($order,$request->validated());
        return response()->json([
            'message'   =>  'Updated',
            'data'      =>  new OrderResource($order)
        ]);
    }

    public function destroy(Order $order)
    {
        $this->orderService->delete($order);
        return response()->json([
            'message'   =>  'Deleted',
            'data'      =>  Null
        ]);
    }
}
