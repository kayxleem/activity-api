<?php

use App\Http\Controllers\Admin\AdminActivityController;
use App\Http\Controllers\Admin\Admincontroller;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/admin', [Admincontroller::class, 'index'])->name('admin.dashboard');
// Route::get('/admin/login', [Admincontroller::class, 'login'])->name('admin.show.login');
// Route::post('/admin/login', [Admincontroller::class, 'processLogin'])->name('admin.login');

Route::prefix('/admin')->group(function ($route) {
    //$route->get('/', Admincontroller::class);
    $route->get('/',  [Admincontroller::class, 'index'])->name('admin');
    $route->get('/login', [Admincontroller::class, 'index'])->name('admin.show.login');
    $route->post('/login', [Admincontroller::class, 'login'])->name('admin.login');
    $route->get('/logout', [Admincontroller::class, 'logout'])->name('admin.logout');


    Route::middleware('admin')->group(function(){
        //Route::get('/dashboard',  [Admincontroller::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/dashboard',  [AdminActivityController::class, 'getAllActivities'])->name('admin.dashboard');
        Route::get('/createActivity',  [AdminActivityController::class, 'createActivityView'])->name('admin.create.activity.view');
        //Route::get('/activities',  [AdminActivityController::class, 'getAllActivities'])->name('admin.activities')->middleware('admin');
    });

});

require __DIR__.'/auth.php';
