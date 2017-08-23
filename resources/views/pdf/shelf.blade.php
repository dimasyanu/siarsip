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
		<div class="header text-center col-md-12">
			<h3>DAFTAR ARSIP KEUANGAN</h3>
			<h3>DI ISTANA KEPRESIDENAN YOGYAKARTA</h3>
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
					<th class="text-middle">{{ Lang::get('app.period') }}</th>
					<th class="text-middle">{{ Lang::get('app.progress') }}</th>
					<th class="text-middle">{{ Lang::get('app.quantity') }}</th>
					<th class="text-middle">{{ Lang::get('app.ket') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach($boxes as $box)
				<tr><td colspan="6"><label>{{ $box->name }}</label></td></tr>
				@foreach($box->records as $i => $record)
				<tr>
					<td>{{ $i+1 }}</td>
					<td>{{ $record->name }}</td>
					<td>{{ $record->period }}</td>
					<td>{{ $record->progress }}</td>
					<td>{{ $record->quantity }}</td>
					<td>{{ $record->descriptions }}</td>
				</tr>
				@endforeach
				@endforeach
			</tbody>
		</table>
	</div>
</body>
</html>