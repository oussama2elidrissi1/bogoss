<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'booking_reference' => $this->booking_reference,
            'client' => [
                'id' => $this->client_id,
                'name' => $this->client_name,
            ],
            'date' => $this->date->toDateString(),
            'time' => $this->time,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'payment_method' => $this->payment_method,
            'totals' => [
                'subtotal' => (float) $this->subtotal,
                'discount_total' => (float) $this->discount_total,
                'total' => (float) $this->total,
                'total_duration' => $this->total_duration,
            ],
            'items' => BookingItemResource::collection($this->whenLoaded('items')),
            'notes' => $this->notes,
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
