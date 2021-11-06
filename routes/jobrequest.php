<?php

use App\Http\Controllers\api\JobRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth.jwt'], function(){
    Route::get('/jobrequest', [JobRequestController::class, 'list'])->name('jobrequest');
    Route::post('/jobrequest/create', [JobRequestController::class, 'create'])->name('jobrequest.create');
    Route::post('/jobrequest/edit/{id}', [JobRequestController::class, 'edit'])->name('jobrequest.edit');
    Route::post('/jobrequest/approve/{id}', [JobRequestController::class, 'approve'])->name('jobrequest.approve');
    Route::delete('/jobrequest/delete/{id}', [JobRequestController::class, 'remove'])->name('jobrequest.delete');
});