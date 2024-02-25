<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TimestampController;
use App\Http\Controllers\AttendanceListController;

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

// ユーザー登録画面
Route::get('/register', [RegisteredUserController::class, 'create']);
// ユーザー登録機能
Route::post('/register',[RegisteredUserController::class, 'store']);

// ログイン画面表示
Route::get('/login',[AuthenticatedSessionController::class, 'create'])->name('login');
// Route::get('/login',[AuthenticatedSessionController::class, 'store']);

// ログイン機能
Route::post('/login',[AuthenticatedSessionController::class, 'store']);

// ログアウト機能
Route::get('/logout',[AuthenticatedSessionController::class, 'destroy'])->middleware('auth');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/',[TimestampController::class, 'create']);
    Route::post('/punchin',[TimestampController::class, 'punchIn'])->name('punchIn');
    Route::post('/punchout',[TimestampController::class, 'punchOut'])->name('punchOut');
    Route::post('/breakin',[TimestampController::class, 'breakIn']);
    Route::post('/breakout',[TimestampController::class, 'breakOut']);
    Route::get('/attendance', [AttendanceListController::class,'index'])->name('attendance');
    Route::get('/users_list', [AttendanceListController::class,'users_list'])->name('users_list');
    Route::get('/{user}/user_attendance_list', [AttendanceListController::class,'user_attendance_list'])->name('user_attendance_list');
});

