<?php
namespace App\Http\Filters;

class StudentFilter extends QueryFilter
{
    public function search($value)
    {
        return $this->builder->where(function ($query) use ($value) {
            $query->where('student_id', 'LIKE', '%' . $value . '%');
        });
    }

    public function student_id($value)
    {
        return $this->builder->where('student_id', $value);
    }

    public function name($value)
    {
        return $this->builder->where('name', $value);
    }

    public function programme($value)
    {
        return $this->builder->where('programme', $value);
    }

    public function lesson_id($value)
    {
        return $this->builder->where('lesson_id', $value);
    }


}
