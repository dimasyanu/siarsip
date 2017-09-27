@extends('layouts.app')

@section('content')
<div class="login-bg">
	<img src="{{ asset('images/pic1.jpg') }}" alt="{{ Lang::get('app.bg_image') }}" width="100%">
</div>
	<div class="container">
		<div class="text-center login-brand" style="margin-bottom: 25px;">
			<img src="{{ asset('images/logo/logo-white.png') }}">
		</div>
		<div class="login-panel animated fadeIn">
			<p>{{ Lang::get('auth.login') }} :</p>
			<form class="form-horizontal" method="POST" action="{{ route('login') }}">
				{{ csrf_field() }}
				<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
					<div class="col-md-12">
						<div class="input-group">
							<span class="input-group-addon span-teal">
								<i class="fa fa-user"></i>
							</span>
							<input id="username" type="text" class="form-control" name="username" value="{{ old('name') }}" placeholder="{{ Lang::get('auth.username') }}" required autofocus>
						</div>
						@if ($errors->has('email'))
							<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>
				</div>

				<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
					<div class="col-md-12">
						<div class="input-group">
							<span class="input-group-addon span-teal">
								<i class="fa fa-lock"></i>
							</span>
							<input id="password" type="password" class="form-control" name="password" placeholder="{{ Lang::get('auth.password') }}" required>
						</div>
						@if ($errors->has('password'))
							<span class="help-block">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
						@endif
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-6">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ Lang::get('auth.remember_me') }}
							</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-12">
						<button type="submit" class="btn btn-teal btn-lg col-md-12">
							{{ Lang::get('auth.login') }}
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
