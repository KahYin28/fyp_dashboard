<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Http\Filters\ReplacementFilter;
use App\Register;
use App\Replacement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReplacementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,ReplacementFilter $filter) {
        $replace = Replacement::filter($filter)
            ->with(['lessons'])

            ->paginate(5);

        return $replace;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $input = $request->all();

        try {
            DB::beginTransaction();
            Replacement::create([
                'user_id' => $request -> user_id,
                'lesson_id' => $request -> lesson_id,
                'venue_id' => $request -> venue_id,
                'schedule_day' => $request -> schedule_day,
                'starting_date_time' => $request->starting_date_time,
                'ending_date_time' => $request->ending_date_time,
                'status' => $request -> status,
            ]);

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

            return $this->withArray([
                    'error' => [
                        'code' => 'error',
                        'http_code' => 400,
                        'message' => 'Transaction failed'
                    ]
                ]);
        }




    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function storeReplacement(Request $request){
        $input = $request->all();
        $register = Register::where('lesson_id', $input['lesson_id'])->join('lessons','registers.lesson_id','lessons.id')->get();

        //  dd($register);
        //  dd($register[0]['lesson_id']);
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


}
