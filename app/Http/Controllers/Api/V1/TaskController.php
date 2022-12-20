<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Http\Requests\TaskStoreRequest; 
use App\Http\Requests\TaskUpdateRequest; 
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::where('states', 'Pending')->orderBy('due-date', 'asc')->get();
        return response()->json($tasks);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskStoreRequest $request)
    {
        if(empty($request['parent-task'])){
            $task = Task::store_task($request);
            return response()->json($task);
        }
        $parent_task = Task::get_parent_task($request['parent-task']);
        if(count($parent_task) == 0){
            return response()->json(['status' => "The parent task not found."]);
        } else {
            $parent_task = $parent_task[0];
            if(!empty($parent_task['parent-id'])){
                return response()->json(['status' => "The mentioned parent task already subtask of another task."]);
            }
            $parent_id = $parent_task['id'];
        }
        $task = Task::store_task($request, $parent_id);
        return response()->json($task);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = [
            'current_task' => Task::find($id),
            'sub_task' => Task::get_all_chiled_task($id)
        ];
 
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskUpdateRequest $request, $id)
    {
        $task = Task::find($id);
        if(!empty($task)){
            if($task['states'] == $request['states']){
                $status = ['status' => "Already Completed"];
            } else {
                $status = ['updated_rows' => Task::update_task_stetes($id, $request['states'])];
            }
        } else {
            $status = ['status' => "Not found"];
        }
        
        return response()->json( $status );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = ['delete_status' => Task::find($id)->delete()];
        return response()->json( $task );
    }
}
