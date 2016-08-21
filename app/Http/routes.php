<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/{teste}', ['uses'=>'JokeController@show']);

Route::get('/', 'HomeController@welcome');

Route::get('/home', 'HomeController@welcome');

Route::get('/phpinfo', function () {
    return phpinfo();
});

Route::auth();

Route::get('auth/{provider}', ['as'=>'auth.redirect', 'uses'=>'Auth\AuthController@redirectToProvider']);
Route::get('auth/{provider}/callback', ['as'=>'auth.callback', 'uses'=>'Auth\AuthController@handleProviderCallback']);

Route::resource('mandante', 'MandanteController');



Route::resource('teste', 'JokeController', [
    'names' => [
        'index'=>'joke.index',
        'show'=>'joke.show',
        'edit'=>'joke.edit',
        'update'=>'joke.update',
        'store'=>'joke.store',
        'destroy'=>'joke.destroy',
    ]]);

Route::get('/resultado/{id}/{joke}/{fileMaked?}', ['as'=>'joke.jokeMake', 'uses'=>'JokeController@jokeMake']);

Route::get('/fileJoke/{id}/{params?}/{file}', ['as'=>'file.showJoke', 'uses'=>'FileController@showJoke']);
Route::get('/file/{file}', ['as'=>'file.show', 'uses'=>'FileController@show']);
Route::get('/fileFit/{size}/{file}', ['as'=>'file.fit', 'uses'=>'FileController@fit']);


