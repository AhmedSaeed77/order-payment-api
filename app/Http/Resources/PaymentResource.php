<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'payment_id'    => $this->payment_id,
            'method'        => $this->gateway?->name,
            'status'        => $this->status->value,
            'created_at'    => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
