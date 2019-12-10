<?php


namespace App\Http\Filters;

class SensorDataFilter extends QueryFilter
{

    public function sensor_id($value){
        return $this->builder->where('sensor_id', $value);
    }

    public function field($value){
        return $this->builder->where('field', $value);
    }

    public function search($value){
        return $this->builder->where(function ($query) use ($value) {
            $query->where('name', 'LIKE', '%' . $value . '%');
        });
    }

}
