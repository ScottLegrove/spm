@extends('layouts.login')


@section('content')
	<h1>{{ $name }} </h1>
	<div align="center"  style="margin-top:20px; padding:15px;" align="center">
	{{ Form::open(array('action' => 'RegisterController@createUser')) }}
		<table>
		  <tr>
		    <td style="padding: 5px;">{{ Form::label('Username',null,['required' => 'required']) }}</td>
		    <td><input name="username" type="text" style="color: black;"></td>
		  </tr>
		  <tr>
		    <td style="padding: 5px;">{{ Form::label('Password') }}</td>
		    <td><input name="pass" type="password" value=""  style="color: black;"></td>
		  </tr>
		  <tr>
		  	<td colspan="2" align="right"><input style="color: black;" type="submit" value="Register"></td>
		  </tr>
		</table>
	{{ Form::close() }}
	</div>
@endsection