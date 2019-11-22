<?php
namespace App\Http\Filters;

class UserFilter extends QueryFilter
{
    public function search($value)
    {
        return $this->builder->where(function ($query) use ($value) {
            $query->where('id', 'LIKE', '%' . $value . '%');
        });
    }

    public function faculty_id($value)
    {
        return $this->builder->where('faculty_id', $value);
    }

    public function name($value)
    {
        return $this->builder->where('name', $value);
    }
    public function id($value)
    {
        return $this->builder->where('id', $value);
    }
}
