<?php

namespace App;

use App\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Replacement extends BaseModel{

    protected $table = 'replacements';

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function venue(){
        return $this->belongsTo('App\Venue');
    }

    public function student(){
        return $this->belongsToMany('App\Student','registers', 'lesson_id','student_id','id','student_id');
    }

    public function lessons(){
        return $this->belongsTo('App\Lesson','id');
    }




}
