<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[TaskController::class,'index'])->name('task-index');
Route::post('/task/store',[TaskController::class,'store'])->name('task-store');
Route::delete('/task/delete/{id}',[TaskController::class,'destroy'])->name('task-delete');
Route::post('/task/change-status/{id}',[TaskController::class,'change_status'])->name('task-status');
Route::get('/task/search',[TaskController::class,'search'])->name('task-search');
