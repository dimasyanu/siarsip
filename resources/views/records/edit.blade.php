@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
<div class="app-contents">
	<div class="panel auto-y">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-6" style="font-size: 14pt;">
					@php $action = (!empty($item->id))? 'app.edit_item' : 'app.new'; @endphp
					{{ Lang::get($action, ['item' => Lang::get('app.record')]) }}
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
			<div class="container" style="margin-top: 16px">
				{{ Form::open(['url' => url('records/'.$item->id), 'method' => $method, 'class' => 'form-horizontal']) }}
					
					<!-- Input Category -->
					<div class="form-group row">
						<label for="input-category" class="col-sm-3 control-label">{{ Lang::get('app.category') }}</label>
						<div class="col-sm-8 col-md-8">
							<div class="panel panel-default">
								<div class="panel-body">
									<select id="select_category" class="select2-remote" name="category_id" style="width: 50%;">
										@if($item->category != null)
										<option value="{{ $item->category->id }}">{{ $item->category->code . ' - ' . $item->category->name }}</option>
										@else
										<option value="0">{{ Lang::get('app.select_item', ['item' => Lang::get('app.categories')]) }}</option>
										@endif
									</select>
									<div class="tree">
										<ul>
										@if($item->category)
										@foreach($item->category->tree as $i => $cat)
											<li style="list-style: none; padding-left: {{ ($i+1)*18 }}px">{{ $cat->code.' - '.$cat->name }}</li>
										@endforeach
										@endif
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Input Name -->
					<div class="form-group row">
						<label for="input-name" class="col-sm-3 control-label">{{ Lang::get('app.content') }}</label>
						<div class="col-sm-4 col-md-4">
							<textarea id="input-name" name="name" type="text" class="form-control" maxlength="100" style="resize: vertical;" required>{{ old('name', $item->name) }}</textarea>
						</div>
						<div class="alert alert-warning col-sm-4 col-md-3">
							{{ Lang::get('app.input_max_letters', ['amount' => 100]) }}
						</div>
					</div>
					
					<!-- Input Vendor -->
					<div class="form-group row">
						<label for="input-vendor" class="col-sm-3 control-label">{{ Lang::get('app.vendor') }}</label>
						<div class="col-sm-4 col-md-4">
							<input class="form-control" type="text" name="vendor" value="{{ old('vendor', $item->vendor) }}">
						</div>
					</div>

					<!-- Input Value -->
					<div class="form-group row">
						<label for="input-value" class="col-sm-3 control-label">{{ Lang::get('app.record_value') }}</label>
						<div class="col-sm-3 col-md-3 input-group" style="padding: 0 15px;">
							<span class="input-group-addon">Rp.</span>
							<input id="input-value" class="form-control text-right" type="text" name="value" value="{{ old('value', $item->value) }}">
						</div>	
					</div>

					<!-- Input Date -->
					<div class="form-group row">
						<label for="input-date" class="col-sm-3 control-label">{{ Lang::get('app.date') }}</label>
						<div class="col-sm-2 col-md-2">
							<input id="input-date" name="date" type="text" class="datepicker date form-control" value="{{ old('date', $item->date) }}">
						</div>
						<div class="col-sm-4 col-md-4 btn-group" style="padding-left: 0">
							<a class="datetype-toggle btn btn-default" data-type="days" data-code="0">{{ Lang::get('app.date') }}</a>
							<a class="datetype-toggle btn btn-default" data-type="months" data-code="1">{{ Lang::get('app.month') }}</a>
							<a class="datetype-toggle btn btn-default" data-type="years" data-code="2">{{ Lang::get('app.year') }}</a>
						</div>
						<input type="hidden" name="date_type" value="{{ old('date_type', $item->date_type) }}" required>
					</div>

					<!-- Input Quantiy -->
					<div class="form-group row">
						<label for="input-quantity" class="col-sm-3 control-label">{{ Lang::get('app.quantity') }}</label>
						<div class="col-sm-2 col-md-2">
							<input id="input-quantity" name="quantity" type="number" min="1" class="form-control" value="{{ old('quantity', $item->quantity) }}" required>
						</div>
						<div class="col-sm-2 col-md-2" style="padding-left: 0;">
							<select id="input-unit" name="unit" class="form-control" required>
								<option value="sheet">{{ Lang::get('app.sheet') }}</option>
								<option value="file">{{ Lang::get('app.file') }}</option>
							</select>
						</div>
					</div>

					<!-- Input Media -->
					<div class="form-group row">
						<label for="input-media" class="col-sm-3 control-label">{{ Lang::get('app.media') }}</label>
						<div class="col-sm-2 col-md-2">
							<select id="input-media" name="media" class="form-control" required>
								<option value="0">{{ Lang::get('app.select_item', ['item' => Lang::get('app.media')]) }} ...</option>
								@foreach($references->media as $m)
									<option value="{{ $m->id }}" @if($m->id == $item->media) selected @endif>{{ $m->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<!-- Input Criteria -->
					<div class="form-group row">
						<label for="input-criteria" class="col-sm-3 control-label">{{ Lang::get('app.criteria') }}</label>
						<div class="col-sm-2 col-md-2">
							<select id="input-criteria" name="criteria" class="form-control">
								<option value="0">{{ Lang::get('app.select_item', ['item' => Lang::get('app.criteria')]) }} ...</option>
								@foreach($references->criteria as $c)
								<option value="{{ $c->id }}" @if($c->id == $item->criteria) selected @endif>{{ $c->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<!-- Input Progress -->
					<div class="form-group row">
						<label for="input-progress" class="col-sm-3 control-label">{{ Lang::get('app.progress') }}</label>
						<div class="col-sm-4 col-md-2">
							<select name="progress" id="input-progress" class="form-control">
								<option value="0">{{ Lang::get('app.select_item', ['item' => '']) }} ...</option>
								@foreach($references->progress as $p)
									<option value="{{ $p->id }}" @if($p->id == $item->progress) selected @endif>{{ $p->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<!-- Input Descriptions -->
					<div class="form-group row">
						<label for="input-descriptions" class="col-sm-3 control-label">{{ Lang::get('app.descriptions') }}</label>
						<div class="col-sm-12 col-md-5">
							<textarea id="input-descriptions" name="descriptions" type="text" class="form-control" style="min-height: 150px">{{ old('descriptions', $item->descriptions) }}</textarea>
						</div>
					</div>

					<!-- Input Condition -->
					<div class="form-group row">
						<label for="input-condition" class="col-sm-3 control-label">{{ Lang::get('app.additional_information', ['item' => Lang::get('app.condition')]) }}</label>
						<div class="col-sm-12 col-md-5">
							<textarea id="input-condition" name="condition" type="text" class="form-control" style="min-height: 100px">{{ old('condition', $item->condition) }}</textarea>
						</div>
					</div>

					<!-- Input Section id -->
					<div class="form-group row">
						<label for="input-section-id" class="col-sm-3 control-label">{{ Lang::get('app.save_to') }}</label>
						<div class="col-sm-4 col-md-4">
							<a href="#" id="select-storage" class="btn btn-dark col-md-12">{{ $item->section ? $item->section->name : (Lang::get('app.select_item', ['item' => Lang::get('app.storage')])) }}</a>
							<input id="input-section-id" name="section_id" type="hidden" value="{{ old('section_id', $item->section_id) }}" required>
						</div>
					</div>

					<input type="hidden" id="id" name="id" value="{{ $item->id }}">
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
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
								<a href="{{ url('records') }}" class="btn btn-default">
									<i class="fa fa-times"></i>  {{ Lang::get('app.cancel') }}
								</a>
							</div>
						</div>
					</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

<!-- Storage-Select Modal -->
<div class="modal fade" role="dialog" id="storage-select-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">{{Lang::get('app.select_item', ['item' => Lang::get('app.storage')])}}</h4>
			</div>
			<div class="modal-body">
				<div class="form-horizontal">
					<!-- Select Room -->
					<div class="form-group row">
						<label for="select_room" class="col-sm-2 col-sm-offset-2 control-label">{{ Lang::get('app.room') }}</label>
						<div class="col-sm-6 col-md-6">
							<select id="select_room" class="select2" name="room_id" style="width: 100%;" data-chain="#select_shelf">
								<option value="0">{{ Lang::get('app.select_item', ['item' => Lang::get('app.room')]) }}</option>
								@foreach($references->rooms as $i => $room)
								<option value="{{ $room->id }}" @if($item->room_id == $room->id) selected @endif>{{ $room->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<!-- Select Shelf -->
					<div class="form-group row">
						<label for="select_shelf" class="col-sm-2 col-sm-offset-2 control-label">{{ Lang::get('app.shelf') }}</label>
						<div class="col-sm-6 col-md-6">
							<select id="select_shelf" class="select2" name="shelf_id" style="width: 100%;" data-chain="#select_box" data-alias="shelves">
								<option value="0">{{ Lang::get('app.select_item', ['item' => Lang::get('app.shelf')]) }}</option>
								@foreach($references->shelves as $i => $shelf)
								<option value="{{ $shelf->id }}" @if($item->shelf_id == $shelf->id) selected @endif>{{ $shelf->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<!-- Select Box -->
					<div class="form-group row">
						<label for="select_box" class="col-sm-2 col-sm-offset-2 control-label">{{ Lang::get('app.box') }}</label>
						<div class="col-sm-6 col-md-6">
							<select id="select_box" class="select2" name="box_id" style="width: 100%;" data-chain="#select_section" data-alias="boxes">
								<option value="0">{{ Lang::get('app.select_item', ['item' => Lang::get('app.box')]) }}</option>
								@foreach($references->boxes as $i => $box)
								<option value="{{ $box->id }}" @if($item->box_id == $box->id) selected @endif>{{ $box->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<!-- Select Section -->
					<div class="form-group row">
						<label for="select_section" class="col-sm-2 col-sm-offset-2 control-label">{{ Lang::get('app.section') }}</label>
						<div class="col-sm-6 col-md-6">
							<select id="select_section" class="select2" name="section_id" style="width: 100%;" data-alias="sections">
								<option value="0">{{ Lang::get('app.select_item', ['item' => Lang::get('app.section')]) }}</option>
								@foreach($references->sections as $i => $section)
								<option value="{{ $section->id }}" @if($item->section_id == $section->id) selected @endif>{{ $section->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="finish" class="btn btn-primary">{{ Lang::get('app.finish') }}</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('app.cancel') }}</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript" src="{{ asset('js/chained-select2.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/accounting.min.js') }}"></script>
<script type="text/javascript">
	if (!String.prototype.splice) {
	    String.prototype.splice = function(start, delCount, newSubStr) {
	        return this.slice(0, start) + newSubStr + this.slice(start + Math.abs(delCount));
	    };
	}

	$.fn.rupiah = function() { 
		return this.each(function() { 
			$(this).keypress(function(e) {
				return e.charCode == 0 || (e.charCode >= 48 && e.charCode <= 57);
			})
			.on('input', function() {
				var str = $(this).val();
				var val = parseInt(str.replace(/\./g, ''));
				if(val)
					str = accounting.formatNumber(val, [precision = 0], [thousand = "."], [decimal = ","]);
				$(this).val(str);
			});
		});
	};

	function setInputDateView(view) {
		var options = {
			format: 'dd-mm-yyyy',
			minViewMode: view,
			autoclose: true
		};

		var val = $('.datepicker.date').datepicker('getDates');
		$('.datepicker.date').datepicker('destroy');
		$('.datepicker.date').datepicker(options);
		$('.datepicker.date').datepicker('setDates', val);
	}

	$(document).ready(function() {
		setInputDateView('days');

		$('.select2').select2();
		chainSelect2($('#select_room'));

		$('.datetype-toggle').each(function(index, el) {
			$(el).click(function(event) {
				$('.datetype-toggle.active').removeClass('active');
				$(this).addClass('active');
				$('[name="date_type"]').val($(this).data('code'));

				setInputDateView($(this).data('type'));
			});
		});

		$('.datetype-toggle[data-code="{{ old('date_type', $item->date_type) }}"]').addClass('active');

		$('#select-storage').click(function(event) {
			var self = this;
			$('#storage-select-modal').modal('show');
			$('#storage-select-modal').find('.btn#finish')
			.click(function() {
				if($('#select_section').val() && $('#select_section').val() != 0){
					$('#input-section-id').val($('#select_section').val());
					$(self).text($('#select_section option:selected').text())
					$('#storage-select-modal').modal('hide');
				}else{
					$('#storage-select-modal').animateCss('shake');
				}
			});
		});

		$('.select2-remote').select2({
			ajax: {
				url: root + '/api/categories',
				dataType: 'json',
				data: function (params) {
					return { q: params.term };
				},
				processResults: function (data, params) {
					var items = [];
					for(var i = 0; i < data.length; i++)
						items.push({id: data[i].id, text: data[i].code + ' - ' + data[i].name});
					return { results: items };
				},
				cache: true
			},
			escapeMarkup: function (markup) { return markup; },
			minimumInputLength: 1
		}).on('select2:select', function(){
			var self = this;
			$.ajax({
				url: root + '/api/nestedcat',
				type: 'GET',
				dataType: 'json',
				data: { id: $(self).val() }
			})
			.done(function(results) {
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
			})
			.fail(function() {
				console.log("Ajax error");
			});
		});

		$('#input-unit').val('{{ $item->unit }}');
		$('#input-value').rupiah();
	});
</script>
@endsection
