@php 
	if($options->action == 'new')
		$url = url('api/' . $options->storage . '/new');
	else
		$url = url('api/storage/edit/' . $options->storage . '/' . $item->id);
@endphp

{{ Form::open(['url' => $url, 'method' => 'POST', 'class' => 'form-horizontal']) }}
	<div class="form-group row">
		<label for="input-room" class="col-sm-4 control-label">{{ Lang::get('app.room') }}</label>
		<div class="col-sm-5 col-md-5">
			<input id="input-room" name="room" type="text" class="form-control" value="{{ $room->name }}" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label for="input-room" class="col-sm-4 control-label">{{ Lang::get('app.shelf') }}</label>
		<div class="col-sm-5 col-md-5">
			<input id="input-shelf" name="shelf" type="text" class="form-control" value="{{ $shelf->name }}" disabled>
			<input type="hidden" name="shelf_id" value="{{ $shelf->id }}">
		</div>
	</div>
	<div class="form-group row">
		<label for="input-name" class="col-sm-4 control-label">{{ Lang::get('app.name') }}</label>
		<div class="col-sm-5 col-md-5">
			<input id="input-name" name="name" type="text" class="form-control" value="{{ old('name', $item->name) }}" required>
		</div>
	</div>
{{ Form::close() }}
<script src="{{ asset('js/SubmitFormOnEnter.js') }}"></script>