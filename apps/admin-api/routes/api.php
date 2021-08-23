<?php
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Data\RecordController;
  
use App\Http\Controllers;
use App\Http\Controllers\API\Auth\InfoUserController;

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

Route::namespace('API')->prefix('v1')->group(function () {
    Route::post('/auth/register', [RegisterController::class, 'register']);
    Route::post('/auth/login', [LoginController::class, 'login']);
    Route::get('/test',  [LoginController::class, 'test']);
});

Route::middleware('auth:api')->group( function () {
    // Route::resource('products', ProductController::class);
});
     
Route::middleware('auth:api')->group( function () {
    Route::resource('records', RecordController::class);
});

Route::apiResource('InfoUser','App\Http\Controllers\API\Auth\InfoUserController');

Route::get('UserTestResult/{iduser}','App\Http\Controllers\API\Auth\InfoUserController@UserTestResult');

Route::get('UserVaccina/{iduser}','App\Http\Controllers\API\Auth\InfoUserController@UserVaccina');

Route::get('ViewProfile/{username}','App\Http\Controllers\API\Auth\InfoUserController@ViewProfile');
