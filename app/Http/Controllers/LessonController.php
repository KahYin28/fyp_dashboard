<?php

namespace App\Http\Controllers;

use App\Http\Filters\LessonFilter;
use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index(Request $request, LessonFilter $filter){
        $lessons = Lesson::filter($filter)
            ->with(['students'=>function($query){
                $query->with('faculty');
            }])
            ->with(['lesson_type'])
            ->pageList($filter->perPage(),$filter->sortType(),$filter->sortBy());
        return $lessons;
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
    public function store(Request $request){
//        $data = [
//
////data => $request -> $user -> param
//        ];
        try {
            DB::beginTransaction();
            Lesson::create([
                'starting_date_time' => $request->starting_date_time,
                'ending_date_time' => $request->ending_date_time,
                'course_code' => $request->course_code,
                'lesson_type_id' => $request->lesson_type_id,
                'semester' => $request->semester,
            ]);

            DB::commit();

            return $this->withArray([
                'success' => [
                    'code' => 'success',
                    'http_code' => 200,
                    'message' => 'Transaction success'
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollback();
//            $this->logger->errorLog($request, $e, _CLASS_, _FUNCTION_);
          //  return $this->response->errorInternalError('Internal Server Error');
            return $this->withArray([
                'error' => [
                    'code' => 'error',
                    'http_code' => 400,
                    'message' => 'Transaction failed'
                ]
            ]

            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Lesson::findOrFail($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        //
    }


}
