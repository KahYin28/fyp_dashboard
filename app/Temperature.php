<?php

namespace App;
use App\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Temperature extends BaseModel
{
    protected $fillable =[
        'venue_id',
        'value'
    ];

    protected $table = 'temperatures';











}
