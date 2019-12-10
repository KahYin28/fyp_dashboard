<?php

namespace App;

use App\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class SensorData extends BaseModel
{
    protected $fillable =[
        'value'

    ];

    public function sensor(){
        return $this->belongsTo('App\Sensor');
    }

}
