<?php

namespace App\Http\Controllers;
use App\Aircon;
use App\Http\Filters\AirconFilter;
use Illuminate\Http\Request;
use App\Http\Resources\Aircon as AirConResource;

class AirconController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, AirconFilter $filter)
    {
        $aircon = Aircon::filter($filter)->pageList($filter->perPage(),$filter->sortType(),$filter->sortBy());
        return $aircon;
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
        Aircon::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $aircon = Aircon::findOrFail($id);
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
        Aircon::findOrFail($id)->update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aircon = Aircon::findOrFail($id);
        $aircon->delete();
    }
}
