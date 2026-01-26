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
    public function index(Request $request)
    {
        $tasks = Task::query()
            ->when($request->boolean('completed'), fn ($q) => $q->completed())
            ->when($request->boolean('pending'), fn ($q) => $q->pending())
            ->search($request->query('search'))
            ->latest()
            ->paginate();

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


        $task = $request->user()->tasks()->create(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'data' => new TaskResource($task),
            'message' => 'Task created successfully',
        ], 201);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $task->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => new TaskResource($task),
            'message' => 'Task updated successfully',
        ], 200);
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'Task deleted successfully',
        ], 200);
    }

    public function archived()
    {
        $tasks = Task::onlyTrashed()->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'data' => TaskResource::collection($tasks),
            'message' => 'Tasks archived successfully',
        ]);
    }

    public function restore(int $id)
    {
        $task = Task::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $task);

        $task = Task::onlyTrashed()->findOrFail($id);
        $task->restore();

        return response()->json([
            'success' => true,
            'message' => "Task restored successfully",
        ]);
    }
}
