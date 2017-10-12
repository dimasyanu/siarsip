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
			<div class="storage-info" data-contains="room">
				<button id="add-room" class="add-storage btn btn-success" style="margin-bottom: 15px;">
					<i class="fa fa-plus"></i>
					{{ Lang::get('app.new_item', ['item' => Lang::get('app.room')]) }}
				</button>
			</div>
			<div class="list-table"><ul>
				@if(sizeof($storages) > 0)
				@foreach($storages as $room)
					<li class="col-md-12{{ $room->shelves?'':' empty' }}">
						<div class="col-md-9 collapsed" data-toggle="collapse" data-target="#room-{{ $room->id }}" aria-expanded="false" data-name="{{ $room->name }}">
							<span class="room"></span>{{ $room->name }}
						</div>
						<div class="storage-info col-md-3" data-storage="room" data-contains="shelf" data-id="{{ $room->id }}">
							@include('storages/action_btn', ['storage_act' => 'shelf', 'item_id' => $room->id])
						</div>
					</li>
					@if($room->shelves)
					<ul id="room-{{ $room->id }}" class="sub-list collapse col-md-12">
						@foreach($room->shelves as $j => $shelf)
						<li class="col-md-12{{ $shelf->boxes?'':' empty' }}">
							<div class="col-md-9 collapsed" style="padding-left: 32px;" data-toggle="collapse" data-target="#shelf-{{ $shelf->id }}" class="accordion-toggle"  data-name="{{ $shelf->name }}">
							<span class="shelf"></span> {{ $shelf->name }}</div>
							<div class="storage-info col-md-3" data-storage="shelf" data-contains="box" data-id="{{ $shelf->id }}">
								@include('storages/action_btn', ['storage_act' => 'box', 'item_id' => $shelf->id])
							</div>
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
@include('storages/modals/edit_storage');

<!-- Include Delete Modal -->
@include('storages/modals/delete');

<script type="text/javascript">

	var addRoomTitle     = "{{ Lang::get('app.new_item', ['item' => Lang::get('app.room')]) }}";
	var editRoomTitle    = "{{ Lang::get('app.edit_item', ['item' => Lang::get('app.room')]) }}";

	var addShelfTitle    = "{{ Lang::get('app.new_item', ['item' => Lang::get('app.shelf')]) }}";
	var editShelfTitle   = "{{ Lang::get('app.edit_item', ['item' => Lang::get('app.shelf')]) }}";

	var addBoxTitle      = "{{ Lang::get('app.new_item', ['item' => Lang::get('app.box')]) }}";
	var editBoxTitle     = "{{ Lang::get('app.edit_item', ['item' => Lang::get('app.box')]) }}";

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
		
		$('.add-storage').click(function(event) {
			var id = $(this).closest('.storage-info').data('id');
			var modal = $('#edit-room-modal');
			var child = $(this).closest('.storage-info').data('contains');
			var storage = $(this).closest('.storage-info').data('storage');
			modal.find('h4.modal-title').text(addRoomTitle);
			modal.find('.modal-body').empty();

			$.ajax({
				url: root + '/api/' + child + '/form' + (id?'?'+storage+'_id='+id:''),
				type: 'GET',
				dataType: 'html',
				data: {'action' : 'new'},
				success: function(result) {
					modal.find('.modal-body').append(result);
					modal.modal('show');
				},
				error: function() {
					console.log("Ajax Error");
				}
			});

			modal.find('#confirm-save').click(function(event) {
				modal.find('form').submit();
			});
		});

		$('.edit-storage').click(function(event) {
			var id  	= $(this).closest('.storage-info').data('id');
			var modal 	= $('#edit-room-modal');
			var storage = $(this).closest('.storage-info').data('storage');

			modal.find('h4.modal-title').text(editRoomTitle);
			modal.find('.modal-body').empty();
			
			$.ajax({
				url: root + '/api/' + storage + '/form/' + id,
				type: 'GET',
				dataType: 'html',
				success: function(result) {
					modal.find('.modal-body').append(result);
					modal.modal('show');
				},
				error: function() {
					console.log("Ajax Error");
				}
			});

			modal.find('#confirm-save').click(function(event) {
				modal.find('form').submit();
			});
		}); 

		$('.delete-btn').click(function(event) {
			var self    = this;
			var modal   = $('#delete-modal');
			var storage = $(this).closest('.storage-info').data('storage');
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
