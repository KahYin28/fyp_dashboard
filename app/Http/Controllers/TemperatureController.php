<?php

namespace App\Http\Controllers;

use App\Events\TemperatureUpdateEvent;
use App\Temperature;
use App\Http\Filters\TemperatureFilter;
use Illuminate\Http\Request;
use App\Http\Resources\Aircon as AirConResource;

class TemperatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TemperatureFilter $filter)
    {
        $aircon = Temperature::filter($filter)
            ->pageList($filter->perPage(),$filter->sortType(),$filter->sortBy());


        return $aircon;
    //    event(new TemperatureUpdateEvent($data));

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
    public function store(Request $request)
    {
        $data = [
            'id' => $request -> id,
            'venue_id'=> $request -> venue_id,
            'set_point' => $request -> set_point,
            'name' => $request -> name,
            'created_at' => $request -> created_at,
            'updated_at' => $request ->updated_at
        ];
        Temperature::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $aircon = Temperature::findOrFail($id);
        return $aircon;
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
    public function update(Request $request, $id)
    {
        //var_dump($request->all());
       // event(new TemperatureUpdateEvent($request->all()));
        event(new TemperatureUpdateEvent([33, 24, 45, 45, 27, 32, 30, 19, 22, 25]));
        Temperature::findOrFail($id)->update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aircon = Temperature::findOrFail($id);
        $aircon->delete();
    }
}
