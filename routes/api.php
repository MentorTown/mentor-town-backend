<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenteeController;
use App\Http\Controllers\MentorController;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function(){
    //All secure URL's

    Route::get("status", [AuthController::class,'status']);

    Route::post("mentee/match", [MenteeController::class,'create']);
    Route::post("mentor/match", [MentorController::class,'create']);

    Route::get("matched-mentor", [MenteeController::class,'getMentor']);
    Route::get("matched-mentee", [MentorController::class,'getMentee']);

    Route::get("logout", [AuthController::class,'logout']);
    
});

Route::post("signup", [AuthController::class,'signup']);
Route::post("signin", [AuthController::class,'signin']);
