<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;

Route::get("/", function () {
    return response()->json([
        "message" => "Laravel 11 Daily – Day 1",
        "status" => "OK",
    ]);
});

Route::get("/tasks", [TaskController::class, "index"]);
Route::post("/tasks", [TaskController::class, "store"]);
