<?php

namespace App;

use App\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Sensor extends BaseModel
{
    protected $fillable =[
        'venue_id',
        'sensor_id',
        'field',
        'value'
    ];

    public function venue(){
        return $this->belongsTo('App\Venue');
    }

    public function sensorData(){
        return $this->hasMany('App\SensorData');
    }
}
