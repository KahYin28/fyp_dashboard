<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Aircon extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'venue_id' => $this->venue_id,
            'set_point' => $this->set_point,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
