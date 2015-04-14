<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//Route::get('/', 'HomeController@showMain');

Route::get('/', array('before' => 'auth',
  'uses' => 'HomeController@showMain'
));

Route::controller('auth', 'AuthController');

// RESTful controllers
Route::resource('api/servers', 'ServersController');
Route::resource('api/users', 'UsersController');

