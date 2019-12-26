<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Events\AttendanceUpdateEvent;
use App\Events\EmotionUpdateEvent;
use App\Events\HumidityUpdateEvent;
use App\Events\TemperatureUpdateEvent;
use App\Http\Filters\AttendanceFilter;
use App\Lesson;
use App\SensorData;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**api to update attendance**/
    public function updateAttendanceEvent(Request $request){

//        return json_encode($request->has('data'));
        $data = $request->input("data");

//          dd($request);
        event(new AttendanceUpdateEvent(json_decode($data)));
//        return json_code($request);
//        return "hello";

    }

    public function updateTemperatureEvent(Request $request){
        $data = $request->input("data");
        event(new TemperatureUpdateEvent(json_decode($data)));
        event(new HumidityUpdateEvent(json_decode($data)));
    }

    public function updateStudentEmotionEvent(Request $request){
        $data = $request->input("data");
       event(new EmotionUpdateEvent(json_decode($data)));
    }

}
