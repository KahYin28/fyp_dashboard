<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
//            'student_matric_no' => $this -> matric_no,
//            'student_name' => $this -> name,
//            'programme' => $this -> programme,
//            'faculty_id' => $this -> faculty

        ];
    }
}
