<?php

use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return response()->json([
        "message" => "Laravel 11 Daily – Day 1",
        "status" => "OK",
    ]);
});
