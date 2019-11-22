<?php

namespace App;

use App\Model\BaseModel;
//use Illuminate\Database\Eloquent\Model;


class Faculty extends BaseModel
{
    protected $fillable =[
        'name'
    ];

    protected $table = 'faculties';

    public function users(){
        return $this->hasMany('App\User');
    }

    public function students(){
        return $this->hasMany('App\Student');
    }
}
