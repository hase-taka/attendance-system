<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TimestampController;

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
Route::get('/login',[AuthenticatedSessionController::class, 'create']);
// Route::get('/login',[AuthenticatedSessionController::class, 'store']);

// ログイン機能
Route::post('/login',[AuthenticatedSessionController::class, 'store']);

// ログアウト機能
Route::get('/logout',[AuthenticatedSessionController::class, 'destroy'])->middleware('auth');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/',[TimestampController::class, 'create']);
    Route::post('/punchin',[TimestampController::class, 'punchIn']);
    Route::post('/punchout',[TimestampController::class, 'punchOut']);
    Route::post('/breakin',[TimestampController::class, 'breakIn']);
    Route::post('/breakout',[TimestampController::class, 'breakOut']);
    Route::get('/attendance', [TimestampController::class,'admin']);
    Route::post('/attendance', [TimestampController::class,'result']);

});

// ログイン後-打刻画面表示
// ->middleware('auth');
// // 打刻機能
// ->middleware('auth');



// Route::get('/', function () {
//     return view('welcome');
// });
