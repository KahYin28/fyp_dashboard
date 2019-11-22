<?php


namespace App\Http\Filters;


class EmotionFilter  extends QueryFilter
{

    public function id($value)
    {
        return $this->builder->where('id', $value);
    }

    public function user($value)
    {
        return $this->builder->where('user_id', $value);
    }
}
