<?php

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh']);
    Route::post('me', [App\Http\Controllers\AuthController::class, 'me']);
});

Route::group([
    'middleware' => 'jwt.auth',
    'prefix' => 'post'
], function ($router) {
    Route::get('/', [App\Http\Controllers\PostController::class, 'all']);
    Route::get('{id}', [App\Http\Controllers\PostController::class, 'getById']);
    Route::post('', [App\Http\Controllers\PostController::class, 'create']);
    Route::put('', [App\Http\Controllers\PostController::class, 'update']);
});
