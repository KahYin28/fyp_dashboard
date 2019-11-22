<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Lesson extends JsonResource
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
            'course_id' => $this -> course_id,
            'user_id' => $this -> user_id,
             'venue_id'=> $this -> venue_id,
            'schedule_day'=>$this ->schedule_day,
            'semester' => $this -> semester,
            'course_name' => $this -> course_name,
            'type' => $this->type,
            'group' => $this->group,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
