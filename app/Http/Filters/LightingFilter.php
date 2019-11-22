<?php


namespace App\Http\Filters;


class LightingFilter extends QueryFilter
{
    public function id($value)
    {

        return $this->builder->where('id', $value);
    }

    public function venue_id($value)
    {
        return $this->builder->where('venue_id', $value);
    }

    public function on_off($value)
    {
        return $this->builder->where('on_off', $value);
    }
}
