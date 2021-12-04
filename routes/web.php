<?php

use App\Http\Controllers\UserManageController;
use App\Http\Controllers\VideosController;

use App\Http\Controllers\VideosManageController;
use Illuminate\Support\Facades\Route;


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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/videos/{id}', [VideosController::class,'show']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/manage/videos', [VideosManageController::class,'index'])->middleware(['can:videos_manage_index'])->name('manage.videos');
    Route::post('/manage/videos', [VideosManageController::class,'store'])->middleware(['can:videos_manage_store']);
    Route::delete('/manage/videos/{id}', [VideosManageController::class,'destroy'])->middleware(['can:videos_manage_delete']);

    Route::get('/manage/users', [ UserManageController::class,'index'])->middleware(['can:users_manage_create'])->name('manage.users');
    Route::post('/manage/users',[ UserManageController::class,'store' ])->middleware(['can:users_manage_store']);
    Route::delete('/manage/users/{id}',[ UserManageController::class,'destroy' ])->middleware(['can:users_manage_destroy']);
});
