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
        return response()->json([
            'success' => true,
            'data' => Task::all(),
            'message' => 'Tasks retrieved successfully',
        ], 200);
    }

    public function store(StoreTaskRequest $request)
    {


        $task = Task::create($request->validated());

        return response()->json([
            'success' => true,
            'data' => $task,
            'message' => 'Task created successfully',
        ], 201);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {


        $task->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $task,
            'message' => 'Task updated successfully',
        ], 200);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'Task deleted successfully',
        ], 200);
    }
}
