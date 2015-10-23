@extends('master')

@section('content')
	<h2>competition</h2>
	{{ Config::get('constants.test') }}
	<h3>join us</h3>
	@if(!Auth::check())
	<div class="row">
		<div class="col-md-8">
			<div class="loginbox loginboxinner loginboxshadow">
				
			<legend>register</legend>
			<div class="row">
					{!! Form::open(['route' => 'register']) !!}
				<div class="col-md-4">
						{!! Form::label('email', 'email adress') !!}</br>
						{!! Form::text('email', '', ['placeholder' => 'example@gmail.com']) !!}</br>
						{!! Form::label('password', 'password') !!}</br>
						{!! Form::password('password') !!}</br>
						{!! Form::label('password_confirmation', 'password') !!}</br>
						{!! Form::password('password_confirmation') !!}</br>
				</div>
				<div class="col-md-4">
						{!! Form::label('name', 'name') !!}</br>
						{!! Form::text('name') !!}<br>
						{!! Form::label('surname', 'surname') !!}</br>
						{!! Form::text('surname') !!}</br>
						{!! Form::label('dateOfBirth', 'date of birth') !!}</br>
						{!! Form::date('dateOfBirth' ) !!}	
				</div>
				<div class="col-md-4">
						{!! Form::label('residence', 'woonplaats') !!}</br>
						{!! Form::text('residence') !!}</br>
						{!! Form::label('address', 'adres') !!}</br>
						{!! Form::text('address') !!}</br>
						{!! Form::label('housenumber') !!}</br>
						{!! Form::text('housenumber') !!}</br>
				</div>
				<div class="form-group text-center centerbuttons">
					{!! Form::submit('register', array('class' => 'btn btn-success btn-login-submit')) !!}
					{!! Form::close() !!}
				</div>
			</div>
			
				

			</div>
		</div>
		<div class="col-md-4">
			<div class="loginbox loginboxinner loginboxshadow">
				
			<legend>already have an account</legend>
			{!! Form::open(['route' => 'login']) !!}
				{!! Form::label('email') !!}</br>
				{!! Form::text('email') !!}</br>
				{!! Form::label('password') !!}</br>
				{!! Form::password('password') !!}</br>
				<div class="form-group text-center centerbuttons">
					{!! Form::submit('login', array('class' => 'btn btn-success btn-login-submit')) !!}
					{!! Form::close() !!}
				</div>
			{!! Form::close() !!}
			</div>
		</div>
		<div class="col-md-4 col-md-offset-4">
			<div class="loginbox loginboxinner loginboxshadow">
				
			<legend>too lazy? login with facbook</leggend>
			</div>
		</div>
	</div>
	@endif
		
	@if(Auth::check())
	<div class="row">
		<div class="col-md-12">
			
			{!!  Form::open(array('route' => 'competition' ,'files' => true)) !!}
				{!! Form::file('duvel') !!} <br>
				{!! Form::submit() !!}
			{!! Form::close() !!}
		</div>
	</div>
	@endif

	
@stop