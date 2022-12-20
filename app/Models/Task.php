<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tasks';

    protected $fillable = ['title', 'due-date', 'states', 'parent-id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'parent-id'];


    static public function get_parent_task($task){
        return $task = Task::where('title', $task)->get();
        if(!empty($task)){
            return $task[0];
        }
        return [];
    }

    static public function store_task($request, $parent_id=null){
        $task = [
            'title' => $request['title'],
            'due-date' => $request['due-date'],
        ];

        if($parent_id){
            $task['parent-id'] = $parent_id;
        }


        return Task::create($task);
    }

    static public function get_all_chiled_task($id){
        return Task::where('parent-id', $id)->orderBy('due-date', 'asc')->get();
    }

    static public function update_task_stetes($id, $states){
        return Task::where('parent-id', $id)->orWhere('id', $id)->update(['states' => $states]);
    }
}

