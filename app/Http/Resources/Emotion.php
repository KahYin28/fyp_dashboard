<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Emotion extends JsonResource
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
            'student_id' => $this->student_id,
            'happy' => $this->happy,
            'sad' => $this->sad,
            'angry' => $this->angry,
            'confused' => $this->confused,
            'disgusted' => $this->disgusted,
            'surprised' => $this->surprised,
            'calm' => $this->calm,
            'unknown' => $this->unknown,
            'fear' => $this->fear,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
