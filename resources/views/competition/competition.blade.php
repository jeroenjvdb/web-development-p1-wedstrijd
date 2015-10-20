@extends('master')

@section('content')
	<h2>competition</h2>
	<h3>join us</h3>
	{!!  Form::open(array('route' => 'competition' ,'files' => true)) !!}
		{!! Form::file('duvel') !!} <br>
		{!! Form::submit() !!}
	{!! Form::close() !!}

	<h3>other competitors</h3>
	<div class="row">
		@foreach($competitors as $competitor)
		<a href="{{ route('competitor', [1]) }}">
			<div class="col-md-4">
				<img src="{{ $competitor->picture_url }}" alt="{{ $competitor->user->name }}"></br>
				<p>votes: {{ $competitor->getTotalVotes() }}</p>
			</div>
		</a>
		@endforeach
	</div>
@stop