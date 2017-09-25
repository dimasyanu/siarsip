<div class="modal fade" tabindex="-1" role="dialog" id="print-modal">
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
								<button class="btn btn-default active">{{ Lang::get('app.room') }}</button>
								<button class="btn btn-default">{{ Lang::get('app.shelf') }}</button>
								<button class="btn btn-default">{{ Lang::get('app.box') }}</button>
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
	$(document).ready(function() {
		$('#print-btn').click(function(event) {
			$('#print-modal').modal('show');
		});
	});
</script>