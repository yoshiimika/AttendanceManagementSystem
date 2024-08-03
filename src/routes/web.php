<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//打刻ページの表示
Route::get('/',[AttendanceController::class,'punch'])
    ->middleware('auth','verified');

// 打刻機能
Route::post('/work', [AttendanceController::class, 'work'])
    ->name('work');

// 管理ページの表示
Route::get('/attendance', [AttendanceController::class, 'indexDate'])
    ->name('attendance');
Route::post('/attendance', [AttendanceController::class, 'perDate'])
    ->name('per/date');