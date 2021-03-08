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

use App\Mail\NewUserWelcomeMail;
use Illuminate\Filesystem\Filesystem;
use App\Http\Resources\EpackageResource;
use App\Entities\Epackage;

Route::get('/', function () {
    $file = app()->basePath() . '/temp/panasonic.zip';
    $fs = new Illuminate\Filesystem\Filesystem();
    Storage::disk('epackages')->put($fs->basename($file), $fs->get($file));

    return view('welcome');
});


Route::get('/email', function () {
    $email = 'esgras@yahoo.com';
//    Mail::to($user->email)->send(new NewUserWelcomeMail());
    $res = Mail::to($email)->send(new NewUserWelcomeMail());
    return "Result - {$res}";
//    return new NewUserWelcomeMail();
});

Route::get('/test', 'TestController@test');

Route::get('/more', 'TestController@more');

Route::get('/epackage', function() {
    return new EpackageResource(Epackage::firstOrFail());
});
