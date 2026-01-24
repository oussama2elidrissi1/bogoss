<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingItemOptionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'option_id' => $this->service_option_id,
            'name' => $this->option_name,
            'quantity' => $this->quantity,
            'unit_price' => (float) $this->unit_price,
            'duration' => $this->duration,
            'total' => (float) $this->total,
        ];
    }
}
