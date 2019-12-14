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
    protected $table ='sensor_data';

    public function sensor(){
        return $this->belongsTo('App\Sensor');
    }

}
