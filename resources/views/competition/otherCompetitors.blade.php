@extends('master')

@section('content')
	<h3>other competitors</h3>
	<div class="row">
		@foreach($competitors as $competitor)
			<div class="col-md-4">
		<div class="thumbnail loginbox loginboxinner loginboxshadow">
			
			<a class="item" href="{{ route('competitor', $competitor->id) }}">
					<h3>votes: {{ $competitor->getTotalVotes() }}</h3>
					<img src="{{ $competitor->picture_url }}" alt="{{ $competitor->user->name }}" class="img-rounded"></br>
			</a>
		</div>
			</div>
		@endforeach
	</div>
@stop