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
        return [
            'id'           => $this->id,
            'product_name' => $this->product_name,
            'quantity'     => $this->quantity,
            'price'        => $this->price,
            'status'       => $this->status,
            'order_date'   => $this->order_date,
            'customer' => $this->whenLoaded('customer', function () {
                return $this->customer->pluck('name');
            }),
        ];

    }
}
