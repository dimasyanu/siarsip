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
			<h3>DAFTAR ARSIP</h3>
			<h3>DI ISTANA KEPRESIDENAN YOGYAKARTA</h3>
		</div>
		@foreach($rooms as $i => $room)
		<div>
			<label>{{ Lang::get('app.room') }}: </label><span>{{ $room->name }}</span>
		</div>

		@foreach($room->shelves as $i => $shelf)
		<div>
			<label>{{ Lang::get('app.shelf') }}: </label><span>{{ $shelf->name }}</span>
		</div>
		
		<table class="table table-bordered text-center">
			<thead>
				<tr>
					<th class="text-middle" style="width: 7%;">No.</th>
					<th class="text-middle" style="width: 55%;">{{ Lang::get('app.content') }}</th>
					<th class="text-middle" style="width: 10%;">{{ Lang::get('app.date') }}</th>
					<th class="text-middle" style="width: 10%;">{{ Lang::get('app.progress') }}</th>
					<th class="text-middle" style="width: 5%;">{{ Lang::get('app.quantity') }}</th>
					<th class="text-middle" style="width: 13%;">{{ Lang::get('app.ket') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach($shelf->boxes as $box)
				<tr><td colspan="6"><label>{{ $box->name }}</label></td></tr>

				@foreach($box->records as $record)
				<tr>
					<td>{{ $i+1 }}</td>
					<td>{{ $record->name }}</td>
					<td>{{ $record->date }}</td>
					<td>{{ $record->progress }}</td>
					<td>{{ $record->quantity }}</td>
					<td>{{ $record->descriptions }}</td>
				</tr>
				@endforeach
				@endforeach
			</tbody>
		</table>
		@endforeach
		@endforeach
	</div>
</body>
</html>