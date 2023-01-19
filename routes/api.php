<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login',[UserController::class,'login'])->name('login');
Route::post('register',[UserController::class,'register']);

Route::group(['middleware' => ['auth:api']], function() {
   Route::get("profile",[ProfileController::class,'show']);
   Route::post('updateName',[profileController::class,'updateName']);
   Route::get('logout', [UserController::class,'logout']);

});
