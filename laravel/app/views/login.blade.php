@extends('layouts.login')
@section('content')

 
<!-- My stuff starts here -->

<h1>{{ $name }}</h1>
	
<div align="center"  style="margin-top:20px; padding:15px;" align="center">	
	{{ Form::open(array('action' => 'LoginController@validUser')) }}
		<table>
		  <tr>
		    <td>{{ Form::label('Username') }}</td>
		    <td style="padding: 5px;">{{ Form::text('username', LoginController::rememberUser(), array('style'=>'color:black;')) }}</td>
		  </tr>
		  <tr>
		    <td>{{ Form::label('Password') }}</td>
		    <td style="padding: 5px;">{{ Form::password('pass', array('style' => 'color:black;')) }}</td>
		  </tr>
		  <tr>
		  <td>{{ Form::label('Remember me') }}{{ Form::checkbox('rememberUser', 'value', LoginController::setCookieChkbx()) }}</td>
		  	<td style='text-align:center;'>{{ Form::submit('Login', array('style' => 'color:black;')) }}</td>
		  </tr>
  	   </table>
	{{ Form::close() }}
</div>
@endsection