@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
<div class="app-contents">
	<div class="panel auto-y">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10" style="font-size: 14pt;">
					{{ Lang::get('app.details', ['item' => Lang::get('app.record')]) }}
				</div>
			</div>
		</div>

		<div class="panel-body auto-y">
			@if(session('messages'))
				<div class="alert @if(session('status') == 1) alert-success @else alert-danger @endif" role="alert">{{ session('messages') }}</div>
			@endif
			
			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<!-- Container -->
			<div class="container" style="margin-top: 16px;">
				<div class="pull-right" style="margin-bottom: 20px;">
					<div class="btn-group" role="group">
						<a href="{{ url('records/' . $item->id . '/edit') }}" class="btn btn-primary">
							<i class="fa fa-pencil"></i>  {{ Lang::get('app.edit') }}
						</a>
						<a href="{{ url('records') }}" class="btn btn-default">
							<i class="fa fa-times"></i>  {{ Lang::get('app.close') }}
						</a>
					</div>
				</div>
				<table class="table table-striped">
					<tbody>
						<!-- Name -->
						<tr>
							<th class="text-middle" style="width">
								{{ Lang::get('app.content') }}
							</th>
							<td>{{ $item->name }}</td>
						</tr>

						<!-- Record Category -->
						<tr>
							<th class="text-middle">
								{{ Lang::get('app.category') }}
							</th>
							<td>
								<div class="panel panel default">
									<div class="panel-body">
										@if($item->category_id == 0)
										{{ Lang::get('app.not_categorized') }}
										@else
										<div class="tree">
											<ul>
											@foreach($item->category->tree as $i => $cat)
												<li style="list-style: none; padding-left: {{ ($i+1)*18 }}px">{{ $cat->code.' - '.$cat->name }}</li>
											@endforeach
											</ul>
										</div>
										@endif
									</div>
								</div>
							</td>
						</tr>

						<!-- Criteria -->
						<tr>
							<th class="text-middle">
								{{ Lang::get('app.criteria') }}
							</th>
							<td>{{ $item->criteria }}</td>
						</tr>
	
						<!-- Media -->
						<tr>
							<th class="text-middle">
								{{ Lang::get('app.media') }}
							</th>
							<td>{{ $item->media }}</td>
						</tr>

						<!-- Provider -->
						<tr>
							<th class="text-middle">
								{{ Lang::get('app.provider') }}
							</th>
							<td>{{ $item->provider?$item->provider:'-' }}</td>
						</tr>

						<!-- Date -->
						<tr>
							<th class="text-middle">
								{{ Lang::get('app.date') }}
							</th>
							@if($item->date)
								@if($item->date_type == 0)
									<td>{{ date("d F Y", strtotime($item->date)) }}</td>
								@elseif($item->date_type == 1)
									<td>{{ date("F Y", strtotime($item->date)) }}</td>
								@elseif($item->date_type == 2)
									<td>{{ date("Y", strtotime($item->date)) }}</td>
								@endif
							@else
								<td> - </td>
							@endif
						</tr>

						<!-- Quantiy -->
						<tr>
							<th class="text-middle">
								{{ Lang::get('app.quantity') }}
							</th>
							<td>{{ $item->quantity . ' ' . Lang::get('app.' . $item->unit) }}</td>
						</tr>

						<!-- Progress -->
						<tr>
							<th class="text-middle">
								{{ Lang::get('app.progress') }}
							</th>
							<td>{{ $item->progress }}</td>
						</tr>

						<!-- Input Descriptions -->
						<tr>
							<th class="text-middle">
								{{ Lang::get('app.descriptions') }}
							</th>
							<td>{{ $item->descriptions }}</td>
						</tr>

						<!-- Section -->
						<tr>
							<th class="text-middle">
								{{ Lang::get('app.save_to') }}
							</th>
							<td><div>
								<table class="table table-bordered">
									<tbody>
										<tr>
											<th style="width: 20%">{{ Lang::get('app.room') }}</th>
											<td style="width: 80%">{{ $item->section->box->shelf->room->name }}</td>
										</tr>
										<tr>
											<th style="width: 20%">{{ Lang::get('app.shelf') }}</th>
											<td style="width: 80%">{{ $item->section->box->shelf->name }}</td>
										</tr>
										<tr>
											<th style="width: 20%">{{ Lang::get('app.box') }}</th>
											<td style="width: 80%">{{ $item->section->box->name }}</td>
										</tr>
										<tr>
											<th style="width: 20%">{{ Lang::get('app.section') }}</th>
											<td style="width: 80%">{{ $item->section ? $item->section->name : '' }}</td>
										</tr>
									</tbody>
								</table>
							</div></td>
						</tr>

						<!-- Value -->
						<tr>
							<th class="text-middle">
								{{ Lang::get('app.record_value') }}
							</th>
							<td>{{ $item->value?$item->value:'-' }}</td>
						</tr>
					</tbody>
				</table>
			</div>

			<input type="hidden" id="id" name="id" value="{{ $item->id }}">
		</div>
	</div>
</div>
@endsection
