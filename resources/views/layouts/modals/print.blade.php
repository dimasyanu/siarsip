<div class="modal fade" role="dialog" id="print-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">{{ Lang::get('app.print') }}</h4>
			</div>
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="form-group row form-horizontal">
						<label for="select-storage" class="col-md-4 control-label">{{ Lang::get('app.select_storage_print') }}</label>
						<div class="col-md-8">
							<div class="btn-group">
								<a class="print-by btn btn-default active" data-toggle="room">{{ Lang::get('app.room') }}</a>
								<a class="print-by btn btn-default" data-toggle="shelf">{{ Lang::get('app.shelf') }}</a>
								<a class="print-by btn btn-default" data-toggle="box">{{ Lang::get('app.box') }}</a>
							</div>
						</div>
					</div>
					<hr>
					<div>
						<div class="form-group row">
							<label for="print_room" class="col-sm-3 control-label">{{ Lang::get('app.room') }}</label>
							<div class="col-sm-6 col-md-6">
								<select id="print_room" class="select2" name="room" style="width: 100%;" data-chain="#print_shelf">
									<option value="0">{{ Lang::get('app.select_item', ['item' => Lang::get('app.room')]) }}</option>
									@foreach($references->rooms as $i => $room)
									<option value="{{ $room->id }}" @if($filters->room_id == $room->id) selected @endif>{{ $room->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div id="print-by-shelf" class="collapse">
						<div class="form-group row">
							<label for="print_shelf" class="col-sm-3 control-label">{{ Lang::get('app.shelf') }}</label>
							<div class="col-sm-6 col-md-6">
								<select id="print_shelf" class="select2" name="shelf" style="width: 100%;" data-chain="#print_box" data-alias="shelves" 
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
					</div>
					<div id="print-by-box" class="collapse">
						<div class="form-group row">
							<label for="print_box" class="col-sm-3 control-label">{{ Lang::get('app.box') }}</label>
							<div class="col-sm-6 col-md-6">
								<select id="print_box" class="select2" name="box" style="width: 100%;" data-chain="#print_section" data-alias="boxes" 
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
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="confirm-print" class="btn btn-info">{{ Lang::get('app.print') }}</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('app.cancel') }}</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	
	function printCollapseCallback(param) {
		if(param == 'room') {
			$('#print-by-shelf').collapse('hide');
			$('#print-by-box').collapse('hide');
		}
		else if(param == 'shelf') {
			$('#print-by-shelf').collapse('show');
			$('#print-by-box').collapse('hide');
		}
		else if(param == 'box') {
			$('#print-by-shelf').collapse('show');
			$('#print-by-box').collapse('show');
		}
	}

	$(document).ready(function() {
		$('#print-btn').click(function(event) {
			$('#print-modal').modal('show');
		});

		chainSelect2($('#print_room'));

		$('.btn.print-by').each(function(index, el) {
			$(el).click(function(event) {
				if(!$(this).hasClass('active')){
					$('.btn.print-by.active').removeClass('active');
					$(this).addClass('active');

					printCollapseCallback($(this).data('toggle'));
				}
			});
		});

		$('.collapse').collapse('hide');

		$('#confirm-print').click(function(event) {
			var print_by = $('.print-by.active').data('toggle');
			var by_id = $('#print_' + print_by).val()
			if(by_id && by_id != 0)
				window.open("{{ url('records/print') }}/" + print_by + '/' + by_id);
			else
				$('#print-modal').animateCss('shake');
		});
	});
</script>