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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

define('UUID_V4_PATTERN', config('params.routing.uuid_v4'));

Route::group([
    'namespace' => 'Api\\',
], function() {

    Route::group([
        'prefix' => 'file'
    ], function() {
        Route::get('/morex', 'FileController@morex');
        Route::get('/test', 'FileController@test');
        Route::get('/foo', 'FileController@foo');
        Route::get('/event-test', 'FileController@eventTest');
        Route::get('/job-test', 'FileController@jobTest');
    });

    Route::group([
        'prefix' => 'epackages'
    ], function() {
        Route::get('/', 'EpackageController@findAll');
        Route::post('/', 'EpackageController@upload');
        Route::post('/{id}', 'EpackageController@update')->where('id', UUID_V4_PATTERN);
        Route::get('/{id}', 'EpackageController@find')->where('id', UUID_V4_PATTERN);
        Route::delete('/{id}', 'EpackageController@delete')->where('id', UUID_V4_PATTERN);
        Route::post('/{id}/retailers/assign', 'EpackageController@assignRetailers')->where('id', UUID_V4_PATTERN);
        Route::post('/{id}/retailers/disengage', 'EpackageController@retailersDisengage')->where('id', UUID_V4_PATTERN);

        Route::put('/{id}/{retailerId}', 'EpackageController@retailerUpdate')->where('id', UUID_V4_PATTERN)->where('retailerId', UUID_V4_PATTERN);
    });

    Route::group([
        'prefix' => 'brands'
    ], function() {
        Route::get('/', 'BrandController@findAll');
        Route::post('/', 'BrandController@create');
        Route::put('/{id}', 'BrandController@update')->where('id', UUID_V4_PATTERN);
        Route::get('/{id}', 'BrandController@find')->where('id', UUID_V4_PATTERN);
        Route::delete('/{id}', 'BrandController@delete')->where('id', UUID_V4_PATTERN);
    });

    Route::group([
        'prefix' => 'retailers'
    ], function() {
        Route::get('/', 'RetailerController@findAll');
        Route::post('/', 'RetailerController@create');
        Route::put('/{id}', 'RetailerController@update')->where('id', UUID_V4_PATTERN);
        Route::get('/{id}', 'RetailerController@find')->where('id', UUID_V4_PATTERN);
        Route::delete('/{id}', 'RetailerController@delete')->where('id', UUID_V4_PATTERN);
    });

});

