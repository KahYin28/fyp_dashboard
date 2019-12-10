<?php

namespace App;
use App\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Venue extends BaseModel
{
    protected $fillable =[
      'name',
    ];

    protected $table = 'venues';

    public function sensors(){
        return $this->hasMany('App\Sensor');
    }

    public function lessons(){
        return $this->hasMany('App\Lesson');
    }

    public function replacements(){
        return $this->hasMany('App\Replacement');
    }
}
