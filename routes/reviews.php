<?php

use App\Http\Controllers\api\CandidateInterviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth.jwt'], function(){
    Route::get('/reviews', [CandidateInterviewController::class, 'list'])->name('reviews');
    Route::post('/reviews/create', [CandidateInterviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews/edit/{id}', [CandidateInterviewController::class, 'edit'])->name('reviews.edit');
    Route::get('/reviews/show/{id}', [CandidateInterviewController::class, 'show'])->name('reviews.show');
    Route::delete('/reviews/delete/{id}', [CandidateInterviewController::class, 'remove'])->name('reviews.delete');
});