<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth.jwt', 'can:hrManager,App\User'])
    ->group(function (){
        Route::prefix('user')->group(function (){
            Route::get('user-detail/{user}', [\App\Http\Controllers\api\UserController::class,'show']);
            Route::post('regsiter-member', [\App\Http\Controllers\api\UserController::class,'store']);
            Route::delete('destroy/{user}', [\App\Http\Controllers\api\UserController::class,'destroy']);
            Route::post('update-member/{user}', [\App\Http\Controllers\api\UserController::class,'update']);
            Route::post('disable-member/{user}', [\App\Http\Controllers\api\UserController::class,'disableUser']);
        });

    });

Route::get('user/list-role',[\App\Http\Controllers\api\UserController::class,'listRoleUserLogin'])->middleware('auth.jwt');
Route::post('user/update-profile-login',[\App\Http\Controllers\api\UserController::class,'updateProfile'])->middleware('auth.jwt');
Route::get('list-user', [\App\Http\Controllers\api\UserController::class,'index'])->middleware('auth.jwt');
