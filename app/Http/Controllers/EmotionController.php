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
    public function create()
    {

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
            'id' => $request -> id,
            'student_id'=> $request -> student_id,
            'happy' => $request -> happy,
            'sad' => $request -> sad,
            'angry' => $request -> angry,
            'confused' => $request -> confused,
            'disgusted' => $request -> disgusted,
            'surprised' => $request -> surprised,
            'calm' => $request -> calm,
            'unknown' => $request -> unknown,
            'fear' => $request -> fear,
            'created_at' => $request -> created_at,
            'updated_at' => $request ->updated_at
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
    public function update(Request $request, $id)
    {
        //
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

//        event(new EmotionUpdateEvent($students));

        return $this->withArray([
            'studentData' => $students,
        ]);


    }




}
