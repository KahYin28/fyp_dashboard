<?php

namespace App;
use App\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Venue extends BaseModel
{
    protected $fillable =[
      'name',
      'temperature'
    ];

    protected $table = 'venues';


    public function lightings(){
        return $this->hasMany('App\Lighting');
    }
    public function temperatures(){
        return $this->hasMany('App\Temperature');
    }

    public function lessons(){
        return $this->hasMany('App\Lesson');
    }
}
