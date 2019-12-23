<?php

namespace App\Http\Controllers;

use App\Events\TemperatureUpdateEvent;
use App\Events\HumidityUpdateEvent;
use App\Http\Filters\SensorDataFilter;
use App\SensorData;
use App\Temperature;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SensorDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SensorDataFilter $filter)
    {
        $data = SensorData::filter($filter)
            ->with(['sensor'=> function ($query) {
                $query->with('venue');
            }])
            ->pageList($filter->perPage(),$filter->sortType(),$filter->sortBy());
//        event(new TemperatureUpdateEvent($data));
        return $data;


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
    public function store(Request $request, SensorDataFilter $filter)
    {
        $now = Carbon::now();
        $data = [
            'sensor_id'=> $request -> sensor_id,
            'field' => $request -> field,
            'value' => $request -> value,
            'created_at' => $now->toDateTimeString(),
            'updated_at' => $now->toDateTimeString()
        ];
        SensorData::create($data);

        $temperatureData = SensorData::where('sensor_id',$request->sensor_id)->where('field','Temperature(C)')->orderBy('id', 'desc')->take(10)->get();

        $humidityData = SensorData::where('sensor_id',$request->sensor_id)->where('field','Humidity(%)')->get();


        event(new TemperatureUpdateEvent($temperatureData));
        event(new HumidityUpdateEvent($humidityData));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = SensorData::findOrFail($id);
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,SensorDataFilter $filter)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $data = SensorData::findOrFail($id);
        $data->delete();
    }

//    public function updateSensorDataEvent(Request $request){
//
//        $temperatureData = SensorData::where('sensor_id',$request->sensor_id)->where('field','Temperature(C)')->get();
//
//        $humidityData = SensorData::where('sensor_id',$request->sensor_id)->where('field','Humidity(%)')->get();
//
//        event(new TemperatureUpdateEvent($temperatureData));
//        event(new HumidityUpdateEvent($humidityData));
//
//
//    }

}
