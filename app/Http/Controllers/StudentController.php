<?php

namespace App\Http\Controllers;

use App\Http\Filters\StudentFilter;
use App\Student;
use Illuminate\Http\Request;
use App\Http\Resources\Student as StudentResource;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request ,StudentFilter $filter)
    {
       $students = Student::filter($filter)
                    ->with(['faculty'])
                    ->with(['lessons'])
                    ->paginate(5);

//       ->pageList($filter->perPage(),$filter->sortType(),$filter->sortBy());

   //    pageList($filter->perPage(),$filter->sortType(),$filter->sortBy());
        // dd($students);//return collection of students as a resource
         // return StudentResource::collection($students);
//        foreach ($students['data'] as $student){
//            $student->faculty_name = $student->faculty->faculty_name;
//        }
        return $students;
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
            'student_id' => $request -> student_id,
            'faculty_id' => $request -> faculty_id,
            'programme' => $request -> programe,
            'name' => $request -> name,
        ];
        Student::create($data);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $student = Student::findOrFail($id);
        return  $student;
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
        Student::findOrFail($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
    }
}
