<?php

use App\Http\Controllers\api\JobRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth.jwt'], function(){
    Route::get('/jobrequest', [JobRequestController::class, 'list'])->name('jobrequest');
    Route::post('/jobrequest/create', [JobRequestController::class, 'create'])->name('jobrequest.create')->middleware('can:create,App\JobRequest');
    Route::post('/jobrequest/edit/{jobRequest}', [JobRequestController::class, 'update'])->name('jobrequest.update')->middleware('can:update,jobRequest');
    Route::post('/jobrequest/approve/{id}', [JobRequestController::class, 'approve'])->name('jobrequest.approve');
    Route::delete('/jobrequest/delete/{id}', [JobRequestController::class, 'remove'])->name('jobrequest.delete');
});