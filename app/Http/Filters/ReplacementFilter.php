<?php
namespace App\Http\Filters;

class ReplacementFilter extends QueryFilter{
    public function search($value){
        return $this->builder->where(function ($query) use ($value) {
            $query->where('id', 'LIKE', '%' . $value . '%');
        });
    }

    public function id($value)
    {
        return $this->builder->where('id', $value);
    }


}
