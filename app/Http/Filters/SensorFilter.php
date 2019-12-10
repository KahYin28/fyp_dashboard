<?php


namespace App\Http\Filters;

class SensorDataFilter extends QueryFilter
{

    public function id($value){
        return $this->builder->where('id', $value);
    }
    public function venue_id($value)
    {
        return $this->builder->where('venue_id', $value);
    }
}
