<?php

use App\Http\Controllers\api\CandidateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/candidate', [CandidateController::class, 'list'])->name('candidate');
Route::post('/candidate/create', [CandidateController::class, 'create'])->name('candidate.create');
Route::put('/candidate/edit/{id}', [CandidateController::class, 'edit'])->name('candidate.edit');
Route::delete('/candidate/delete/{id}', [CandidateController::class, 'remove'])->name('candidate.delete');
