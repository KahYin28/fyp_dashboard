<?php

namespace App\Http\Controllers;

use App\Http\Filters\StudentFilter;
use App\Http\Filters\VenueFilter;
use App\Http\UpdateSocket\TemperatureUpdate;
use App\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Redis;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request ,VenueFilter $filter)
    {
        $venue = Venue::filter($filter)
            ->pageList($filter->perPage(),$filter->sortType(),$filter->sortBy());
        return $venue;
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
            'temperature' => $request -> temperature,
            'name' => $request -> name,
        ];
        Venue::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $venue = Venue::findOrFail($id);
        return $venue;
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
    public function update(Request $request, $id)    {


        $update = Venue::findOrFail($id);
        $update ->update($request->all());
//        Redis::publish('temperature.update', $update);
        Event:: dispatch(new TemperatureUpdate($update));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $venue = Venue::findOrFail($id);
        $venue->delete();
    }
}
