<?php


use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Translation\Tests\String;
class AccountController extends BaseController{
	
	public function showAccount(){
		
		$view = View::make('account');
		$view->name = "Account";
		$view->username = Session::get('username');
		$view->projects = $this->getUserProjects();
		$view->class  = $this->getUserClass(); 
		$view->Duedate = $this->getUserDuedate();
		$view->grades = $this->getUserGrade();
		$view->pID = $this->getPID();
		
		return $view;
	}
	
	public function getUserId(){
		
		$userName = Session::get('username');
		$userID = User::getUserID($userName);
		
		return $userID;
	}
	
	public function submitProject(){
		
		$projects = array(
				':userid' => $this->getUserId(),
				':className' => Input::get('className'),
				':projectName' => Input::get('projectName'),
				':dueDate' => input::get('dueDate')
		);
		
		User::addProject($projects[':userid'],$projects[':projectName'],$projects[':dueDate'],$projects[':className']);
		
		return $this->showAccount();
	}
	
	public function deleteProject(){
	
		$projects = array(
				':userid' => $this->getUserId(),
				':className' => Input::get('deleteClassName'),
				':projectName' => Input::get('deleteProjectName'),
		);
	
		User::deleteProject($projects[':userid'],$projects[':projectName'],$projects[':className']);
		
		return  Redirect::to('account');
	}
	
	public function getUserProjects(){
		
		$results = User::displayProjects($this->getUserId());
		
		return $results;
	}
	
	public function getUserClass(){
	
		$results = User::displayClass($this->getUserId());
	
		return $results;
	}
	
	public function getUserDuedate(){
	
		$results = User::displayDuedate($this->getUserId());
	
		return $results;
	}
	
	public function getUserGrade(){
	
		$results = User::displayGrade($this->getUserId());
	
		return $results;
	}
	
	public function getPID(){
			
		$results = User::getPID($this->getUserId());
	
		return $results;
	}
	
	public function addGrades(){
	
		$newGrade = (float) Input::get('addGrade');
		$pid = Input::get('invisible');
		
		User::addGrades($pid, $newGrade);
		
		return Redirect::to('account');
	}
	
	
	public function deleteByPID($pid){
			
		
		User::deleteByPID($this->getUserId(),$pid);
	
		return $this->showAccount();
	}
	
	public function userLogout(){
		
		Session::flush();
		DB::disconnect('studentp');
		return Redirect::to('login')->with('message','You have been logged out');
	}
}