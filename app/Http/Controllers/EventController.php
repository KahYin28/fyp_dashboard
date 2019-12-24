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
    public function updateAttendance(Request $request,AttendanceFilter $filter ){
        $data = $request->input("data");
        event(new AttendanceUpdateEvent($data));


    }

    public function updateStudentEmotion(Request $request)
    {
        $data = $request->input("data");

        event(new TemperatureUpdateEvent($data));
        event(new HumidityUpdateEvent($data));
    }

}
