<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Student extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
           'student_id' => $this -> student_id,
            'name' => $this -> name,
            'programme' => $this -> programme,
            'faculty_id' => $this -> faculty_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
