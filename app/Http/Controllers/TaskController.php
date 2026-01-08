<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Container\Attributes\Tag;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index() 
    {
        return response()->json(Task::all());
    }

    public function store(Request $request) 
    {
        $task = Task::create($request->only(['title', 'description']));
        return response()->json($task, 201);
    }
}
