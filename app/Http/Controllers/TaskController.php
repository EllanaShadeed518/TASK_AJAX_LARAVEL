<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public  function index(){
       $tasks=Task::select('*')->orderBy("priority","asc")->get();

        return view('Task.index',compact('tasks'));
    }
    public function store(Request $request){


    $validator=Validator::make($request->all(),[
    'title'=>'required |string|max:10',
    'priority'=>'required',


]);

if($validator->fails()){
    return response()->json(['status'=>0,'error'=>$validator->errors()->toArray(),


]);
    }
    else{

       $task= Task::create([
            'title'=>$request->title,
            'priority'=>$request->priority,
        ]);
    return response()->json(['msg'=>"task add succsesfully",
      "tasks"=>$task,
]);
}}





public function destroy($id){
   $task=Task::find($id);

    $task->delete();
    return response()->json(['msg'=>"task deleted succesfully",
    'task'=>$task]);
}
public function change_status($id){
    $task=Task::find($id);
    if($task->status=="pinned"){
        $task->update([
'status'=>"completed"
        ]);


    }
    else{

        $task->update([
            "status"=>"pinned"
                    ]);

    }
    return response()->json(['msg'=>"task change-status succsesfully",
    "tasks"=>$task,]);
}


public function search(Request $request){

    $validator=Validator::make($request->all(),[
        'title'=>'required |string|max:10',


    ]);

    if($validator->fails()){
        return response()->json(['status'=>0,'error'=>$validator->errors()->toArray(),


    ]);
        }
        else{

            if($request->ajax())
{
$output="";
$loop=0;
$priority="";
$tasks= Task::where('title','LIKE','%'.$request->title.'%')->get();

if($tasks)
{
foreach ($tasks as $task) {
    $loop++;
    if($task->priority==1){
$priority="High";
    }
    if($task->priority==2){
        $priority="Mid";

            

            }
            if($task->priority==3){
                $priority="Low";
                    }

$output.='<tr>'.
'<td>'.$loop.'</td>'.
'<td>'.$task->title.'</td>'.


'<td >'.$priority.'</td>'.
'<td>'.$task->status.'</td>'.
'</tr>';



}return response()->json(['tasks'=>$output]);
}}

}}

}
