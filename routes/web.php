<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Home Page
Route::get("/",[DashboardController::class,"index"]);

Route::get("/login",[AuthenticationController::class,"loginView"])->name('login');
Route::post("/login",[AuthenticationController::class,"loginSubmit"]);

Route::get("/logout",[DashboardController::class,"logout"])->name('logout');

Route::get("/register",[AuthenticationController::class,"registerView"]);

Route::post("/registerEmployer",[AuthenticationController::class,"storeEmployer"]);
Route::post("/registerEmployee",[AuthenticationController::class,"storeEmployee"]);

Route::get("/dashboard",[DashboardController::class,"dashboard"]);

Route::resource('task',TaskController::class);
