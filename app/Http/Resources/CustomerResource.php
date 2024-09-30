<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PaymentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'name' => $this->name,
            'email'     => $this->email,
            'phone'        => $this->phone,
            'payments' => PaymentResource::collection($this->whenLoaded('payments')),
            'orders'   => OrderResource::collection($this->whenLoaded('orders')),
            'latest_payment' => new PaymentResource($this->whenLoaded('latestPayment')),
            'oldest_payment' => new PaymentResource($this->whenLoaded('oldestPayment')),
            'highest_payment'=> new PaymentResource($this->whenLoaded('highestPayment')),
            'lowest_payment' => new PaymentResource($this->whenLoaded('lowestPayment')) ];  }
}
