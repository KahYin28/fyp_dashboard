<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Emotion;
use App\Events\EmotionUpdateEvent;
use App\Http\Filters\EmotionFilter;
use App\Lesson;
use App\Register;
use App\SensorType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,EmotionFilter $filter)
    {
        $emotions = Emotion::filter($filter)
                    ->with(['student'])
                    ->pageList($filter->perPage(),$filter->sortType(),$filter->sortBy());
        return $emotions;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'id' => $request->id,
            'student_id' => $request->student_id,
            'happy' => $request->happy,
            'sad' => $request->sad,
            'angry' => $request->angry,
            'confused' => $request->confused,
            'disgusted' => $request->disgusted,
            'surprised' => $request->surprised,
            'calm' => $request->calm,
            'unknown' => $request->unknown,
            'fear' => $request->fear,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at
        ];
        Emotion::create($data);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Emotion  $emotion
     * @return \Illuminate\Http\Response
     */
    public function show($id){

        $emotion = Emotion::where('student_id', $id)->first();

        return $emotion;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Emotion  $emotion
     * @return \Illuminate\Http\Response
     */
    public function edit(Emotion $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Emotion  $emotion
     * @return \Illuminate\Http\Response
     */
    public function updateStudentEmotion(Request $request)
    {
        $input = $request->all();

        $students = Lesson::where('lessons.id', $input["lesson_id"])
            ->join('registers','lessons.id','registers.lesson_id')
            ->join('students','students.student_id','registers.student_id')
            ->join('emotions','emotions.student_id','students.student_id')->get();

        $count_happy = Lesson::where('lessons.id', $input["lesson_id"])
            ->join('registers','lessons.id','registers.lesson_id')
            ->join('students','students.student_id','registers.student_id')
            ->join('emotions','emotions.student_id','students.student_id')
            ->avg('happy');
        $happy_avg = round($count_happy,2);

        $count_sad = Lesson::where('lessons.id', $input["lesson_id"])
            ->join('registers','lessons.id','registers.lesson_id')
            ->join('students','students.student_id','registers.student_id')
            ->join('emotions','emotions.student_id','students.student_id')
            ->avg('sad');
        $sad_avg = round($count_sad,2);

        $count_angry = Lesson::where('lessons.id', $input["lesson_id"])
            ->join('registers','lessons.id','registers.lesson_id')
            ->join('students','students.student_id','registers.student_id')
            ->join('emotions','emotions.student_id','students.student_id')
            ->avg('angry');
        $angry_avg = round($count_angry,2);

        $count_confused = Lesson::where('lessons.id', $input["lesson_id"])
            ->join('registers','lessons.id','registers.lesson_id')
            ->join('students','students.student_id','registers.student_id')
            ->join('emotions','emotions.student_id','students.student_id')
            ->avg('confused');
        $confused_avg = round($count_confused,2);

        $count_disgusted = Lesson::where('lessons.id', $input["lesson_id"])
            ->join('registers','lessons.id','registers.lesson_id')
            ->join('students','students.student_id','registers.student_id')
            ->join('emotions','emotions.student_id','students.student_id')
            ->avg('disgusted');
        $disgusted_avg = round($count_disgusted,2);


        $count_surprised = Lesson::where('lessons.id', $input["lesson_id"])
            ->join('registers','lessons.id','registers.lesson_id')
            ->join('students','students.student_id','registers.student_id')
            ->join('emotions','emotions.student_id','students.student_id')
            ->avg('surprised');
        $surprised_avg = round($count_surprised,2);

        $count_calm = Lesson::where('lessons.id', $input["lesson_id"])
            ->join('registers','lessons.id','registers.lesson_id')
            ->join('students','students.student_id','registers.student_id')
            ->join('emotions','emotions.student_id','students.student_id')
            ->avg('calm');
        $calm_avg = round($count_calm,2);

        $count_fear = Lesson::where('lessons.id', $input["lesson_id"])
            ->join('registers','lessons.id','registers.lesson_id')
            ->join('students','students.student_id','registers.student_id')
            ->join('emotions','emotions.student_id','students.student_id')
            ->avg('fear');
        $fear_avg = round($count_fear,2);

        $new_data =[
            'happy_avg'=> $happy_avg,
            'sad_avg'=> $sad_avg,
            'angry_avg'=> $angry_avg,
            'confused_avg'=> $confused_avg,
            'disgusted_avg'=> $disgusted_avg,
            'surprised_avg'=> $surprised_avg,
            'calm_avg'=> $calm_avg,
            'fear_avg'=> $fear_avg,
            ];

          event(new EmotionUpdateEvent($new_data));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Emotion  $emotion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $emotion = Emotion::findOrFail($id);
        $emotion->delete();
    }


    public function getStudentEmotion(Request $request){
        $input = $request->all();

        $students = Lesson::where('lessons.id', $input["lesson_id"])
            ->join('registers','lessons.id','registers.lesson_id')
            ->join('students','students.student_id','registers.student_id')
            ->join('emotions','emotions.student_id','students.student_id')->get();

        $count_happy = Lesson::where('lessons.id', $input["lesson_id"])
            ->join('registers','lessons.id','registers.lesson_id')
            ->join('students','students.student_id','registers.student_id')
            ->join('emotions','emotions.student_id','students.student_id')
            ->avg('happy');
        $happy_avg = round($count_happy,2);

        $count_sad = Lesson::where('lessons.id', $input["lesson_id"])
            ->join('registers','lessons.id','registers.lesson_id')
            ->join('students','students.student_id','registers.student_id')
            ->join('emotions','emotions.student_id','students.student_id')
            ->avg('sad');
        $sad_avg = round($count_sad,2);

        $count_angry = Lesson::where('lessons.id', $input["lesson_id"])
            ->join('registers','lessons.id','registers.lesson_id')
            ->join('students','students.student_id','registers.student_id')
            ->join('emotions','emotions.student_id','students.student_id')
            ->avg('angry');
        $angry_avg = round($count_angry,2);

        $count_confused = Lesson::where('lessons.id', $input["lesson_id"])
            ->join('registers','lessons.id','registers.lesson_id')
            ->join('students','students.student_id','registers.student_id')
            ->join('emotions','emotions.student_id','students.student_id')
            ->avg('confused');
        $confused_avg = round($count_confused,2);

        $count_disgusted = Lesson::where('lessons.id', $input["lesson_id"])
            ->join('registers','lessons.id','registers.lesson_id')
            ->join('students','students.student_id','registers.student_id')
            ->join('emotions','emotions.student_id','students.student_id')
            ->avg('disgusted');
        $disgusted_avg = round($count_disgusted,2);


        $count_surprised = Lesson::where('lessons.id', $input["lesson_id"])
            ->join('registers','lessons.id','registers.lesson_id')
            ->join('students','students.student_id','registers.student_id')
            ->join('emotions','emotions.student_id','students.student_id')
            ->avg('surprised');
        $surprised_avg = round($count_surprised,2);

        $count_calm = Lesson::where('lessons.id', $input["lesson_id"])
            ->join('registers','lessons.id','registers.lesson_id')
            ->join('students','students.student_id','registers.student_id')
            ->join('emotions','emotions.student_id','students.student_id')
            ->avg('calm');
        $calm_avg = round($count_calm,2);

        $count_fear = Lesson::where('lessons.id', $input["lesson_id"])
            ->join('registers','lessons.id','registers.lesson_id')
            ->join('students','students.student_id','registers.student_id')
            ->join('emotions','emotions.student_id','students.student_id')
            ->avg('fear');
        $fear_avg = round($count_fear,2);


        return $this->withArray([
//            'studentData' => $students,
            'happy_avg'=> $happy_avg,
            'sad_avg'=> $sad_avg,
            'angry_avg'=> $angry_avg,
            'confused_avg'=> $confused_avg,
            'disgusted_avg'=> $disgusted_avg,
            'surprised_avg'=> $surprised_avg,
            'calm_avg'=> $calm_avg,
            'fear_avg'=> $fear_avg,

        ]);




    }




}
