<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Http\Filters\LessonFilter;
use App\Lesson;
use App\Register;
use App\SensorData;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;




class LessonController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, LessonFilter $filter){

        $lessons = Lesson::filter($filter)
            ->with(['students'=>function($query) {
                $query->with('faculty');
                $query->with('emotions');
              }])
            ->with(['lesson_type'])
            ->with(['venue'=>function($query) {
                $query->with(['sensors'=>function($query) {
                    $query->with('sensor_type_id');
//                    $query->with('sensor_data');
                }]);
            }])
           ->pageList($filter->perPage(),$filter->sortType(),$filter->sortBy());

       return $lessons;
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
    public function store(Request $request){
        $input = $request->all();
        $register = Register::where('lesson_id', $input['lesson_id'])->join('lessons','registers.lesson_id','lessons.id')->get();

        $now = Carbon::now();

        $finalArray = array();
        foreach($register as $key=>$value){
            array_push($finalArray, array(
              'lesson_id'=> $value['lesson_id'],
              'student_id' => $value['student_id'],
              'starting_date_time' => $value['starting_date_time'],
              'ending_date_time' => $value['ending_date_time'],
              'status' => 0,
              'created_at'=> $now->toDateTimeString())
            );
        };

       // Model::insert($finalArray);
        if($register && $finalArray) {
         //   dd($finalArray);
            Attendance::insert($finalArray);
            return $this->withArray([
                'success' => [
                    'code' => 'success',
                    'http_code' => 200,
                    'message' => ' success'
                ]
            ]);
        }else{
            return $this->withArray([
                'error' => [
                    'code' => 'error',
                    'http_code' => 400,
                    'message' => ' fail'
                ]
            ]);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
        DB::beginTransaction();

        $haha= Lesson::findOrFail($id);
        if($haha->status == 1){
            DB::rollback();
            return $this->withArray([
                'error' => [
                    'code' => 'error',
                    'http_code' => 400,
                    'message' => 'The status alrdy updated.'
                ]
            ]);
        }else {
            $haha->setAttribute('status', 1);
            $haha->save();
        }

        DB::commit();
        return $this->withArray([
            'success' => [
                'code' => 'success',
                'http_code' => 200,
                'message' => 'Transaction success'
            ]
        ]);
    } catch (\Exception $e) {
        DB::rollback();
//            $this->logger->errorLog($request, $e, _CLASS_, _FUNCTION_);
        //  return $this->response->errorInternalError('Internal Server Error');
        return $this->withArray([
                'error' => [
                    'code' => 'error',
                    'http_code' => 400,
                    'message' => 'Transaction failed'
                ]
            ]

        );
    }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson){
        //
    }

    public function getAttendanceReport(Request $request){

     $input = $request->all();

        $lesson = Lesson::where('lessons.id', $input['lesson_id'])
            ->where()
            ->join('registers', 'registers.lesson_id','lessons.id')
            ->get();

        return $this->withArray([
            'lesson' => $lesson,
        ]);


    }


}
