@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/list-table.css') }}">
<div class="app-contents">
	<div class="panel auto-y">
		<div class="panel-heading">
			<i class="fa fa-cubes fa-2x"></i>
			<h3>{{ Lang::get('app.data') . ' ' . Lang::get('app.storages') }}</h3>
		</div>
		<div class="panel-body">
			@if(session('messages'))
				<div class="alert @if(session('status') == 1) alert-success @else alert-danger @endif" role="alert">{{ session('messages') }}</div>
			@endif
			<button id="add-room" class="btn btn-success" style="margin-bottom: 15px;">
				<i class="fa fa-plus"></i>
				{{ Lang::get('app.new_item', ['item' => Lang::get('app.room')]) }}
			</button>
			<div class="list-table"><ul>
				@if(sizeof($storages) > 0)
				@foreach($storages as $room)
					<li class="col-md-12{{ $room->shelves?'':' empty' }}">
						<div class="col-md-9 collapsed" data-toggle="collapse" data-target="#room-{{ $room->id }}" aria-expanded="false" data-id="{{ $room->id }}" data-name="{{ $room->name }}">
							<span class="room"></span>{{ $room->name }}
						</div>
						<div class="col-md-3">
							<div class="room-actions act-btn pull-right btn-group" role="group" style="display: none;">
								<a href="{{ url('shelves/create?room_id='.$room->id) }}" type="button" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="bottom" title="{{ Lang::get('app.new_item', ['item' => Lang::get('app.shelf')]) }}">
									<i class="fa fa-plus" aria-hidden="true"></i> 
									{{ Lang::get('app.new', ['item' => '']) }}
								</a>
								<button type="button" class="edit-room btn btn-warning btn-xs" data-toggle="tooltip" data-placement="bottom" title="{{ Lang::get('app.edit', ['item' => Lang::get('app.room')]) }}">
									<i class="fa fa-pencil" aria-hidden="true"></i> 
									{{ Lang::get('app.edit') }}
								</button>
								<a href="javascript:void(0);" class="delete-btn btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="{{ Lang::get('app.delete', ['item' => Lang::get('app.room')]) }}">
									<i class="fa fa-trash" aria-hidden="true"></i> 
									{{ Lang::get('app.delete') }}
									<form action="{{ url('api/room/delete/' . $room->id) }}" method="post">
										{{ csrf_field() }}
										{{ method_field('DELETE') }}
									</form>
								</a>
							</div>
						</div>
					</li>
					@if($room->shelves)
					<ul id="room-{{ $room->id }}" class="sub-list collapse col-md-12">
						@foreach($room->shelves as $j => $shelf)
						<li class="col-md-12{{ $shelf->boxes?'':' empty' }}">
							<div class="col-md-9 collapsed" style="padding-left: 32px;" data-toggle="collapse" data-target="#shelf-{{ $shelf->id }}" class="accordion-toggle">
							<span class="shelf"></span> {{ $shelf->name }}</div>
						</li>
						@if($shelf->boxes)
						<ul id="shelf-{{ $shelf->id }}" class="sub-list collapse col-md-12">
							@foreach($shelf->boxes as $k => $box)
							<li class="col-md-12{{ $box->sections?'':' empty' }}">
								<div class="col-md-9 collapsed" style="padding-left: 54px;" data-toggle="collapse" data-target="#box-{{ $box->id }}" class="accordion-toggle">
								<span class="box"></span>{{ $box->name }}</div>
							</li>
							@if($box->sections)
							<ul id="box-{{ $box->id }}" class="sub-list collapse col-md-12">
								@foreach($box->sections as $l => $section)
								<li class="col-md-12">
									<div class="col-md-9" style="padding-left: 76px;"><span class="section"></span>{{ $section->name }}</div>
								</li>
								@endforeach
							</ul>
							@endif
							@endforeach
						</ul>
						@endif
						@endforeach
					</ul>
					@endif
				@endforeach
				@endif
			</ul></div>
		</div>
	</div>
</div>

<!-- Include Room Modal -->
@include('storages/modals/edit_room');

<!-- Include Delete Modal -->
@include('storages/modals/delete');

<script type="text/javascript">

	var roomUrl          = "{{ url('api/room') }}";
	var addRoomTitle     = "{{ Lang::get('app.new_item', ['item' => Lang::get('app.room')]) }}";
	var editRoomTitle    = "{{ Lang::get('app.edit_item', ['item' => Lang::get('app.room')]) }}";

	var shelfUrl         = "{{ url('api/shelf') }}";
	var addShelfTitle    = "{{ Lang::get('app.new_item', ['item' => Lang::get('app.shelf')]) }}";
	var editShelfTitle   = "{{ Lang::get('app.edit_item', ['item' => Lang::get('app.shelf')]) }}";

	var boxUrl           = "{{ url('api/box') }}";
	var addBoxTitle      = "{{ Lang::get('app.new_item', ['item' => Lang::get('app.box')]) }}";
	var editBoxTitle     = "{{ Lang::get('app.edit_item', ['item' => Lang::get('app.box')]) }}";

	var sectionUrl       = "{{ url('api/section') }}";
	var addSectionTitle  = "{{ Lang::get('app.new_item', ['item' => Lang::get('app.section')]) }}";
	var editSectionTitle = "{{ Lang::get('app.edit_item', ['item' => Lang::get('app.section')]) }}";

	var deleteTitle 	 = {
		room: "{{ Lang::get('app.delete_item', ['item' => Lang::get('app.room')]) }}",
		shelf: "{{ Lang::get('app.delete_item', ['item' => Lang::get('app.shelf')]) }}",
		box: "{{ Lang::get('app.delete_item', ['item' => Lang::get('app.box')]) }}",
		section: "{{ Lang::get('app.delete_item', ['item' => Lang::get('app.section')]) }}"
	};

	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();
		$('.list-table li').hover(function(e) {
			$('.act-btn.show').removeClass('show');
			$(this).find('.act-btn').addClass('show');
		}, function() {
			$(this).find('.act-btn').removeClass('show');
		});

		var storages = @php echo json_encode($storages) @endphp;
		
		$('#add-room').click(function(event) {
			var modal = $('#edit-room-modal');
			modal.find('h4.modal-title').text(addRoomTitle);
			modal.find('form').attr('action', roomUrl + '/new');
			modal.find('#confirm-save').click(function(event) {
				modal.find('form').submit();
			});
			modal.modal('show');
		});

		$('.edit-room').click(function(event) {
			var id  	= $(this).closest('li').find('.collapsed').data('id');
			var name  	= $(this).closest('li').find('.collapsed').data('name');
			var modal 	= $('#edit-room-modal');
			modal.find('h4.modal-title').text(editRoomTitle);
			modal.find('form').attr('action', roomUrl + '/edit/' + id);
			modal.find('form #input-name').val(name);
			modal.find('#confirm-save').click(function(event) {
				modal.find('form').submit();
			});

			modal.modal('show');
		}); 

		$('.delete-btn').click(function(event) {
			var self    = this;
			var modal   = $('#delete-modal');
			var storage = $(this).closest('li').find('.collapsed span').attr('class');
			var name    = $(this).closest('li').find('.collapsed').data('name');

			modal.find('h4.modal-title').text(deleteTitle[storage]);
			modal.find('.modal-body strong').text(name);
			modal.find('#confirm-delete').click(function(event) {
				$(self).find('form').submit();
			});
			modal.modal('show');
		});
	});
</script>
@endsection
