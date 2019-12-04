<?php


namespace App\Http\Filters;


class LessonFilter  extends QueryFilter
{


    public function search($value)
    {
        return $this->builder->where(function ($query) use ($value) {
            $query->where('course_name', 'LIKE', '%' . $value . '%');
        });
    }

    public function user_id($value){
        return $this->builder->where('user_id', $value);
    }
    public function id($value){
        return $this->builder->where('id', $value);
    }


    public function venue_id($value){
        return $this->builder->where('venue_id', $value);
    }
}
