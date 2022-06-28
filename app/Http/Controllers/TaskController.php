<?php

namespace App\Http\Controllers;

use App\Events\TaskDeleted;
use App\Events\TasksCleared;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected Request $request;
    protected TaskService $service;

    public function __construct(Request $request, TaskService $service)
    {
        $this->request = $request;
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Task $task)
    {
        return TaskResource::collection($task->getFilteredTasks($this->request));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        return new TaskResource($this->service->createTask());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new TaskResource(Task::findorfail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Task $task)
    {
        return new TaskResource($this->service->updateTaskTitle($task->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findorfail($id)->delete();

        event(new TaskDeleted);

        return response()->json($task);
    }

    public function done($id)
    {
        return $this->service->doneTask($id);
    }

    public function clear() {
        $tasks = Task::where('status', true)->delete();

        event(new TasksCleared);

        return response()->json($tasks);
    }
}
