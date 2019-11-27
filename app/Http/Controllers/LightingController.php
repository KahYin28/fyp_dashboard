<?php

namespace App\Http\Controllers;

use App\Http\Filters\LightingFilter;
use App\Lighting;
use Illuminate\Http\Request;

class LightingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,LightingFilter $filter)
    {
        $lightings = Lighting::filter($filter)->pageList($filter->perPage(),$filter->sortType(),$filter->sortBy());
        return $lightings;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
            'on_off' => $request -> on_off,
            'created_at' => $request -> created_at,
            'updated_at' => $request ->updated_at
        ];
        Lighting::create($data);
        Redis::publish('temperatureChannel',$data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lighting  $lighting
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lighting = Lighting::findOrFail($id);
        return $lighting;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lighting  $lighting
     * @return \Illuminate\Http\Response
     */
    public function edit(Lighting $lighting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lighting  $lighting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        Lighting::findOrFail($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lighting  $lighting
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lighting = Lighting::findOrFail($id);
        $lighting->delete();
    }


}
