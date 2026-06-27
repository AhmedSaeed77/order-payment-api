<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\PaymentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessPaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\PaymentGetwayResource;

class PaymentController extends Controller
{
    public function __construct(protected PaymentService $paymentService)
    {

    }

    public function index()
    {
        return PaymentGetwayResource::collection($this->paymentService->index());
    }

    public function process(ProcessPaymentRequest $request)
    {
        return new PaymentResource($this->paymentService->process($request->validated()));
    }
}
