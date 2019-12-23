<?php


namespace App\Http\Filters;


class AttendanceFilter  extends QueryFilter{

    public function lesson_id($value){
        return $this->builder->where('lesson_id', $value);
    }
    public function student_id($value){
        return $this->builder->where('student_id', $value);
    }
    public function status($value){
        return $this->builder->where('status', $value);
    }
    public function replacement_id($value){
        return $this->builder->where('replacement_id', $value);
    }
    public function type($value){
        return $this->builder->where('type', $value);
    }

}
