<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'health_level' => $this->health_level,
            'hunger_level' => $this->hunger_level,
            'image_url' => $this->image_url,
            'price' => $this->price,
        ];
    }
}
