<?php


namespace App\Http\Filters;


class FacultyFilter  extends QueryFilter
{
    public function search($value)
    {
        return $this->builder->where(function ($query) use ($value) {
            $query->where('name', 'LIKE', '%' . $value . '%');
        });
    }

    public function id($value)
    {
        return $this->builder->where('id', $value);
    }

    public function name($value)
    {
        return $this->builder->where('name', $value);
    }
}
