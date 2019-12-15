<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Http\Filters\LessonFilter;
use App\Lesson;
use App\Register;
use App\SensorData;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//transformer
use App\Http\Transformer\LessonTransformer;
use League\Fractal;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Manager;
use League\Fractal\Pagination\Cursor;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Validation\Validator;


class LessonController extends Controller
{
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return \League\Fractal\Manager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, LessonFilter $filter){

        $lessons = Lesson::filter($filter)
            ->with(['students'=>function($query) {
                $query->with('faculty');
                $query->with('emotions');
              }])
            ->with(['lesson_type'])
            ->with(['venue'])
           ->pageList($filter->perPage(),$filter->sortType(),$filter->sortBy());
      // $resource =  $this->withCollection($lessons, new LessonTransformer());

//        $lessons = Lesson ::filter($filter)
//            ->select(['venues.name as venue_name', 'lesson_types.name as lesson_name','students.name as student_name'])
//            ->leftJoin('venues', 'lessons.id', '=', 'venues.id')
//            ->leftJoin('registers', 'registers.lesson_id', '=', 'lessons.id' )
//            ->leftJoin('students', 'students.student_id', '=', 'registers.id' )
////            ->with(['students'=>function($query){
////             $query->with('faculty');
////           }])
//            ->leftJoin('lesson_types', 'lessons.lesson_type_id', '=', 'lesson_types.id')
////            ->with(['lesson_type'])
//            ->pageList($filter->perPage(),$filter->sortType(),$filter->sortBy());

      //  $resource = new Fractal\Resource\Collection($lessons, new LessonTransformer);
       return $lessons;
    }

    public function withItem($data, $transformer, $resourceKey = null, $meta = [], array $headers = [])
    {
        $resource = new Item($data, $transformer, $resourceKey);

        foreach ($meta as $metaKey => $metaValue) {
            $resource->setMetaValue($metaKey, $metaValue);
        }

        $rootScope = $this->manager->createData($resource);

        return $this->withArray($rootScope->toArray(), $headers);
    }

    public function withArray(array $array, array $headers = [])
    {
        return response()->json($array, '200', $headers);
    }

    /**
     * Respond with a paginator, and a transformer.
     *
     * @param LengthAwarePaginator $paginator
     * @param callable|\League\Fractal\TransformerAbstract $transformer
     * @param string $resourceKey
     * @param array $meta
     * @return ResponseFactory
     */
    public function withPaginator(LengthAwarePaginator $paginator, $transformer, $resourceKey = null, $meta = [])
    {
        $queryParams = array_diff_key($_GET, array_flip(['page']));
        $paginator->appends($queryParams);

        $resource = new Collection($paginator->items(), $transformer, $resourceKey);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        foreach ($meta as $metaKey => $metaValue) {
            $resource->setMetaValue($metaKey, $metaValue);
        }

        $rootScope = $this->manager->createData($resource);

        return $this->withArray($rootScope->toArray());
    }


    /**
     * Response for collection of items
     *
     * @param $data
     * @param callable|\League\Fractal\TransformerAbstract $transformer
     * @param string $resourceKey
     * @param Cursor $cursor
     * @param array $meta
     * @param array $headers
     * @return mixed
     */
    public function withCollection($data, $transformer, $resourceKey = null, Cursor $cursor = null, $meta = [], array $headers = [])
    {
        $resource = new Collection($data, $transformer, $resourceKey);

        foreach ($meta as $metaKey => $metaValue) {
            $resource->setMetaValue($metaKey, $metaValue);
        }

        if (!is_null($cursor)) {
            $resource->setCursor($cursor);
        }

        $rootScope = $this->manager->createData($resource);

        return $this->withArray($rootScope->toArray(), $headers);
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
    public function store(Request $request){
        $input = $request->all();
        $register = Register::where('lesson_id', $input['lesson_id'])->join('lessons','registers.lesson_id','lessons.id')->get();
      //  dd($register);
      //  dd($register[0]['lesson_id']);
        $now = Carbon::now();

        $finalArray = array();
        foreach($register as $key=>$value){
            array_push($finalArray, array(
                'lesson_id'=> $value['lesson_id'],
              'student_id' => $value['student_id'],
              'starting_date_time' => $value['starting_date_time'],
              'ending_date_time' => $value['ending_date_time'],
              'status' => 0,
              'created_at'=> $now->toDateTimeString())
            );
        };

       // Model::insert($finalArray);
        if($register && $finalArray) {
         //   dd($finalArray);
            Attendance::insert($finalArray);
            return $this->withArray([
                'success' => [
                    'code' => 'success',
                    'http_code' => 200,
                    'message' => ' success'
                ]
            ]);
        }else{
            return $this->withArray([
                'error' => [
                    'code' => 'error',
                    'http_code' => 400,
                    'message' => ' fail'
                ]
            ]);
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
        try {
        DB::beginTransaction();

        $haha= Lesson::findOrFail($id);
        if($haha->status == 1){
            DB::commit();
            return $this->withArray([
                'error' => [
                    'code' => 'error',
                    'http_code' => 200,
                    'message' => 'The status alrdy updated.'
                ]
            ]);
        }else {
            $haha->setAttribute('status', 1);
            $haha->save();
        }

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
