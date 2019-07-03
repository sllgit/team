<?php

namespace App\Http\Controllers;

use App\Model\Student;
use http\Env\Response;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = new Student();

        $_GET['page'] = $request->page ?? 1;
        $pagesize = $request->pagesize ?? 10;
        $order = $request->order ?? "id";
        $sort = $request->sort ?? 'asc';

        $data = Student::orderBy($order,$sort)->paginate($pagesize);
        return $data;
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
        //
        \request()->validate([
            'name'=>'required|string',
            'sex'=>'required',
            'age'=>'required|integer',
        ]);

        try{
            $student = Student::create(\request()->all());
        }catch (\Throwable $e){
            return \response(['error'=>$e->getMessage()],401);
        }
        return \response($student,200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        //
        $student = Student::find($id);
        if(!$student){
            return \response(['error'=>'该条记录不存在'],404);
        }

        \request()->validate([
            'name'=>'required|string',
            'sex'=>'required',
            'age'=>'required|integer',
        ]);
        $student -> name = $request->name;
        $student -> sex = $request->sex;
        $student -> age = $request->age;

        try{
            $student->save();
        }catch(\Throwable $e){
            return \response(['error'=>$e->getMessage()],417);
        }
        return \response($student);
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
        $student = Student::find($id);
        if(!$student){
            return \response(['error'=>'该条记录不存在'],404);
        }

        try{
            $res = $student->delete();
        }catch (\Throwable $e){
            return \response(['error'=>$e->getMessage()],417);
        }
        return \response(['data'=>"delete successfully"],200);
    }
}
