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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//*/

Route::get('actual-table', 'CurrencyRatesController@getActualTableRate');
Route::get('historical-single/{code}', 'CurrencyRatesController@getHistoricalSingleRate');

Route::fallback(function(){
    return response()->json([
        'status' => 'error',
        'message' => 'Page Not Found - 404'
    ], 404);
});