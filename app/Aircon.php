<?php

namespace App;
use App\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Aircon extends BaseModel
{
    protected $fillable =[
        'venue_id',
        'set_point'
    ];

    protected $table = 'aircons';

    public function venue(){
        return $this->belongsTo('App\Venue');
    }









}
