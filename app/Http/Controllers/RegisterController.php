<?php

namespace App\Http\Controllers;

use App\Http\Filters\RegisterFilter;
use App\Register;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, RegisterFilter $filter)
    {
        $registers = Register::filter($filter)
//            ->with(['students'=>function($query){
//                $query->with('emotions');
//            }])
            ->with(['students' => function ($query) {
                $query->with('faculty');
            }])
            ->with(['lessons'])
            ->paginate(5);

        return $registers;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, RegisterFilter $filter)
    {
        $result = Register::filter($filter)
            ->with(['students'])
            ->with(['lessons'])
            ->where('lesson_id', $id)->get();
        //   ->paginate(5);
        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkAttend()
    {
//        $id = $request->input('student_id');
//        $time = $request ->input('time');
        $date1 = "2019-12-07 18:30:00";

        $d1 = Carbon::parse($date1)->format('Y-m-d H:i:s');
//        echo $d1->addMinutes(10);
//        echo $d1->subMinutes(10);
        $registration_attempts = Register::where('student_id', 188111)->get();
//        $registered_lessons = $registration_attempts->lessons;

//        return $registration_attempts;
        foreach ($registration_attempts as $registration_attempt) {
            echo $registration_attempt->lessons->id . "<br>";

            $beforeStart = Carbon::parse($registration_attempt->lessons->starting_date_time)->subMinutes(15)->format('Y-m-d H:i:s');
            $afterStart = Carbon::parse($registration_attempt->lessons->starting_date_time)->addMinutes(15)->format('Y-m-d H:i:s');
            echo $beforeStart;
            echo $afterStart;

            if ( $beforeStart >= $d1 &&  $afterStart <= $d1 ) {

                $registered_lesson = Register::where('lesson_id', 1)->get();
                $registered_students = $registered_lesson->student_id;

                foreach ($registered_students as $registered_student) {
                    if ($id == $registered_student) {
                        $attendance = new Attendance;
                        $attendance->student_id = $id;
                        $attendance->lesson_id = $registered_lesson;
                        $attendance->arrival_date_time = $time;
                        $attendance->save();
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        }
    }

}
//            if($registration_attempt->lessons->starting_date_time <= $d1  ){
//
//                echo $registration_attempt->lessons->id .'<br>';
//                echo $registration_attempt->lessons->starting_date_time .'<br>';
//                echo $d1;
//
//            }
//            else{
//                echo "false";
//            }


//        return $registered_lessons;


