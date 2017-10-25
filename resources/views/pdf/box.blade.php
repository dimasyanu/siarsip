<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/print.css') }}">
</head>
<body>
	<div class="container" style="padding-bottom: 50px; width: 10cm;">
		<div class="outline" style="padding: 0 0.5cm; min-height: 20cm;">
			<div class="text-center col-md-12">
				<h6 class="box-title">{{ Lang::get('app.records_document') }}</h6>
				<h2 class="box-title" style="margin: 5px;"><strong>{{ $data->box_name }}</strong></h2>
			</div>
			<label style="font-size: 9pt;">{{ date('M Y', strtotime($records[0]->date))  }} - {{ date('M Y', strtotime($records[sizeof($records) - 1]->date))  }}</label>
			<table class="table table-bordered" style="font-size: 10pt;">
				<thead>
					<tr>
						<th class="text-middle" style="width: 1cm;">No.</th>
						<th class="text-middle">{{ Lang::get('app.content') }}</th>
						<th class="text-middle" style="width: 1cm;">{{ Lang::get('app.quantity_acr') }}</th>
					</tr>
				</thead>
				<tbody>
					@foreach($records as $i => $record)
					<tr>
						<td>{{ $i+1 }}</td>
						<td>{{ $record->name }}</td>
						<td>{{ $record->quantity }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>