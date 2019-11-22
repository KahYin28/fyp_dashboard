<?php

namespace App;
use App\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;


class Student extends BaseModel
{
    protected $fillable =[
        'student_id',
        'name',
        'programme'
    ];

    protected $table = 'students';

    public function faculty(){
        return $this->belongsTo('App\Faculty');
    }
    public function emotions(){
        return $this->hasMany('App\Emotion');
    }

    public function lessons(){
        return $this->belongsToMany('App\Lesson','registers', 'student_id', 'lesson_id','student_id');
    }


}
