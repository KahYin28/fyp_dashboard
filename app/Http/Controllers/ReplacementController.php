<?php

namespace App\Http\Controllers;

use App\Http\Filters\ReplacementFilter;
use App\Replacement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReplacementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,ReplacementFilter $filter) {
        $replace = Replacement::filter($filter)
            ->with(['lessons'])
//            ->with(['venue'])
//            ->with(['user'])
            ->paginate(5);

        return $replace;
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
    public function store(Request $request) {
        try {
            DB::beginTransaction();
            Replacement::create([
                'user_id' => $request -> user_id,
                'lesson_id' => $request -> lesson_id,
                'venue_id' => $request -> venue_id,
                'schedule_day' => $request -> schedule_day,
                'starting_date_time' => $request->starting_date_time,
                'ending_date_time' => $request->ending_date_time,
                'status' => $request -> status,
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
