<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\BudgetController;
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
Route::delete('/logout', [SessionController::class, 'destroy']);

Route::get('/history', [GeneralController::class, 'history']);
Route::get('/dashboard', [GeneralController::class, 'dashboard']);
Route::get('/dashboard/{id}', [GeneralController::class, 'dashboard']);
Route::get('/budgets/{id}/transactions', [GeneralController::class, 'showTransactions']);

Route::get('/budgets', [BudgetController::class, 'list']);
Route::get('/budgets/{id}', [BudgetController::class, 'view']);
Route::get('/budgets/{id}/{status}', [BudgetController::class, 'view']);
Route::delete('/budgets/{id}', [BudgetController::class, 'destroy']);
Route::post('/budgets', [BudgetController::class, 'create']);
Route::patch('/budgets', [BudgetController::class, 'update']);

Route::get('/transactions', [TransactionController::class, 'list']);
Route::post('/transactions', [TransactionController::class, 'create']);
Route::patch('/transactions', [TransactionController::class, 'update']);
Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);


