<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CareerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'position'        => $this->position,
            'number'          => $this->number,
            'expiration_date' => optional($this->expiration_date)->toDateString(),
            'description'     => $this->description,
            'is_open'         => (bool) $this->is_open,
            'created_at'      => $this->created_at?->toIso8601String(),
            'updated_at'      => $this->updated_at?->toIso8601String(),
        ];
    }
}
