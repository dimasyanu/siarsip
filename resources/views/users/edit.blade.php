@extends('layouts.app')

@section('content')
<div class="app-contents">
	<div class="card">
	    <div class="card-header">
	    	<div class="row">
				<div class="col-md-6" style="font-size: 14pt;">
					@php $action = (!empty($item->id))? 'app.edit_item' : 'app.new'; @endphp
					{{ Lang::get($action, ['item' => Lang::get('app.user')]) }}
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

	    	@php $method = (empty($item->id))? 'post' : 'put'; @endphp
	    	<div class="edit-form">
				{{ Form::open(['url' => url('users/'.$item->id), 'method' => $method, 'class' => 'form-horizontal']) }}
					<div class="form-group row">
						<div class="col-sm-3 row">
							<label for="username" class="ml-md-auto col-form-label">{{ Lang::get('app.username') }}</label>
						</div>
						<div class="col-sm-4 col-md-3">
							<input id="username" name="username" type="text" class="form-control" value="{{ old('username', $item->username) }}" pattern="[a-z0-9]{3,15}" placeholder="Minimal 3 karakter (a-z/0-9)" required>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-3 row">
							<label for="name" class="ml-md-auto col-form-label">{{ Lang::get('app.name') }}</label>
						</div>
						<div class="col-sm-4 col-md-3">
							<input id="name" name="name" type="text" class="form-control" value="{{ old('name', $item->name) }}" required>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-3 row">
							<label for="email" class="ml-md-auto col-form-label">{{ Lang::get('app.email') }}</label>
						</div>
						<div class="col-sm-4 col-md-3">
							<input id="email" name="email" type="email" class="form-control" value="{{ old('email', $item->email) }}" required>
						</div>
					</div>
					@if (empty($item->id))
					<div class="form-group row">
						<div class="col-sm-3 row">
							<label for="password" class="ml-md-auto col-form-label">{{ Lang::get('app.password') }}</label>
						</div>
						<div class="col-sm-4 col-md-3">
							<input id="password" name="password" type="password" class="form-control" required>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-3 row">
							<label for="confirm-password" class="ml-md-auto col-form-label">{{ Lang::get('app.confirm_password') }}</label>
						</div>
						<div class="col-sm-4 col-md-3">
							<input id="confirm-password" name="confirm_password" type="password" class="form-control" required>
						</div>
					</div>
					@endif
					<input type="hidden" id="id" name="id" value="{{ $item->id }}">
					<div class="form-group">
						<div class="col-sm-9">
							<div class="btn-group" role="group">
								<button type="submit" class="btn btn-success" name="action" value="save">
									<i class="fa fa-save"></i>  {{ Lang::get('app.save') }}
								</button>
								@if (!empty($item->id))
								<a href="{{ url('users/' . $item->id . '/changepass') }}" class="btn btn-warning">
									<i class="fa fa-key"></i>  {{ Lang::get('app.change_password') }}
								</a>
								<a href="{{ url('users/' . $item->id . '/resetpass') }}" class="btn btn-secondary">
									<i class="fa fa-lock"></i>  {{ Lang::get('app.reset_password') }}
								</a>
								@endif
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
