@extends('layouts.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
    	<div class="row">
			<div class="col-md-6" style="font-size: 14pt;">
				@php $action = (!empty($item->id))? 'app.edit' : 'app.new'; @endphp
				{{ Lang::get($action, ['item' => Lang::get('app.box')]) }}
			</div>
    	</div>
    </div>

    <div class="panel-body">
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

    	@php $method = (empty($item->id))? 'post' : 'put'; @endphp
		{{ Form::open(['url' => url('boxes/'.$item->id), 'method' => $method, 'class' => 'form-horizontal']) }}
			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">{{ Lang::get('app.room') }}</label>
				<div class="col-sm-4 col-md-4">
					<select id="select_room" class="select2" name="room_id" style="width: 100%;">
						<option value="0">Pilih Ruangan...</option>
						@foreach($references->rooms as $i => $room)
						<option value="{{ $room->id }}" @if($item->room_id == $room->id) selected @endif>{{ $room->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">{{ Lang::get('app.shelf') }}</label>
				<div class="col-sm-4 col-md-4">
					<select id="select_shelf" class="select2" name="shelf_id" style="width: 100%;">
					<option value="{{ $references->shelf->id }}" selected>{{ $references->shelf->name }}</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">{{ Lang::get('app.name') }}</label>
				<div class="col-sm-4 col-md-4">
					<input id="name" name="name" type="text" class="form-control" value="{{ old('name', $item->name) }}" required>
				</div>
			</div>
			<input type="hidden" id="id" name="id" value="{{ $item->id }}">
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="btn-group" role="group">
						<button type="submit" class="btn btn-success" name="action" value="save">
							<i class="fa fa-save"></i>  {{ Lang::get('app.save') }}
						</button>
						<button type="submit" class="btn btn-primary" name="action" value="save-new">
							<i class="fa fa-copy"></i>  {{ Lang::get('app.save_and_new') }}
						</button>
						<button type="submit" class="btn btn-info" name="action" value="save-close">
							<i class="fa fa-check-square-o"></i>  {{ Lang::get('app.save_and_close') }}
						</button>
						<a href="{{ url('boxes') }}" class="btn btn-default">
							<i class="fa fa-times"></i>  {{ Lang::get('app.cancel') }}
						</a>
					</div>
				</div>
			</div>
		{{ Form::close() }}
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		var shlefId = $('#select_shelf').val();
		$('.select2').select2();

		checkRoom($('#select_room').val());

		$('#select_room').on("select2:select", function(e) {
			checkRoom($(this).val());
		});

		function checkRoom(id) {
			$('#select_shelf').empty();
			if(id == 0){
				$('#select_shelf').prop('disabled', true);
			}
			else{
				$.ajax({
					url: root + '/api/shelves/' + id,
					type: 'GET',
					dataType: 'json',
					data: {}
				})
				.done(function(results) {
					if(results.length > 0){
						var data = [];
						$('#select_shelf').append($('<option>', {
							value: "0",
							text: 'Pilih Rak\\Lemari..'
						}));
						for(var i = 0; i < results.length; i++){
							$('#select_shelf').append($('<option>', {
								value: results[i].id,
								text: results[i].name
							}));
						}
						$('#select_shelf').trigger('change').val(shlefId);

						$('#select_shelf').prop('disabled', false);
					}
					else if(!$('#select_shelf').prop('disabled'))
						$('#select_shelf').prop('disabled', true);
				})
				.fail(function() {
					console.log("Ajax error");
				});
			}
		}
	});
</script>
@endsection
