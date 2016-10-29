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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');
Route::get('Pages/about', 'PagesController@about');

Route::get('fields', 'FieldsController@getAllFields');
// Route for adding fields --------------------------
Route::post('/Field/add', function(){
	\App\Field::create(Input::all());
	var_dump('Field is created!');
});

// --------------------------------------------------
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
