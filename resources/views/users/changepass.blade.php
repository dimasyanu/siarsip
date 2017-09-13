@extends('layouts.app')

@section('content')
<div class="app-contents">
	<div class="card">
	    <div class="card-header">
	    	<div class="row">
				<div class="col-md-6" style="font-size: 14pt;">
					{{ Lang::get('app.change_password') }}
				</div>
	    	</div>
	    </div>

	    <div class="card-body">
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

	    	<div class="edit-form">
				{{ Form::open(['url' => url('users/'.$item->id.'/changepass'), 'method' => 'POST', 'class' => 'form-horizontal']) }}
					<div class="form-group row">
						<label for="username" class="col-sm-2 col-form-label">{{ Lang::get('app.username') }}</label>
						<div class="col-sm-4 col-md-3">
							<input id="username" name="username" type="text" class="form-control" value="{{ old('username', $item->username) }}" disabled>
						</div>
					</div>
					<div class="form-group row">
						<label for="old-password" class="col-sm-2 col-form-label">{{ Lang::get('app.old_password') }}</label>
						<div class="col-sm-4 col-md-3">
							<input id="old-password" name="old_password" type="password" class="form-control" required>
						</div>
					</div>
					<div class="form-group row">
						<label for="new-password" class="col-sm-2 col-form-label">{{ Lang::get('app.new_password') }}</label>
						<div class="col-sm-4 col-md-3">
							<input id="new-password" name="new_password" type="password" class="form-control" required>
						</div>
					</div>
					<div class="form-group row">
						<label for="confirm-password" class="col-sm-2 col-form-label">{{ Lang::get('app.confirm_new_password') }}</label>
						<div class="col-sm-4 col-md-3">
							<input id="confirm-password" name="confirm_password" type="password" class="form-control" required>
						</div>
					</div>
					<input type="hidden" id="id" name="id" value="{{ $item->id }}">
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="btn-group" role="group">
								<button type="submit" class="btn btn-success" name="action" value="save">
									<i class="fa fa-save"></i>  {{ Lang::get('app.save') }}
								</button>
								<a href="{{ url('users') }}" class="btn btn-light">
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
@endsection
