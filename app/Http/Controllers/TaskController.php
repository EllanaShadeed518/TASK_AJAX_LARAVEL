<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public  function index(){
        $tasks=Task::all();
        return view('Task.index',compact('tasks'));
    }
    public function store(Request $request){


$validator=Validator::make($request->all(),[
    'title'=>'required |string|max:10',
    'priority'=>'required',


]);
if($validator->fails()){
    return response()->json(['msg'=>$validator->errors(),


]);
    }
    else{
        Task::create([
            'title'->$request->title,
            'priority'->$request->priority,
        ]);
    return response()->json(['msg'=>"task add succsesfully",
      "tasks"=>$tasks,
]);
}
}}
