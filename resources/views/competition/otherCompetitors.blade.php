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
			<div id="competitor-{{ $competitor->id }}" class="test" data="1">test</div>
		</div>
			</div>
		@endforeach
	</div>

	<script type="text/javascript">
		function test (e){
			// console.log(e.target.id);
			var id = e.target.id;
			var nothingBefore = id.substring(id.indexOf('competitor-') + 11);
			// console.log(nothingBefore);
			// console.log()
			if(nothingBefore.indexOf(' ') >= 0)
			{
			var nothingAfter = nothingBefore.substring(0, nothingBefore.indexOf(' '));
			} else
			{
				nothingAfter = nothingBefore;
			}
			// console.log(nothingAfter);
			var intId = parseInt(nothingAfter);
			console.log(intId);

			$(function(){
			$.ajax({
				url: '/competitor/' + intId + '/vote',
				data: '',

				dataType: 'json',
				success: function(data)
				{
					console.log(data);
				}
			})
		})
		}

		$('.test').on('click', test)


		
	</script>
@stop

@section('scripts')

@stop