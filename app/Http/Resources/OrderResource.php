<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
                    'id'            => $this->id,
                    'status'        => $this->status->value,
                    'total'         => $this->total,
                    'created_at'    => $this->created_at?->format('Y-m-d H:i:s'),
                    'user'          => new UserResource($this->whenLoaded('user')),
                    'items'         => OrderItemResource::collection($this->whenLoaded('items')),
                    'payments'      => PaymentResource::collection($this->whenLoaded('payments')),
        ];
    }
}
