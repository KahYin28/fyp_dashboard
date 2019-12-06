<?php


namespace App\Http\Filters;


class AttendanceFilter  extends QueryFilter
{

    public function register($value){
        return $this->builder->where('register_id', $value);
    }
    public function student($value){
        return $this->builder->where('student_id', $value);
    }

}
