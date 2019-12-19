<?php

namespace App;

use App\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Lesson extends BaseModel
{
    protected $fillable =[
        'course_code','semester','lesson_type_id','starting_date_time','ending_date_time'
    ];

    protected $table = 'lessons';

    public function users(){
        return $this->belongsTo('App\User');
    }

    public function venue(){
        return $this->belongsTo('App\Venue');
    }

    public function students(){
        return $this->belongsToMany('App\Student','registers', 'lesson_id','student_id','id','student_id');
    }

    public function lesson_type(){
        return $this->belongsTo('App\LessonType');
    }










}
