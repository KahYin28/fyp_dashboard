<?php


namespace App\Http\Filters;

class SensorTypeFilter extends QueryFilter
{

    public function id($value)
    {
        return $this->builder->where('id', $value);
    }

    public function name($value)
    {
        return $this->builder->where('name', $value);
    }
}
