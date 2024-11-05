<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\GeneralController;
use Illuminate\Support\Facades\Route;




Route::middleware('guest')->group(function (){
    Route::get('/register', [RegisteredUserController::class, 'create']);
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/login', [SessionController::class, 'create']);
    Route::post('/login', [SessionController::class, 'store']);

});
Route::get('/', [SessionController::class, 'create']);
Route::get('/dashboard', [GeneralController::class, 'dashboard']);

Route::delete('/logout', [SessionController::class, 'destroy']);


