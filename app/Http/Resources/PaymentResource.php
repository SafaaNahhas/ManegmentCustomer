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
            'id'           => $this->id,
            'amount' => $this->amount,
            'payment_date'     => $this->payment_date,
            'status'       => $this->status,
            'customer' => $this->whenLoaded('customer', function () {
                            return $this->customer->pluck('name');
                        }),
        ];
    }
}
