@extends('layouts.app')

@section('content')
<div class="app-contents">
	<div class="panel auto-y">

		<!-- Header -->
		<div class="panel-heading">
			<i class="fa fa-folder-open fa-2x"></i>
			<h3>{{ Lang::get('app.data') . ' ' . Lang::get('app.sections') }}</h3>
		</div>

		<div class="panel-body">
			<div class="container">
				<!-- Filters Panel -->
				<div id="filter-panel" class="panel panel-defaut">
					<div class="panel-heading">
						<h4><i class="fa fa-filter"></i> {{ Lang::get('app.filter') }}</h4>
					</div>
					<div class="panel-body">
						<div class="col-md-6">
			            	<!-- Select Room -->
			                <div class="form-group row">
								<label for="select_room" class="col-sm-3 control-label">{{ Lang::get('app.room') }}</label>
								<div class="col-sm-6 col-md-6">
									<select id="select_room" class="select2" name="room" style="width: 100%;" data-chain="#select_shelf">
										<option value="0">{{ Lang::get('app.select_item', ['item' => Lang::get('app.room')]) }}</option>
										@foreach($references->rooms as $i => $room)
										<option value="{{ $room->id }}" @if($filters->room_id == $room->id) selected @endif>{{ $room->name }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<!-- Select Shelf -->
							<div class="form-group row">
								<label for="select_shelf" class="col-sm-3 control-label">{{ Lang::get('app.shelf') }}</label>
								<div class="col-sm-6 col-md-6">
									<select id="select_shelf" class="select2" name="shelf" style="width: 100%;" data-chain="#select_box" data-alias="shelves" 
										@if(sizeof($references->shelves))>
											<option value="0">{{ Lang::get('app.select_item', ['item' => Lang::get('app.shelf')]) }}</option>
											@foreach($references->shelves as $i => $shelf)
											<option value="{{ $shelf->id }}" @if($filters->shelf_id == $shelf->id) selected @endif>{{ $shelf->name }}</option>
											@endforeach
										@else
											disabled>
										@endif
									</select>
								</div>
							</div>

							<!-- Select Box -->
							<div class="form-group row">
								<label for="select_box" class="col-sm-3 control-label">{{ Lang::get('app.box') }}</label>
								<div class="col-sm-6 col-md-6">
									<select id="select_box" class="select2" name="box" style="width: 100%;" data-alias="boxes" 
										@if(sizeof($references->boxes))>
											<option value="0">{{ Lang::get('app.select_item', ['item' => Lang::get('app.box')]) }}</option>
											@foreach($references->boxes as $i => $box)
											<option value="{{ $box->id }}" @if($filters->box_id == $box->id) selected @endif>{{ $box->name }}</option>
											@endforeach
										@else
											disabled>
										@endif
									</select>
								</div>
							</div>
							<div class="col-md-12" style="margin-top: 24px;">
								<button id="filter-apply" class="btn btn-primary">{{ Lang::get('app.apply') }}</button>
								<a href="{{ url('sections') }}" class="btn btn-info">{{ Lang::get('app.reset') }}</a>
							</div>
						</div>
					</div>
				</div>

				@if(session('messages'))
					<div class="alert @if(session('status') == 1) alert-success @else alert-danger @endif" role="alert">{{ session('messages') }}</div>
				@endif

				<div style="margin: 10px 0;">
					@if(Auth::user()->user_group_id != 3)
					<a class="btn btn-success" href="{{ url('sections/create') }}">
						<i class="fa fa-plus"></i>
						{{ Lang::get('app.add') . ' ' . Lang::get('app.section') }}
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
							<th class="text-center" style="width: 7%;">No.</th>
								<th style="width: 19%">{{ Lang::get('app.name') }}</th>
								<th style="width: 19%">{{ Lang::get('app.box') }}</th>
								<th style="width: 19%">{{ Lang::get('app.shelf') }}</th>
								<th style="width: 19%">{{ Lang::get('app.room') }}</th>
								<th class="text-center" style="width: 17%;">{{ Lang::get('app.actions') }}
							</th>
						</thead>
						<tbody>
							@if($items->count() > 0)
								@foreach($items as $i => $item)
									<tr data-id="{{ $item->id }}">
										<td style="width: 7%;">
											{{ ($items->perPage()*($items->currentPage()-1)) + $i + 1 }}
										</td>
										<td class="data-name" style="width: 19%">{{ $item->name }}</td>
										<td class="data-box-name" style="width: 19%">{{ $item->box_name }}</td>
										<td class="data-shelf-name" style="width: 19%">{{ $item->shelf_name }}</td>
										<td class="data-room-name" style="width: 19%">{{ $item->room_name }}</td>
										<td style="width: 17%;">
											<div class="action-buttons btn-group pull-right" role="group" style="display: none;">
												@if(Auth::user()->user_group_id != 3)
												<a href="{{ url('sections/'.$item->id.'/edit') }}" class="btn btn-primary btn-xs">
													<i class="fa fa-pencil" aria-hidden="true"></i> 
													{{ Lang::get('app.edit') }}
												</a>
												<a href="javascript:void(0);" class="delete-btn btn btn-danger btn-xs">
													<i class="fa fa-trash" aria-hidden="true"></i> 
													{{ Lang::get('app.delete') }}
													<form action="{{ url('sections/' . $item->id) }}" method="post">
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
								<tr><td colspan="6" class="text-center">{{ Lang::get('app.no_items') }}</td></tr>
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
<script type="text/javascript" src="{{ asset('js/chained-select2.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.select2').select2();

		chainSelect2($('#select_room'));
		
		$('.search-form .form-group').focusin(function(event) { searchboxEnabled($(this)); });
		$('.search-form .form-group').focusout(function() { searchboxDisabled($(this)); });

		$('#filter-apply').click(function(event) {
			if($('#select_box').val() && $('#select_box').val() != 0)
				window.location = root + '/sections?box=' + $('#select_box').val();
			else if($('#select_shelf').val() && $('#select_shelf').val() != 0)
				window.location = root + '/sections?shelf=' + $('#select_shelf').val();
			else if($('#select_room').val() && $('#select_room').val() != 0)
				window.location = root + '/sections?room=' + $('#select_room').val();
		});

		function searchboxEnabled(elm) {
			elm.addClass('open');
		}

		function searchboxDisabled(elm) {
			if(elm.find('input.form-control').val() == '')
				elm.removeClass('open');
		}
	});
</script>
@endsection
