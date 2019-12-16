<?php

namespace App\Http\Controllers;

use App\Events\AttendanceUpdateEvent;
use App\Http\Filters\AttendanceFilter;
use App\Register;
use App\Attendance;
use App\Http\Filters\RegisterFilter;
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
    public function index(Request $request, RegisterFilter $filter){
        $registers = Register::filter($filter)
            ->with(['students'=>function($query){
                $query->with('emotions');
            }])
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


}



