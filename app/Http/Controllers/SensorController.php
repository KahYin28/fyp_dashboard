<?php

namespace App\Http\Controllers;

use App\Events\HumidityUpdateEvent;
use App\Events\TemperatureUpdateEvent;
use App\Http\Filters\SensorFilter;
use App\Sensor;
use App\SensorData;
use App\SensorType;
use App\Temperature;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SensorFilter $filter)
    {

        $data = Sensor::filter($filter)
            ->with(['venue'])
            ->with(['sensorData'])
            ->pageList($filter->perPage(),$filter->sortType(),$filter->sortBy());

        return $data;
        //    event(new TemperatureUpdateEvent($data));

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
    public function store(Request $request){

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id){
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



    public function getSensorData(Request $request) {
        $input = $request->all();
        $sensor_types = SensorType::where('name','Temperature')->get();

        foreach($sensor_types as $sensor_type){
            $sensor_type_id = $sensor_type->id;
        }

        $sensors = Sensor::where('sensor_type_id', $sensor_type_id)
            ->where('venue_id', $input['venue_id'])
            ->where('field','Temperature(C)')
            ->join('sensor_data','sensor_data.sensor_id','sensors.id')->get();

        echo $sensors;

        foreach($sensors as $sensor){
           $sensor_id = $sensor->sensor_id;
        }

        $temperatureData = SensorData::where('sensor_id',$request->sensor_id)->where('field','Temperature(C)')->get();

        $humidityData = SensorData::where('sensor_id',$request->sensor_id)->where('field','Humidity(%)')->get();


        event(new TemperatureUpdateEvent($temperatureData));
        event(new HumidityUpdateEvent($humidityData));


        return $this->withArray([
            'sensor_id' => $sensor_id,
        ]);

   }





}
