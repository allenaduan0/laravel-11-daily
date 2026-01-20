<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;
use App\Http\Controllers\Api\V1\AuthController;

//Route::get("/", function () {
//    return response()->json([
//        "message" => "Laravel 11 Daily – Day 1",
//        "status" => "OK",
//    ]);
//});
//
//Route::get("/tasks", [TaskController::class, "index"]);
//Route::post("/tasks", [TaskController::class, "store"]);
//Route::put("/tasks/{task}", [TaskController::class, "update"]);
//Route::delete("/tasks/{task}", [TaskController::class, "destroy"]);

Route::prefix('api/v1')->middleware('api')->group(function () {
   Route::post('/login', [AuthController::class, 'login']);

   Route::middleware('auth:sanctum')->group(function () {
       Route::apiResource('tasks', TaskController::class);
   });
});
