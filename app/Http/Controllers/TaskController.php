<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Container\Attributes\Tag;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::latest()->paginate(10);

        return response()->json([
            'success' => true,
            'data' => TaskResource::collection($tasks),
            'message' => $tasks->isEmpty()
                ? 'No task found'
                : 'Tasks retrieved successfully',
            'meta' => [
                'current_page' => $tasks->currentPage(),
                'last_page' => $tasks->lastPage(),
                'per_page' => $tasks->perPage(),
                'total' => $tasks->total(),
            ],
        ], 200);
    }

    public function store(StoreTaskRequest $request)
    {


        $task = Task::create($request->validated());

        return response()->json([
            'success' => true,
            'data' => new TaskResource($task),
            'message' => 'Task created successfully',
        ], 201);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {


        $task->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => new TaskResource($task),
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
