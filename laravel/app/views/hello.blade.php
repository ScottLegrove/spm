@extends('layouts.homeLayout')
@section('content')	
	<ul>
	  <li>{{ HTML::link('register', 'Register')}}</li>
	  <li>{{ HTML::link('login', 'Login')}}</li>
	</ul>
@endsection
