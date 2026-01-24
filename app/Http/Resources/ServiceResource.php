<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'description' => $this->description,
            'price' => (float) $this->price,
            'duration' => $this->duration,
            'image' => $this->image,
            'available' => $this->available,
            'options' => ServiceOptionResource::collection($this->whenLoaded('availableOptions')),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
