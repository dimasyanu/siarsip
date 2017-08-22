@extends('layouts.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
    	<div class="row">
			<div class="col-md-6" style="font-size: 14pt;">
				@php $action = (!empty($item->id))? 'app.edit' : 'app.new'; @endphp
				{{ Lang::get($action, ['item' => Lang::get('app.category')]) }}
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
		{{ Form::open(['url' => url('categories/'.$item->id), 'method' => $method, 'class' => 'form-horizontal']) }}
			<div class="form-group">
				<label for="parent_id" class="col-sm-2 control-label">{{ Lang::get('app.parent') }}</label>
				<div class="col-sm-8 col-md-8">
					<div class="panel panel default">
						<div class="panel-body">
							<select id="select_parent" class="select2" name="parent_id" style="width: 50%;">
								@if($parent->closest)
								<option value="{{ $parent->closest->id }}">{{ $parent->closest->code . ' - ' . $parent->closest->name }}</option>
								@else
								<option value="0">{{ Lang::get('app.select_item', ['item' => Lang::get('app.categories')]) }}</option>
								@endif
							</select>
							<div class="tree">
								<ul>
								@if($parent->tree)
								@for($i = 0; $i < sizeof($parent->tree)-1; $i++)
									<li style="list-style: none; padding-left: {{ $i*18 }}px">{{ $parent->tree[$i]->code.' - '.$parent->tree[$i]->name }}</li>
								@endfor
								@endif
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">{{ Lang::get('app.code') }}</label>
				<div class="col-sm-4 col-md-3">
					<div class="input-group">
						<div id="parent_code" class="input-group-addon">{{ $parent->closest?($parent->closest->code . '-'):'' }}</div>
						@php $curr_code = explode('-', $item->code) @endphp
						<input id="new_code" type="text" class="form-control" value="{{ end($curr_code) }}" required="true">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">{{ Lang::get('app.name') }}</label>
				<div class="col-sm-4 col-md-6">
					<textarea id="name" name="name" type="text" class="form-control" required="true">{{ old('name', $item->name) }}</textarea>
				</div>
			</div>
			<input type="hidden" name="code">
			<input type="hidden" id="id" name="id" value="{{ $item->id }}">
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="btn-group" role="group">
						<button class="submit-btn btn btn-success" data-action="save">
							<i class="fa fa-save"></i>  {{ Lang::get('app.save') }}
						</button>
						<button class="submit-btn btn btn-primary" data-action="save-new">
							<i class="fa fa-copy"></i>  {{ Lang::get('app.save_and_new') }}
						</button>
						<button class="submit-btn btn btn-info" data-action="save-close">
							<i class="fa fa-check-square-o"></i>  {{ Lang::get('app.save_and_close') }}
						</button>
						<a href="{{ url('categories') }}" class="btn btn-default">
							<i class="fa fa-times"></i>  {{ Lang::get('app.cancel') }}
						</a>
					</div>
				</div>
				<input type="hidden" name="action" value="save">
			</div>
		{{ Form::close() }}
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		var parentCat = null;
		$('.select2').select2({
			ajax: {
				url: root + '/api/categories',
				dataType: 'json',
				data: function (params) {
					return {
						q: params.term
					};
				},
				processResults: function (data, params) {
					var items = [];
					for(var i = 0; i < data.length; i++) {
						items.push({id: data[i].id, text: data[i].code + ' - ' + data[i].name});
					}
					return {
						results: items
					};
				},
				cache: true
			},
			escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
			minimumInputLength: 1
		});
		$('.select2').on('select2:select', function() {
			var catid = $(this).val();
			simpleAjax(root + '/api/category', {id: catid}, function(result) {
				$('#parent_code').text(result+'-');
			});
			simpleAjax(root + '/api/nestedcat', {id: catid}, function(results) {
				$('.tree ul').empty();
				for(var i = 0; i < results.length; i++) {
					var li = document.createElement('li');
					li.innerHTML = results[i].code+' - '+results[i].name;
					$(li).css({
						'padding-left': i*18 + 'px',
						'list-style': 'none'
					});
					$('.tree ul').append(li);
				}
			});
		});
		$('.submit-btn').click(function(event) {
			$('[name="action"]').val($(this).data('action'));
			$('[name="code"]').val($('#parent_code').text() + $('#new_code').val());
			// $(this).closest('form').submit();
		});

		function simpleAjax(url, data, func) {
			$.ajax({
				url: url,
				type: 'GET',
				dataType: 'json',
				data: data
			})
			.done(function(result) {
				func(result);
			})
			.fail(function() {
				console.log("Ajax error");
			});
		}
	});
</script>
@endsection
