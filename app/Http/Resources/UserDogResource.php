<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'dog_id' => $this->dog_id,
            'name' => $this->name,
            'health_level' => $this->health_level,
            'hunger_level' => $this->hunger_level,
            'image_url' => $this->image_url,
            'price' => $this->price,
            'last_feeding_time' => is_null($this->last_feeding_time) ? null : $this->last_feeding_time->format('Y-m-d H:i:s'),
        ];
    }
}
