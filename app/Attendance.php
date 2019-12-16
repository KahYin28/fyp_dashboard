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

    public function students()    {
        return $this->belongsTo('App\Student','student_id','student_id');
    }

    public function lessons(){
        return $this->belongsTo('App\Lesson','lesson_id','id');
    }
}
