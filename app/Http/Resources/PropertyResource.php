<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Roofy API: Consistent JSON shape for property listings across all endpoints.
 */
class PropertyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'availability' => $this->availability,
            'description' => $this->description,
            'totalArea' => $this->totalArea,
            'floor' => $this->floor,
            'location' => $this->location,
            'rooms' => $this->rooms,
            'bathrooms' => $this->bathrooms,
            'price' => $this->price,
            'documents' => $this->documents,
            'agent' => new UserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
