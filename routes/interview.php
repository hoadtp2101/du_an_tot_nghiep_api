<?php

use App\Http\Controllers\InterviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('interviews', InterviewController::class)
    ->only(['update', 'index', 'store', 'destroy', 'show']);
