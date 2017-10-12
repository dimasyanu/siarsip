@php 
	if($options->action == 'new')
		$url = url('api/' . $options->storage . '/new');
	else
		$url = url('api/' . $options->storage . '/edit/' . $item->id);
@endphp

{{ Form::open(['url' => $url, 'method' => 'POST', 'class' => 'form-horizontal']) }}
	<div class="form-group row">
		<label for="input-name" class="col-sm-4 control-label">{{ Lang::get('app.name') }}</label>
		<div class="col-sm-5 col-md-5">
			<input id="input-name" name="name" type="text" class="form-control" value="{{ old('name', $item->name) }}" required>
		</div>
	</div>
{{ Form::close() }}