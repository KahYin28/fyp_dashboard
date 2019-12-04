<?php


namespace App\Http\Filters;

class TemperatureFilter extends QueryFilter
{

    public function id($value)
    {
        return $this->builder->where('id', $value);
    }

    public function degree($value)
    {
        return $this->builder->where('value', $value);
    }

    public function venue_id($value)
    {
        return $this->builder->where('venue_id', $value);
    }
}
