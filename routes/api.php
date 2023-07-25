<?php

use App\Http\Controllers\API\SellsyController;
use App\Http\Controllers\YouSignWebhookController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request)
{
    return $request->user();
});

Route::get('/sellsy/login/cron', [\App\Http\Controllers\API\SellsyController::class, 'requestAuthCode'])->name('sellsy-login-cron');

Route::post('/webhooks/yousign/procedure-is-signed', [YouSignWebhookController::class, 'estimateSigned'])->name('webhooks.estimate-signed');

Route::post('/webhooks/sellsy', [\App\Http\Controllers\SellsyWebhookController::class, 'receiveEvent'])->name('webhooks.sellsy');

Route::get('/sellsy/connect', [SellsyController::class, 'connect'])->name('api.sellsy.connect');

Route::get('/catalogue', [\App\Http\Controllers\API\SpaceController::class, 'getSpaces']);
Route::get('/cities-and-tags', [\App\Http\Controllers\API\SpaceController::class, 'getCitiesAndTags']);
