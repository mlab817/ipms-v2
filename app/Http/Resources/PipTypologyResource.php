<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PipTypologyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'slug'      => $this->slug,
        ];
    }
}
