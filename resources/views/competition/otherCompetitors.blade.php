@extends('master')

@section('content')
	<h1>other competitors</h1>
	<div class="row">
		@foreach($competitors as $competitor)
			<div class="col-md-4">
				<div id="" class="thumbnail loginbox loginboxinner loginboxshadow competitor">
					
					<a class="item" href="{{ route('competitor', $competitor->id) }}">
							<h3>votes: <span id="comp-votes-{{ $competitor->id }}">{{ $competitor->getTotalVotes() }}</span></h3>
							<img src="{{ $competitor->picture_url }}" alt="{{ $competitor->user->name }}" class="img-rounded"></br>
					</a>
					<div id="competitor-{{ $competitor->id }}" class="vote {{ $competitor->voted ? 'unvote' : 'newVote' }}" data="1">
						
					</div>
					
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
			var originalNumberOfVotes = $('#comp-votes-' + intId);
			// console.log('votes:' + originalNumberOfVotes);
			var intOriginalNumberOfVotes = parseInt(originalNumberOfVotes.text());
			var url = '/competitor/' + intId;
			var newNumber = 0;
			// console.log(e.target.className.indexOf('unvote'));
			if(e.target.className.indexOf('unvote') > -1)
			{
				url += '/unvote';
				e.target.className = e.target.className.replace( /(?:^|\s)unvote(?!\S)/g, ' newVote' );
				newNumber = intOriginalNumberOfVotes-1;
			} else
			{
				url +='/vote';
				e.target.className = e.target.className.replace( /(?:^|\s)newVote(?!\S)/g, ' unvote' );
				newNumber = intOriginalNumberOfVotes+1;
			}
			// console.log('nu is het' + newNumber);
			originalNumberOfVotes.text(newNumber);
			intOriginalNumberOfVotes
			$(function(){
			$.ajax({
				url: url,
				data: '',

				dataType: 'json',
				success: function(data)
				{
					console.log(data);
				}
			})
					console.log(e);

		})
		}

		$('.vote').on('click', test);


		
	</script>
@stop

@section('scripts')

@stop