<?php

namespace App;

use App\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Lighting extends BaseModel
{
    protected $fillable =[
        'venue_id',
        'on_off',
    ];

    protected $table = 'lightings';


    public function venue(){
        return $this->belongsTo('App\Venue');
    }

}
