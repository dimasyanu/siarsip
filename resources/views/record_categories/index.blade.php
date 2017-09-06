@extends('layouts.app')

@section('content')
@php 
	$has_filters = (
		$filters->search || 
		$filters->limit != 25
	);
@endphp
<div class="app-contents">
	<div class="card">

		<!-- Header -->
		<div class="card-header">
			<i class="fa fa-file-text fa-2x"></i>
			<h3>{{ Lang::get('app.data') . ' ' . Lang::get('app.categories') }}</h3>
			<div class="pull-right">
				<a class="btn btn-success" href="{{ url('categories/create') }}">
					<i class="fa fa-plus"></i>
					{{ Lang::get('app.add') . ' ' . Lang::get('app.categories') }}
				</a>
				<button type="button" class="filter-toggle btn btn-primary{{ $has_filters ? '' : ' collapsed' }}" data-toggle="collapse" data-target="#filter-panel">
					<i class="fa fa-filter"></i> {{ Lang::get('app.filter') }}
				</button>
			</div>
		</div>

		<!-- Filters panel -->
		<div id="filter-panel" class="row collapse{{ $has_filters ? ' show' : '' }}" style="margin: 0">
			<div class="row col-12">
				<div class="col-4">
					<form action="" class="search-form">
						<div class="form-group has-feedback{{ $filters->search ? ' open' : '' }}">
							<label for="search" class="sr-only">{{ Lang::get('app.search') }}</label>
							<input type="text" class="form-control" name="search" id="search" placeholder="{{ Lang::get('app.search') }}..." value="{{ $filters->search }}">
							<i class="fa fa-search form-control-feedback"></i>
							@if($filters->limit)
							<input type="hidden" name="limit" value="{{ $filters->limit }}">
							@endif    
						</div>
					</form>
				</div>
				<div class="col-2 ml-auto">
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
		</div>

		<!-- Body -->
		<div class="card-body">
			@if(session('messages'))
				<div class="alert @if(session('status') == 1) alert-success @else alert-danger @endif" role="alert">{{ session('messages') }}</div>
			@endif
			
			<table class="table table-header">
				<thead>
					<tr>
						<th class="text-center" style="width: 5%;">No.</th>
						<th class="data-code" style="width: 15%;">{{ Lang::get('app.code')}}</th>
						<th class="data-name" style="width: 65%;">{{ Lang::get('app.name')}}</th>
						<th class="text-center" style="width: 15%;">{{ Lang::get('app.actions') }}</th>
					</tr>
				</thead>
			</table>
			
			<div class="table-data">
				<table class="table table-striped">
					<tbody>
						@if($items->count() > 0)
							@foreach($items as $i => $item)
								@php $item->depth = count(explode('-', $item->code)); @endphp
								<tr data-id="{{ $item->id }}" class="{{ $item->depth==1?'top-parent':'' }}">
									<td class="text-center" style="width: 5%;">
										{{ ($items->perPage()*($items->currentPage()-1)) + $i + 1 }}
									</td>
									<td class="data-code" style="width: 15%;">{{ $item->code }}</td>
									<td class="data-name" style="width: 65%; padding-left: {{ 18*$item->depth }}px">{{ $item->name }}</td>
									<td style="width: 15%">
										<div class="action-buttons pull-right" role="group" style="display: none;">
											<a href="{{ url('categories/'.$item->id.'/edit') }}" class="btn btn-primary btn-sm">
												<i class="fa fa-pencil" aria-hidden="true"></i>
												{{ Lang::get('app.edit') }}
											</a>
											<a href="javascript:void(0);" class="delete-btn btn btn-danger btn-sm">
												<i class="fa fa-trash" aria-hidden="true"></i>
												{{ Lang::get('app.delete') }}
												<form action="{{ url('categories/' . $item->id) }}" method="post">
													{{ csrf_field() }}
													{{ method_field('DELETE') }}
												</form>
											</a>
										</div>
									</td>
								</tr>
							@endforeach
						@else
							<tr><td colspan="3" class="text-center">{{ Lang::get('app.no_items') }}</td></tr>
						@endif
					</tbody>
				</table>
				<div class="text-center">
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
<div class="modal fade" tabindex="-1" role="dialog" id="delete-modal">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">{{ Lang::get('app.delete_item') }}</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<p>{!! trans('app.delete_confirmation') !!}</p>
			</div>
			<div class="modal-footer">
				<button type="button" id="confirm-delete" class="btn btn-danger">{{ Lang::get('app.delete') }}</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('app.cancel') }}</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript" src="{{ asset('js/crud.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var selectedItem;
		$('.delete-btn').click(function(event) {
			selectedItem = $(this).closest('tr');
			var name = selectedItem.find('.data-name').text();
			itemId = selectedItem.data('id');
			$('#delete-modal').modal('show')
			.find('.modal-body').find('strong').text(name);
		});

		$('#delete-modal').on('show.bs.modal', function(e) {
			$('#confirm-delete').click(function(event) {
				selectedItem.find('.delete-btn form').submit();
			});
		});
	});
</script>
@endsection
