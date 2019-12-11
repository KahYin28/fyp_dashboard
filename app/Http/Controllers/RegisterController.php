<?php

namespace App\Http\Controllers;

use App\Events\AttendanceUpdateEvent;
use App\Register;
use App\Attendance;
use App\Http\Filters\RegisterFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, RegisterFilter $filter){
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
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, RegisterFilter $filter){
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
    public function update(Request $request, $id){
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        //
    }

    /**api to check attendance**/
    public function updateAttendance(Request $request){
        $id = $request->input("student_id");
        $id = "188111";
//        $time = $request ->input("time");
        $date1 = "2019-09-18 18:05:00";
        $d1 = Carbon::parse($date1)->format('Y-m-d H:i:s');

//       $inputs = $request->all();
//
        $registration_attempts = Register::where('student_id', $id)->get();
//       $registered_lessons = $registration_attempts->lessons;
//        return $registration_attempts;
        foreach ($registration_attempts as $registration_attempt) {
            $lesson_id =  $registration_attempt->lessons->id ."<br>";
            echo $lesson_id;

            $beforeStart = Carbon::parse($registration_attempt->lessons->starting_date_time)->subMinutes(15)->format('Y-m-d H:i:s');
            $afterStart = Carbon::parse($registration_attempt->lessons->starting_date_time)->addMinutes(15)->format('Y-m-d H:i:s');
            echo $beforeStart ."<br>";
            echo $afterStart ."<br>";

            if ( $beforeStart <= $d1 && $afterStart >= $d1 ) {
                $registered_lesson = Register::where('lesson_id', $lesson_id)->get();
                $registered_students = $registered_lesson;

                foreach ($registered_students as $registered_student) {
                    echo $registered_student->student_id . "<br>";

                    $lesson_ID =  $registered_student->lesson_id;
                    foreach ($registered_student as $student) {
                        if ($id == $student) {
                            $attendance = new Attendance([
                                'student_id' => $id,
                                'lesson_id' => $lesson_ID,
                                'starting_date_time' => $d1,
                                'ending_date_time'=> $d1,
                                'status'=>1
                            ]);
                            var_dump($attendance);
                            $attendance->save();
                        } //end if
                    }// end foreach
//                    $list = Attendance::where('lesson_id',$lesson_id);
////                var_dump($list);
//                    event(new AttendanceUpdateEvent($list));
                    return response()->json(true);
                } //end foreach


            } //end if
                else {
                return response()->json(false);
            }

        }

    }
}



