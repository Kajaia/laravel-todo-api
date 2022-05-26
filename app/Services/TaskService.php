<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskService {

    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function createTask() 
    {
        $task = Task::create([
            'title' => $this->request->title,
            'status' => $this->request->status
        ]);

        return $task;
    }

    public function updateTaskTitle($id)
    {
        $task = Task::findorfail($id);

        $task->update(['title' => $this->request->title]);

        return $task;
    }

    public function doneTask($id)
    {
        $task = Task::findorfail($id);

        if($task->status) {
            $task->update(['status' => 0]);
        } else {
            $task->update(['status' => 1]);
        }

        return $task;
    }

}