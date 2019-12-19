<?php

namespace App;

use App\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Sensor extends BaseModel
{
    protected $fillable =[
        'venue_id',
        'name',
        'sensor_type_id',
        'pin_number'
    ];

    public function venue(){
        return $this->belongsTo('App\Venue');
    }

    public function sensor_type_id(){
        return $this->hasMany('App\SensorType','id','sensor_type_id');
    }

    public function sensor_data(){
        return $this->hasMany('App\SensorData','sensor_id','id');
    }
}
