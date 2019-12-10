<?php

namespace App;

use App\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Emotion extends BaseModel
{
    protected $fillable =[
        'happy',
        'sad',
        'angry',
        'confused',
        'disgusted',
        'surprised',
        'calm',
        'fear',
    ];

    protected $table= 'emotions';

    public function student()    {
        return $this->belongsTo('App\Student','student_id','student_id');
    }
}
