<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthenticateOnceWithBasicAuth;
use App\Http\Controllers\Api\UserDeviceTokenController;
use App\Http\Controllers\Api\ChannelController;
use App\Http\Controllers\Api\UserChannelController;

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

Route::middleware([AuthenticateOnceWithBasicAuth::class])->group(function () 
{
    Route::post('/users/device-token', [UserDeviceTokenController::class, 'store']);
    Route::get('/users/channels', [UserChannelController::class, 'index']);

    Route::get('/channels', [ChannelController::class, 'index']);
    Route::post('/channels/{channel}/subscribe', [ChannelController::class, 'subscribe']);
    Route::post('/channels/{channel}/unsubscribe', [ChannelController::class, 'unsubscribe']);

    Route::post('/channels/unsubscribe', [ChannelController::class, 'allUnsubscribe']);
    Route::post('/channels/resubscribe', [ChannelController::class, 'resubscribe']);
});
