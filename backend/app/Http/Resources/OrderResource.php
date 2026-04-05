<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'status'         => $this->status,
            'subtotal'       => $this->subtotal,
            'delivery_fee'   => $this->delivery_fee,
            'total'          => $this->total,
            'lat'            => $this->lat,
            'lng'            => $this->lng,
            'reference_text' => $this->reference_text,
            'client'         => new UserResource($this->whenLoaded('client')),
            'store'          => new StoreResource($this->whenLoaded('store')),
            'driver'         => new UserResource($this->whenLoaded('driver')),
            'created_at'     => $this->created_at->toISOString(),
            'updated_at'     => $this->updated_at->toISOString(),
        ];
    }
}
