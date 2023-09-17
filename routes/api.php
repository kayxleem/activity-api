<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\API\UserActivityController;
use App\Http\Controllers\API\Usercontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    //Route::get('/activities',[Usercontroller::class,'userActivity']);
    Route::get('/activities',UserActivityController::class,);

});
Route::post('user/register', [Usercontroller::class,'register'])->name('user.register');

Route::post('user/login', [Usercontroller::class,'login'])->name('user.login');
Route::post('user/logout', [Usercontroller::class,'logout'])->name('user.logout');
