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
        Route::delete('/delete-all', 'FileController@deleteAll');
        Route::post('/upload', 'FileController@upload');
        Route::post('/{id}', 'FileController@upload')->where('id', UUID_V4_PATTERN);
        Route::get('/find/{id}', 'FileController@find')->where('id', UUID_V4_PATTERN);
        Route::post('/update/{id}', 'FileController@update')->where('id', UUID_V4_PATTERN);
        Route::get('/foo', 'FileController@foo');
        Route::get('/show-test', 'FileController@showTest');

        Route::delete('/{id}', 'FileController@delete')->where('id', UUID_V4_PATTERN);
    });

    Route::group([
        'prefix' => 'epackages'
    ], function() {
        Route::get('/', 'EpackageController@findAll');
        Route::post('/', 'EpackageController@upload');
        Route::post('/{id}', 'EpackageController@update')->where('id', UUID_V4_PATTERN);
        Route::get('/{id}', 'EpackageController@find')->where('id', UUID_V4_PATTERN);
        Route::delete('/{id}', 'EpackageController@delete')->where('id', UUID_V4_PATTERN);
        Route::post('/{id}/retailers/assign', 'EpackageController@assignRetailer')->where('id', UUID_V4_PATTERN);
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

