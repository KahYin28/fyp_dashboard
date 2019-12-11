<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Http\Filters\AttendanceFilter;
use App\Register;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, AttendanceFilter $filter)
    {
        $attend = Attendance::filter($filter)
            ->with(['register'])
            ->with(['student'])
            ->pageList($filter->perPage(),$filter->sortType(),$filter->sortBy());
        return $attend;
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
    public function show($id)    {
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
//        Register::

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

}
