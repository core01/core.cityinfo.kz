<?php

use Illuminate\Http\Request;

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

/*    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });*/
/*    Route::get('/telegram/{token}/webhook', [
        'as'   => 'telegram-bot',
        'uses' => 'Telegram\TelegramController@getRequest',

    ]);*/
Route::post('/telegram/{token}/webhook', [
    'uses'    => 'Telegram\TelegramController@postRequest',
    'laroute' => false,
]);
