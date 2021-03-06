<div class="act-btn pull-right btn-group" role="group" style="display: none;">
	<button class="add-storage btn btn-success btn-xs" data-toggle="tooltip" data-placement="bottom" title="{{ Lang::get('app.new_item', ['item' => Lang::get('app.' . $child)]) }}">
		<i class="fa fa-plus" aria-hidden="true"></i> 
		{{ Lang::get('app.' . $child) }}
	</button>
	<button type="button" class="edit-storage btn btn-warning btn-xs" data-toggle="tooltip" data-placement="bottom" title="{{ Lang::get('app.edit_item', ['item' => Lang::get('app.' . $storage)]) }}">
		<i class="fa fa-pencil" aria-hidden="true"></i> 
		{{ Lang::get('app.edit') }}
	</button>
	<a href="javascript:void(0);" class="delete-btn btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="{{ Lang::get('app.delete', ['item' => Lang::get('app.' . $storage)]) }}">
		<i class="fa fa-trash" aria-hidden="true"></i> 
		{{ Lang::get('app.delete') }}
		<form action="{{ url('api/storage/delete/' . $storage . '/' . $item_id) }}" method="post">
			{{ csrf_field() }}
			{{ method_field('DELETE') }}
		</form>
	</a>
</div>