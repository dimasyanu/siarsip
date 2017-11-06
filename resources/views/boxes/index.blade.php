@extends('layouts.app')

@section('content')
<div class="app-contents">
	<div class="panel auto-y">
		<div class="panel-heading">
			<i class="fa fa-cubes fa-2x"></i>
			<h3>{{ Lang::get('app.data') . ' ' . Lang::get('app.boxes') }}</h3>
		</div>
		<div class="panel-body">
			<div class="container">

				@if(session('messages'))
					<div class="alert @if(session('status') == 1) alert-success @else alert-danger @endif" role="alert">{{ session('messages') }}</div>
				@endif

				<div style="margin: 10px 0;">
					@if(Auth::user()->user_group_id != 3)
					<a class="btn btn-success" href="{{ url('boxes/create') }}">
						<i class="fa fa-plus"></i>
						{{ Lang::get('app.add') . ' ' . Lang::get('app.box') }}
					</a>
					@endif

					<div class="col-md-3 pull-right">
						<form action="" class="search-form">
							<div class="form-group has-feedback">
								<label for="search" class="sr-only">{{ Lang::get('app.search') }}</label>
								<input type="text" class="form-control" name="search" id="search" placeholder="{{ Lang::get('app.search') }}..." value="{{ $filters->search }}">
								<i class="fa fa-search form-control-feedback"></i>
								@if($filters->limit)
								<input type="hidden" name="limit" value="{{ $filters->limit }}">
								@endif    
							</div>
						</form>
					</div>
				</div>
				
				<div class="table-data">
					<table class="table table-hover">
						<thead class="grey">
							<tr>
								<th class="text-center" style="width: 8%;">No.</th>
								<th style="width: 24%">Name</th>
								<th style="width: 24%">Rak</th>
								<th style="width: 24%">Ruangan</th>
								<th class="text-center" style="width: 20%;">{{ Lang::get('app.actions') }}</th>
							</tr>
						</thead>
						<tbody>
							@if($items->count() > 0)
								@foreach($items as $i => $item)
									<tr data-id="{{ $item->id }}">
										<td>
											{{ ($items->perPage()*($items->currentPage()-1)) + $i + 1 }}
										</td>
										<td class="data-name">{{ $item->name }}</td>
										<td class="data-shelf">{{ $item->shelf_name }}</td>
										<td class="data-room">{{ $item->room_name }}</td>
										<td>
											<div class="action-buttons btn-group pull-right" role="group" style="display: none;">
												@if($item->hasRecords)
												<a href="{{ url('box/print/'.$item->id) }}" class="btn btn-dark btn-xs" target="_blank">
													<i class="fa fa-print" aria-hidden="true"></i> 
													{{ Lang::get('app.print') }}
												</a>
												@endif

												@if(Auth::user()->user_group_id != 3)
												<a href="{{ url('boxes/'.$item->id.'/edit') }}" class="btn btn-primary btn-xs">
													<i class="fa fa-pencil" aria-hidden="true"></i>
													{{ Lang::get('app.edit') }}
												</a>
												<a href="javascript:void(0);" class="delete-btn btn btn-danger btn-xs">
													<i class="fa fa-trash" aria-hidden="true"></i> 
													{{ Lang::get('app.delete') }}
													<form action="{{ url('boxes/' . $item->id) }}" method="post">
														{{ csrf_field() }}
														{{ method_field('DELETE') }}
													</form>
												</a>
												@endif
											</div>
										</td>
									</tr>
								@endforeach
							@else
								<tr><td colspan="4" class="text-center">{{ Lang::get('app.no_items') }}</td></tr>
							@endif
						</tbody>
					</table>
				</div>
				<div class="row" style="display: inline-block; margin: 8px 0; width: 30%;">
					<label class="col-md-7" style="padding-top: 7px; margin-bottom: 0; text-align: right;">{{ Lang::get('app.data_per_page') }} :</label>
					<div class="col-md-4">
						<form action="{{ url()->current() }}">
							@if($filters->search)
							<input type="hidden" name="search" value="{{ $filters->search }}">
							@endif
							<select id="filter-limit" class="form-control" name="limit" onchange="this.form.submit()">
								<option value="5" {{ $items->perPage()==5?'selected':'' }}>5</option>
								<option value="10" {{ $items->perPage()==10?'selected':'' }}>10</option>
								<option value="15" {{ $items->perPage()==15?'selected':'' }}>15</option>
								<option value="25" {{ $items->perPage()==25?'selected':'' }}>25</option>
								<option value="50" {{ $items->perPage()==50?'selected':'' }}>50</option>
								<option value="100" {{ $items->perPage()==100?'selected':'' }}>100</option>
							</select>
						</form>
					</div>
				</div>
				<div class="pull-right">
					@php 
						$link_requests = array();

						if($filters->limit != 25)
							$link_requests['limit'] = $filters->limit;
							
						if($filters->search)
							$link_requests['search'] = $filters->search;
					@endphp

					{{ $items->appends($link_requests)->links() }}
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Delete Modal -->
@include('layouts.modals.delete')

<script type="text/javascript" src="{{ asset('js/crud.js') }}"></script>
@endsection
