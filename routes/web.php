<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\Admincontroller;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminActivityController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::prefix('/admin')->group(function ($route) {
    //$route->get('/', Admincontroller::class);
    $route->get('/',  [Admincontroller::class, 'index'])->name('admin');
    $route->get('/login', [Admincontroller::class, 'index'])->name('admin.show.login');
    $route->post('/login', [Admincontroller::class, 'login'])->name('admin.login');
    $route->get('/logout', [Admincontroller::class, 'logout'])->name('admin.logout');


    Route::middleware('admin')->group(function(){
        //Route::get('/dashboard',  [Admincontroller::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/dashboard',  [AdminActivityController::class, 'getAllActivities'])->name('admin.dashboard');

        Route::get('/users',  [AdminUserController::class, 'users'])->name('admin.users.show');

        Route::get('/addActivity',  [AdminActivityController::class, 'addActivityView'])->name('admin.create.activity.view');
        Route::post('/addActivity',  [AdminActivityController::class, 'addActivity'])->name('admin.add.activity');
        Route::get('/editActivity/{id}',  [AdminActivityController::class, 'editActivityView'])->name('admin.edit.activity.view');
        Route::post('/editActivity/{id}',  [AdminActivityController::class, 'editActivity'])->name('admin.edit.activity');
        Route::get('/deleteActivity/{id}',  [AdminActivityController::class, 'destroy'])->name('admin.activity.delete');
        //Route::get('/activities',  [AdminActivityController::class, 'getAllActivities'])->name('admin.activities')->middleware('admin');
    });

});

require __DIR__.'/auth.php';
