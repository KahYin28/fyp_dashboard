<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Events\AttendanceUpdateEvent;
use App\Http\Filters\AttendanceFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, AttendanceFilter $filter){
        $attend = Attendance::filter($filter)
            ->with(['students'=>function($query){
                $query->with('emotions');
            }])
            ->with(['students' => function ($query) {
                $query->with('faculty');
            }])
            ->with(['lessons'])
        ->paginate(10);
        return $attend;
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
            'id' => $request -> id,
            'lesson_id'=> $request -> lesson_id,
            'student_id'=> $request -> student_id,
            'status' => $request -> status,
            'starting_date_time'=>$request -> starting_date_time,
            'ending_date_time'=>$request -> ending_date_time,
            'created_at' => $request -> created_at,
            'updated_at' => $request ->updated_at
        ];
        Attendance::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, AttendanceFilter $filter )    {
        $result = Attendance::filter($filter)
            ->with(['students'])
            ->where('lesson_id', $id)->get();
        //   ->paginate(5);
        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
    }

    /**api to update attendance**/
    public function updateAttendance(Request $request,AttendanceFilter $filter ){
        $id = $request->input("student_id");
        $datetime = $request->input("starting_date_time");

        $date = Carbon::parse($datetime)->format('Y-m-d H:i:s');

//        $id = "188111";
//        $datetime = "2019-12-15 8:05:00";

        $students = Attendance::where('student_id', $id)
            ->orderby(DB::raw('ABS(DATEDIFF(starting_date_time, NOW()))'))->first();

//        $aaa = $students->student_id;
//        $bbb =$students->starting_date_time;

        $beforeStart = Carbon::parse($students->starting_date_time)->subMinutes(60)->format('Y-m-d H:i:s');
        $afterStart = Carbon::parse($students->starting_date_time)->addMinutes(60)->format('Y-m-d H:i:s');
//            echo $beforeStart ."<br>";
//            echo $afterStart ."<br>";
//        echo $bbb . "<br>";
        $lesson_id = $students->lesson_id;
        $lesson_date_time =$students->starting_date_time;

        $list = Attendance::where('lesson_id',$lesson_id)->where('starting_date_time', $lesson_date_time)
            ->get();

        try {
            DB::beginTransaction();
            if ($students->status == 1) {
                DB::commit();
                return $this->withArray([
                    'error' => [
                        'code' => 'error',
                        'http_code' => 200,
                        'message' => 'The attendance has already been taken.'
                    ]
                ]);

            }else {
                if ($beforeStart <= $date && $afterStart >= $date) {
                    $students->setAttribute('status', 1);
                    $students->setAttribute('created_at', $date);
                    $students->save();
                }
                else{
                    $students->setAttribute('status', 2);
                    $students->setAttribute('created_at', $date);
                    return $this->withArray([
                        'success' => [
                            'code' => 'success',
                            'http_code' => 200,
                            'message' => 'The student is late.'
                        ]
                    ]);
                }
            }

            DB::commit();

            event(new AttendanceUpdateEvent($list));

            return $this->withArray([
                'success' => [
                    'code' => 'success',
                    'http_code' => 200,
                    'message' => 'The attendance is taken.'
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
        }
    }

}
