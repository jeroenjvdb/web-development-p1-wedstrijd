<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>competition</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	{!! Form::open() !!}
		{!! Form::text('test') !!}
	{!! Form::close() !!}

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