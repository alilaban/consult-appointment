<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/createUser', [AuthController::class, 'createUser']);
Route::post('/createExpert', [AuthController::class, 'createExpert']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:api');


Route::middleware('auth:api')->group(function(){
    Route::get('/userDetails', [AuthController::class, 'userDetails']);
    Route::get('/expertDetails', [AuthController::class, 'expertDetails']);
});

    Route::group(['prefix' => 'favorite', 'middleware' => ['auth:api']], function(){
    Route::post('/index', [FavoriteController::class, 'index']);
    Route::post('/like/{id}', [FavoriteController::class, 'like']);
    Route::post('/dislike/{id}', [FavoriteController::class, 'dislike']);
});
////////
Route::group(['prefix' => 'categories', 'middleware' => ['auth:api']], function(){
    Route::get('/index', [CategoryController::class, 'index']);
    Route::post('/store', [CategoryController::class, 'store']);
    Route::get('/{id}', [CategoryController::class, 'show']);
    Route::post('/{id}', [CategoryController::class, 'update']);
    Route::delete('/{id}', [CategoryController::class, 'destroy']);
});
////////
Route::group(['prefix' => 'expert', 'middleware' => ['auth:api']], function(){
    Route::get('/index', [ExpertController::class, 'index']);
    Route::get('/{id}', [ExpertController::class, 'show']);
    Route::post('/{id}', [ExpertController::class, 'update']);
    Route::delete('/{id}', [ExpertController::class, 'destroy']);
});
/////////
Route::group(['prefix' => 'user', 'middleware' => ['auth:api']], function(){
    Route::get('/index', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::post('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});
////////
Route::group(['prefix' => 'reservation', 'middleware' => ['auth:api']], function(){
    Route::get('/time', [ReservationController::class, 'time']);
    Route::get('/index', [ReservationController::class, 'index']);
    Route::post('/{id}', [ReservationController::class, 'store']);
    Route::get('/{id}', [ReservationController::class, 'show']);
    Route::post('/{id}', [ReservationController::class, 'update']);
    Route::delete('/{id}', [ReservationController::class, 'destroy']);
});

