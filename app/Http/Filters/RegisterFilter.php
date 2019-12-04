<?php


namespace App\Http\Filters;


class RegisterFilter extends QueryFilter
{
    public function id($value){
        return $this->builder->where('id', $value);
    }

    public function student_id($value){
        return $this->builder->where('student_id', $value);
    }
    public function lesson_id($value){
        return $this->builder->where('lesson_id', $value);
    }




}
