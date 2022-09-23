<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PortfolioItemsController;
use App\Http\Controllers\Api\SendMessageController;
use App\Http\Controllers\Api\VideoController;
use App\Models\Video;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});

Route::get('/portfolio', [PortfolioItemsController::class, 'index']);
Route::get('/portfolio/{id}', [PortfolioItemsController::class, 'show']);
Route::post('/send-message', [SendMessageController::class, 'send_message']);

Route::get('/video/{id}', [VideoController::class, 'show']);
Route::put('/video/{id}', [VideoController::class, 'update']);
