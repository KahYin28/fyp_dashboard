<?php

namespace App;

use App\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Attendance extends BaseModel
{
    protected $fillable =[
        'student_id',
        'lesson_id',
        'starting_date_time',
        'ending_date_time',
        'status',
    ];
    public function register()    {
        return $this->belongsTo('App\Register','register_id');
    }

    public function student()    {
        return $this->belongsTo('App\Student','student_id','student_id');
    }
}
