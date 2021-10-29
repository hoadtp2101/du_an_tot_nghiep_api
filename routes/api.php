<?php

use App\Http\Controllers\api\CandidateController;
use App\Http\Controllers\api\CandidateInterviewController;
use App\Http\Controllers\api\JobRequestController;
use App\Http\Controllers\AuthController;
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
Route::post('/candidate/edit/{id}', [CandidateController::class, 'edit'])->name('candidate.edit');
Route::delete('/candidate/delete/{id}', [CandidateController::class, 'remove'])->name('candidate.delete');

Route::get('/jobrequest', [JobRequestController::class, 'list'])->name('jobrequest');
Route::post('/jobrequest/create', [JobRequestController::class, 'create'])->name('jobrequest.create');
Route::post('/jobrequest/edit/{id}', [JobRequestController::class, 'edit'])->name('jobrequest.edit');
Route::post('/jobrequest/approve/{id}', [JobRequestController::class, 'approve'])->name('jobrequest.approve');
Route::delete('/jobrequest/delete/{id}', [JobRequestController::class, 'remove'])->name('jobrequest.delete');

Route::get('/judge', [CandidateInterviewController::class, 'list'])->name('judge');
Route::post('/judge/create', [CandidateInterviewController::class, 'create'])->name('judge.create');
Route::post('/judge/edit/{id}', [CandidateInterviewController::class, 'edit'])->name('judge.edit');
Route::get('/judge/show/{id}', [CandidateInterviewController::class, 'show'])->name('judge.show');

Route::get('/export', [CandidateController::class, 'export']);
Route::post('/import', [CandidateController::class, 'import']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/logout', [AuthController::class, 'logout']);    
});