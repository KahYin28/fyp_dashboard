<?php

namespace App;

use App\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Attendance extends BaseModel
{
    public function register()    {
        return $this->belongsTo('App\Register','register_id');
    }

    public function student()    {
        return $this->belongsTo('App\Student','student_id','student_id');
    }
}
