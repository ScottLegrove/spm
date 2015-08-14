<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\UserInterface;
use Illuminate\Support\Facades\Cookie;
class LoginController extends BaseController{
	
	public function showLogin(){
		
		$view = View::make('login');
		$view->name = "Login";
		
		return $view;
	}

	public function validUser(){ 
		
		$user = array(
				':username' => Input::get('username'),
				':password' => Input::get('pass')
		);
				
		if( User::validLogin($user[':username'],$user[':password']) == true){
			
			$this->createUserCookie($user[':username']);
			//$this->deleteUserCookie($user[':username']);
			Session::start();
			Session::put('username',$user[':username']);
			return Redirect::action('AccountController@showAccount');
		}else
			return Redirect::to('login')->with('message', 'Invalid Login');		
	}
	
	public function createUserCookie($user){
		
		if(null !== (Input::get('rememberUser')))
			return Cookie::queue('user',$user,60*24*30*30);
	}
	
	public static function rememberUser(){
		
		$cookie = Cookie::get('user');			
		return $cookie;
	}

	public static function setCookieChkbx(){
		
		if(null !== LoginController::rememberUser())
			return true;
		else
			return false;
	}
	
	public static function deleteUserCookie($user){
		
		if(null == (Input::get('rememberUser')))
			$cookie = Cookie::queue('user',$user,-5000);
			
		return Response::make('cookie deleted')->withCookie($cookie);
		
	}
}