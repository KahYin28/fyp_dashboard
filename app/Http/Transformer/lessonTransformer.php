<?php
namespace App\Http\Transformer;

use App\Lesson;
use League\Fractal;

class LessonTransformer extends Fractal\TransformerAbstract
{
    public function transform($lesson)
    {
//dd($lesson);
        return [
//            'id'      => (int) $book->id,
//            'title'   => $book->title,
//            'year'    => (int) $book->yr,
//            'links'   => [
//                [
//                    'rel' => 'self',
//                    'uri' => '/books/'.$book->id,
//                ]
//            ],
            "id" => $lesson->course_code,

//        "starting_date_time" => $lesson->starting_date_time,
//        "ending_date_time" => $lesson->ending_date_time,
//        "schedule_day" => $lesson->schedule_day,
//        "course_code" => $lesson->course_code,
//        "group" =>$lesson->group,
//        "lesson_type_id" => $lesson->lesson_type_id,
//        "semester" => $lesson->semester,
//        "status" => $lesson->status,
        ];
    }
}
