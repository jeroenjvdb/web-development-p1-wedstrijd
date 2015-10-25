<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>competition</title>
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<script src="/js/jquery-1.9.1.min.js"></script>
	@yield('scripts')
</head>
<body>
	{!! Form::open() !!}
		{!! Form::text('test') !!}
	{!! Form::close() !!}

	@if(Auth::check())
		{{ Auth::user()->name }}
		<a href="{{ route('logout') }}">logout</a>
	@endif

	@if($errors)
		@foreach($errors->all() as $error)
			<p>{{ $error }}</p>
		@endforeach
	@endif
	<div class="container">
		@yield('content')
	</div>
</body>
</html>