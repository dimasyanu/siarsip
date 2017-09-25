<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/print.css') }}">
</head>
<body>
	<div class="container">
		<div class="col-md-8 col-md-offset-2 outline">
			<div class="header text-center col-md-12">
				<h1 class="box-title">{{ $data->box_name }}</h1>
			</div>
			<div>
				<label>{{ Lang::get('app.room') }}: </label><span>{{ $data->room_name }}</span>
			</div>
			<div>
				<label>{{ Lang::get('app.shelf') }}: </label><span>{{ $data->shelf_name }}</span>
			</div>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th class="text-middle">No.</th>
						<th class="text-middle">{{ Lang::get('app.content') }}</th>
						<th class="text-middle">{{ Lang::get('app.date') }}</th>
						<th class="text-middle">{{ Lang::get('app.quantity') }}</th>
					</tr>
				</thead>
				<tbody>
					@foreach($records as $i => $record)
					<tr>
						<td>{{ $i+1 }}</td>
						<td>{{ $record->name }}</td>
						<td>{{ $record->date }}</td>
						<td>{{ $record->quantity }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>