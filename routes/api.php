<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ClientController;

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


//Route::group(['namespace' => 'Api'], function () {

    /**
     * API Clientes
     */

    //Route::group(['prefix' => 'clients'], function () {
    //    Route::post(''            , 'ClientController@store');
    //    Route::put('{id}'         , 'ClientController@update');
    //    Route::get('{id}/cards'   , 'ClientController@cards');
    //    Route::get('{id}/payments', 'ClientController@payments');
    //});

    /**
     * API Pagamentos
     */

    //Route::group(['prefix' => 'payments'], function () {
    //    Route::get('{id}', 'PaymentController@show');
    //    Route::post('', 'PaymentController@store');
    //});

    Route::resource('clients',ClientController::class);
    Route::resource('payments', PaymentController::class);

//});


