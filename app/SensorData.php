<?php

namespace App;

use App\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class SensorData extends BaseModel
{
    protected $fillable =[
        'sensor_id',
        'field',
        'value',
    ];

    public function sensor(){
        return $this->belongsTo('App\Sensor');
    }

}
