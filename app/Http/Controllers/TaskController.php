<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Container\Attributes\Tag;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index() 
    {
        return response()->json(Task::all());
    }

    public function store(StoreTaskRequest $request) 
    {


        $task = Task::create($request->validated());

        return response()->json($task, 201);
    }

    public function update(UpdateTaskRequest $request, Task $task) 
    {


        $task->update($request->validated());

        return response()->json($task);
    }

    public function destroy(Task $task) 
    {
        $task->delete();

        return response()->json(null, 204);
    }
    
}
