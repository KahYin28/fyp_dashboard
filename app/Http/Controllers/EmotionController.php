<?php

namespace App\Http\Controllers;

use App\Emotion;
use App\Http\Filters\EmotionFilter;
use Illuminate\Http\Request;

class EmotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,EmotionFilter $filter)
    {
        $emotions = Emotion::filter($filter)
                    ->with(['student'])
                    ->pageList($filter->perPage(),$filter->sortType(),$filter->sortBy());
//        dd($emotions);
        return $emotions;
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
            'student_id'=> $request -> student_id,
            'happy' => $request -> happy,
            'sad' => $request -> sad,
            'angry' => $request -> angry,
            'confused' => $request -> confused,
            'disgusted' => $request -> disgusted,
            'surprised' => $request -> surprised,
            'calm' => $request -> calm,
            'unknown' => $request -> unknown,
            'fear' => $request -> fear,
            'created_at' => $request -> created_at,
            'updated_at' => $request ->updated_at
        ];
        Emotion::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Emotion  $emotion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $emotion = Emotion::where('student_id', $id)->first();

        return $emotion;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Emotion  $emotion
     * @return \Illuminate\Http\Response
     */
    public function edit(Emotion $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Emotion  $emotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Emotion  $emotion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $emotion = Emotion::findOrFail($id);
        $emotion->delete();
    }
}
