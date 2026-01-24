<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceOptionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => (float) $this->price,
            'duration' => $this->duration,
            'is_required' => $this->is_required,
            'max_quantity' => $this->max_quantity,
            'available' => $this->available,
        ];
    }
}
