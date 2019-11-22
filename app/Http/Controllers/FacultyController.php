<?php

namespace App\Http\Controllers;

use App\Faculty;
use App\Http\Filters\FacultyFilter;
use Illuminate\Http\Request;
use App\Http\Resources\Faculty as FacultyResource;


class FacultyController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param FacultyFilter $filter
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, FacultyFilter $filter)
    {
        $faculties = Faculty::filter($filter)->pageList($filter->perPage(),$filter->sortType(),$filter->sortBy());
        return $faculties;
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
        $data = [
            'id' => $request -> id,
            'name' => $request -> name,
        ];
        Faculty::create($data);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $faculty = Faculty::findOrFail($id);
        return $faculty;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)    {
        $faculty = Faculty::findOrFail($id);
        $faculty->delete();
    }



}
