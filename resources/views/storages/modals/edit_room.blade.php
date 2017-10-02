<div class="modal fade" role="dialog" id="edit-room-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				{{ Form::open(['method' => 'POST', 'class' => 'form-horizontal']) }}
					<div class="form-group row">
						<label for="input-name" class="col-sm-4 control-label">{{ Lang::get('app.name') }}</label>
						<div class="col-sm-5 col-md-5">
							<input id="input-name" name="name" type="text" class="form-control" value="" required>
						</div>
					</div>
				{{ Form::close() }}
			</div>
			<div class="modal-footer">
				<button type="button" id="confirm-save" class="btn btn-success">{{ Lang::get('app.save') }}</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('app.cancel') }}</button>
			</div>
		</div>
	</div>
</div>