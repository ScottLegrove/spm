<?php 

use Illuminate\Support\Facades\Redirect;
function currentDate(){

		date_default_timezone_set('America/Toronto');
		$date = date('Y-m-d');	
		return $date;
}

if(isset($_GET['pid'])){
	$pid = $_GET['pid'];
	
	App::make('AccountController')->deleteByPID($pid);
}
?>
@extends('layouts.accountLayout')
@section('content')
<div id='divTop'>
<div align="right">
	{{ Form::open(array('url' =>'account/logout','action' => 'AccountController@userLogout')) }}
		{{ Form::submit('Logout')  }}
	{{ Form::close() }}
</div>



<div>
	<h1>{{ $name }} </h1>
		<h3>Welcome, {{ $username }}</h3>
		
		
</div>
</div>	
<div align="center">
	
	@if(Session::has('message'))
		 	    <h3>{{ Session::get('message')}}</h3>		 	    
		 	    {{ Session::put('message','') }}	 	    
	@endif
	
	<h2 style="padding-bottom: 10px;">Add a course</h2>
	{{ Form::open(array('action'=>'AccountController@submitProject' ,'id' => 'addCourses')) }}
		<table>
	  	<tr>
		    <th>{{ Form::label('Class') }}</th>
		    <th>{{ Form::label('Project Name') }}</th>
		    <th>{{ Form::label('Project Due Date') }}</th>
	    </tr>
	    
	    <tr>
		    <td>{{ Form::text('className') }}</td>
		    <td>{{ Form::text('projectName') }}</td>
		     <td>{{ Form::input('date','dueDate') }}</td>
		    <td colspan='2' style='text-align:center;'>{{ Form::submit('Submit') }}</td>
	   </tr>
			  
		</table>
	{{ Form::close() }}
</div>
	<hr style='margin-top:15px;'/>

<div align="center" style="margin: 20px;" >
		<table cellpadding="0" cellspacing="0" border="1"class="sortable" id="sorter" style='color: black;'>
		<tr>
			<th style="padding-right: 80px;">Delete Projects</th>
			<th style="padding-right: 80px;">Project Name</th>
			<th  style="padding-right: 80px;">Class Name</th>
			<th  style="padding-right: 80px;">Due Date</th>
			<th  style="padding-right: 80px;">Current Date</th>
			<th  style="padding-right: 80px;">Time Remaining</th>
			<th  style="padding-right: 80px;">Weighted Grade</th>
			<th  style="padding-right: 90px;">Add Grade</th>
		</tr>
	
		@for($x = 0; $x < count($projects); $x++)
		 <tr>
			
			@foreach($pID[$x] as $key => $value)
				<td style="padding-right: 80px;"><a href="?pid={{ $value }}">Remove</a></td>
			@endforeach
		
			@foreach($projects[$x] as $key => $value)
				<td  style="padding-right: 80px;">{{ $value }}</td>
			@endforeach
			
			@foreach($class[$x] as $key => $value)
				<td  style="padding-right: 80px;">{{ $value }}</td>
			@endforeach
			
			@foreach($Duedate[$x] as $key => $value)
				<td  style="padding-right: 80px;" class="DueDate">{{ $value }}</td>
			@endforeach
			
			<td class='currentTime'>{{ currentDate() }} </td>
			
			@foreach($Duedate[$x] as $key => $value)
				<?php 
					$datetime1 = date_create($value);
					$datetime2 = date_create(currentDate());
					if($datetime2 >= $datetime1){
						$timeLeft = $datetime2->diff($datetime2);
					}else{
						$timeLeft = $datetime1->diff($datetime2);
					}		
				?>
			<td  style="padding-right: 80px; onLoad=">{{ $timeLeft->format('%m Month %d Days') }}</td>
			@endforeach
			
			@foreach($grades[$x] as $key => $value)
				<td  style="padding-right: 80px;" class="grades">{{ $value }}</td>
			@endforeach
			
			 @foreach($pID[$x] as $key => $value)
				<td  style="padding-right: 90px;" class="grades">
				{{ Form::open(array('action'=> 'AccountController@addGrades')) }}
				{{ Form::hidden('invisible', $value) }}
				{{ Form::text('addGrade') }}{{ Form::submit('Add Grade') }}
				{{ form::close() }}</td>
			@endforeach
			
		</tr>
	@endfor
	</table>
</div>
	
	<hr/>
	
<div>
	<p>Currently Set <br> Date: {{ currentDate() }} <br> Timezone: {{ date_default_timezone_get() }}</p>
</div>

<div id="gradeCalculator">
	<?php 
// start of dropdown
echo "<h2 align='center'>Get Grades</h2>";
echo "<div align='center'>";
echo "<form method='get'><select style='margin:10px; float:left;' name='selectedCourse'>";
$classOptions = array();
for($x=0;$x<count($class);$x++){
	foreach($class[$x] as $key => $value)
		$classOptions[]=$value;
}

$calcGrades = array();
for($x=0;$x<count($class);$x++){
	foreach($grades[$x] as $key => $value)
		$calcGrades[]=$value;
}

$uniqueCode = array_unique($classOptions);
foreach($uniqueCode as $key => $value){
	echo "<option value='$value'>$value</option>";
}

echo "</select><br><input type='submit' value='Select Course' name='calcGrades' ></form>";
echo '</div>';
// this is the end of the dropdown

function sum($calcGrades,$selectOption,$classOptions){
	
	$sum = 0;
	
	foreach ($calcGrades as $key => $value)
		for ($i = $key;$i<=$key;$i++)
			if($classOptions[$i] == $selectOption)
				$sum = $sum+$value;
	
	return '<h2 style='.'margin-top:5px;'.'>Grade for<br>'.$selectOption.': '.$sum.'%</h2><br>';
}

if(isset($_GET['calcGrades'])){

	$selectOption = $_GET['selectedCourse'];	
	echo '<div id='.'theGrade'.'>'.sum($calcGrades, $selectOption, $classOptions).'</div>';	
	
}

?>
</div>
	<div align="center">
	
	@if(Session::has('message'))
		 	    <h3>{{ Session::get('message')}}</h3>		 	    
		 	    {{ Session::put('message','') }}	 	    
	@endif
	
	<h2 style="padding-bottom: 10px;">Delete a Project</h2>
	{{ Form::open(array('action'=>'AccountController@deleteProject' ,'id' => 'deleteProjects')) }}
		<table>
	  	<tr>
		    <th>{{ Form::label('Class') }}</th>
		    <th>{{ Form::label('Project Name') }}</th>
	    </tr>
	    
	    <tr>
		    <td>{{ Form::text('deleteClassName') }}</td>
		    <td>{{ Form::text('deleteProjectName') }}</td>
		    <td colspan='2' style='text-align:center;'>{{ Form::submit('Delete') }}</td>
	   </tr>
			  
		</table>
	{{ Form::close() }}
</div>




@endsection