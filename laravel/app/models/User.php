<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Support\Facades\Redirect;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $table = 'users';
	
	protected $fillable = array('username');
	
	protected $guarded = array('pass1');
	
	protected $hidden = array('password', 'remember_token');
	
	
	public static function validLogin($username,$password){
		
		$results = DB::select('select * from users where username = ? and pass1 = ?', array($username,$password));
		
		return $results;
	}

	public static function getUserID($username){
		
		$results = DB::table('users')->select('id')->where('username', $username)->pluck('id');
						
		return $results; 
	}
	
	public static function addProject($id,$projectname,$duedate,$classname){
		
		try{
			
			if($projectname == null)
				throw new Exception('Please fill out a project name');
			elseif ($classname == null)
				throw new Exception('Please fill a class name');
			elseif($duedate == null)
				throw new Exception('Please give a due date');
			else{
				DB::insert('insert into projects(u_id,project_name,due_date,class_name) values(?,?,?,?)', array(
				$id,$projectname,$duedate,$classname
				));
			} 
		}catch (Exception $ex){
			
			return Redirect::to('account')->with('message', $ex->getMessage());	
		}
		
	}
	
	public static function displayProjects($id){
		
		$results = DB::table('projects')->select('project_name')->where('u_id', $id)->get();

		
		return $results;
	}
	
	public static function displayClass($id){
	
		$results = DB::table('projects')->select('class_name')->where('u_id', $id)->get();
	
		return $results;
	}
	
	public static function displayDuedate($id){
	
		$results = DB::table('projects')->select('due_date')->where('u_id', $id)->get();
	
		return $results;
	}
	
	public static function displayGrade($id){
	
		$results = DB::table('projects')->select('grade')->where('u_id', $id)->get();
	
		return $results;
	}
	
	public static function addGrades($id,$newGrade){
			
		DB::update("update projects set grade=$newGrade where p_id=$id"); 
	
	}
	
	
	public static function getPID($id){
	
		
		$results = DB::table('projects')->select('p_id')->where('u_id', $id)->get();
		return $results;
	}
	
	public static function deleteByPID($uid,$pid){
		
		DB::delete("DELETE FROM projects WHERE u_id=$uid and p_id=$pid");
	}
	
	public static function deleteProject($id,$projectname,$classname){
		
		try{
				
			if($projectname == null)
				throw new Exception('Please fill out a project name');
			elseif ($classname == null)
				throw new Exception('Please fill out a class name');
			else{
				DB::delete("DELETE FROM projects WHERE u_id=$id and project_name='$projectname' and class_name='$classname'");
			}
		}catch (Exception $ex){	
			return Redirect::to('account')->with('message', $ex->getMessage());
		}
	}
}
