<?php

use App\Http\Controllers\api\InterviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('interviews', InterviewController::class)
    ->only(['update', 'index', 'store', 'destroy', 'show']);
    
Route::group(['middleware' => 'auth.jwt'], function () {
    Route::resource('interviews', InterviewController::class)
        ->only(['update', 'index', 'store', 'destroy', 'show']);
});
