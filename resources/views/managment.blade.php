@extends('master')

@section('content')
	<h1>managment</h1>
	<div class="">
		
	@foreach($competitors as $competitor)
		<div class="row">
			<div class="col-md-3 managment"><div><p><img src="{{ $competitor->thumbnail }}" alt="{{ $competitor->user->fullName() }}"></p></div></div>
			<div class="col-md-3 managment"><div><p>{!! $competitor->user->NAW() !!}</p></div></div>
			<div class="col-md-1 managment"><div><p>{{ $competitor->user->email }}</p></div></div>
			<div class="col-md-2 managment"><div><p>{{ $competitor->created_at }}</p></div></p></div>
			<div class="col-md-1 managment">
				<div class="row">
					<div class="col-md-6">
						<p><span class="glyphicon glyphicon-pencil"></span></p>
					</div>
					<div class="col-md-6">
						<p><span class="glyphicon glyphicon-remove"></span></p>
					</div>
					<p></span></p>
				</div>
			</div>
		</div>
		<hr>

	@endforeach
	</div>
@stop