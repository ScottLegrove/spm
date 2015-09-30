<?php

use Illuminate\Support\Facades\Input;
use Symfony\Component\Security\Core\User\User;
class RegisterController extends BaseController{

	public function showRegister(){

		$view = View::make('register');
		$view->name = "Register";

		return $view;
	}
	
	public function createUser(){

		$user = array(
				':username' => Input::get('username'),
				':password' => Input::get('pass')	
		);
		
		//change this all to try catch
		
		$userexist = DB::select('select * from users where username = ?', array($user[':username']));
		
		if ( ($user[':username'] == null) || ($user[':password'] == null) ){
			return Redirect::to('register')->with('message', 'Please choose a username and password');
		}elseif(!empty($userexist)){
			return Redirect::to('register')->with('message', 'Username already in use');	
		}else{
			DB::insert('insert into users(username,pass1) values (?,?)', array($user[':username'],$user[':password']));
			return  Redirect::to('login')->with('message', 'User Created');
		}
	}
}


