<?php


namespace App\Http\Filters;

class AirconFilter  extends QueryFilter
{

    public function id($value)
    {
        return $this->builder->where('id', $value);
    }

    public function set_point($value)
    {
        return $this->builder->where('set_point', $value);
    }

    public function venue_id($value)
    {
        return $this->builder->where('venue_id', $value);
    }
}
