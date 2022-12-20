<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Http\Requests\TaskDueDateSearchRequest; 
use App\Http\Requests\TaskTitleSearchRequest; 
use App\Models\Task;
use Carbon\Carbon;

class TaskSearchControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function byTitle(TaskTitleSearchRequest $request)
    {
        $tasks = Task::where('title', 'like', $request['title'].'%')->where('states', 'Pending')->orderBy('due-date', 'asc')->get();
        return response()->json($tasks);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function byDueDate(TaskDueDateSearchRequest $request)
    {
        $carbon_now = Carbon::now(); //'Today', 'This Week', 'Next Week', 'Overdue'

        $tasks = [];
        switch ($request['due-date']) {
            case 'Today':
                $tasks = Task::where('due-date', $carbon_now->format('Y-m-d'))->get();
                break;
            case 'This Week':
                $weekStartDate = $carbon_now->startOfWeek()->format('Y-m-d');
                $weekEndDate = $carbon_now->endOfWeek()->format('Y-m-d');

                $tasks = Task::where('due-date', '>=', $weekStartDate)->where('due-date', '<=', $weekEndDate)->get();
                break;
            case 'Next Week':
                $weekStartDate = $carbon_now->addWeek()->startOfWeek()->format('Y-m-d');
                $weekEndDate = $carbon_now->addWeek()->endOfWeek()->format('Y-m-d');

                $tasks = Task::where('due-date', '>=', $weekStartDate)->where('due-date', '<=', $weekEndDate)->get();
                break;
            case 'Overdue':
                $tasks = Task::where('due-date', '<', $carbon_now->format('Y-m-d'))->get();
                break;
            
            // default:
            //     # code...
            //     break;
        }

        return response()->json($tasks);
    }
}