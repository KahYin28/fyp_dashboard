<?php

namespace App;

use App\Model\BaseModel;
use App\Model\PivotBaseModel;
use Faker\Provider\Base;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;



class Register extends PivotBaseModel{
    protected $fillable =[

    ];

    protected $table = 'registers';


    public function students(){
        return $this->belongsTo('App\Student','student_id','student_id');
    }
    public function lessons(){
        return $this->belongsTo('App\Lesson','id','id');
    }
    public function attendances(){
        return $this->hasMany('App\Attendance');
    }
//
//    public function students(){
//        return $this->belongsToMany('App\Student','students', 'student_id','student_id');
//    }

}
