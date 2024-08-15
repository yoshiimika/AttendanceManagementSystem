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

// 日付別管理ページの表示
Route::get('/attendance/date', [AttendanceController::class, 'indexDate'])
    ->name('attendance/date');
Route::post('/attendance/date', [AttendanceController::class, 'perDate'])
    ->name('per/date');

// 勤怠表の表示
Route::get('/attendance/user', [AttendanceController::class, 'indexUser'])
    ->name('attendance/user');
Route::post('/attendance/user', [AttendanceController::class, 'perUser'])
    ->name('per/user');

// ユーザー別管理ページの表示
Route::get('/user', [AttendanceController::class, 'user'])
    ->name('user');