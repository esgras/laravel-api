<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Filesystem\Filesystem;

Route::get('/', function () {
    $file = app()->basePath() . '/temp/panasonic.zip';
    $fs = new Illuminate\Filesystem\Filesystem();
    Storage::disk('epackages')->put($fs->basename($file), $fs->get($file));

    return view('welcome');
});

Route::get('/test', 'TestController@test');

Route::get('/more', 'TestController@more');
