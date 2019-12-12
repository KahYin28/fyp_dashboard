<?php

namespace App\Http\Controllers;

use App\Events\TemperatureUpdateEvent;
use App\Events\HumidityUpdateEvent;
use App\Http\Filters\SensorDataFilter;
use App\SensorData;
use App\Temperature;
use Illuminate\Http\Request;

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
        $data = [
            'sensor_id'=> $request -> sensor_id,
            'field' => $request -> field,
            'value' => $request -> value,
            'created_at' => $request -> created_at,
            'updated_at' => $request ->updated_at
        ];
        SensorData::create($data);

        $temperatureData = SensorData::where('sensor_id',1)->where('field','Temperature(C)')->get();
        $humidityData = SensorData::where('sensor_id',1)->where('field','Humidity(%)')->get();
//        var_dump($temperatureData);
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
        //var_dump($request->all());
        // event(new TemperatureUpdateEvent($request->all()));

//
//        event(new TemperatureUpdateEvent([33, 24, 45, 45, 27, 32, 30, 19, 22, 25]));
        SensorData::findOrFail($id)->where('sensor_id',1)->update($request->all());



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = SensorData::findOrFail($id);
        $data->delete();
    }
}
