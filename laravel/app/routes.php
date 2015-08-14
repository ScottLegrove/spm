<?php

use Illuminate\Support\Facades\Redirect;
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

/*Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/test', function()
{
	return View::make('test');
});*/

Route::get('/', 'HomeController@showWelcome');
Route::get('login', array('before'=>'alreadyLogged', 'uses'=>'LoginController@showLogin'));
Route::get('register', array('uses'=>'RegisterController@showRegister'));
Route::get('account', array('before'=>'notLogged', 'uses'=>'AccountController@showAccount'));
Route::post( 'register','RegisterController@createUser');
Route::post('login','LoginController@validUser');
Route::post('account','AccountController@getUserInfo');
Route::post('account','AccountController@submitProject');
Route::post('account/delete','AccountController@deleteProject');
Route::post('account/logout','AccountController@userLogout');
Route::post('account/grades', 'AccountController@addGrades');
Route::filter('notLogged',function(){
	
		$session = Session::get('username');
		if($session == null)
			return Redirect::to('login')->with('message', 'Login Required');

			
});

Route::filter('alreadyLogged',function(){
	
		$session = Session::get('username');
		if ($session != null)
			return Redirect::to('account')->with('message', 'Welcome Back');
});
	


