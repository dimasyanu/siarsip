<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">   

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Styles -->
	<link rel="shortcut icon" href="{{ asset('images/logo/logo2_.png') }}" >
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/bs-card.css') }}" rel="stylesheet">
	<link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
	<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">

	<script src="{{ asset('js/jquery.min.js') }}"></script>
	<script src="{{ asset('js/animate.js') }}"></script>
</head>
<body class="{{ (Auth::guest() ? 'auth' : '') }}">
	<div id="app">
		@if (!Auth::guest())
		<div class="app-container">
			<nav class="navbar navbar-dark bg-darker row">
				<div class="col-md-4" style="padding-left: 5px;">
					<button id="sidebar-toggle" class="btn btn-darker btn-sm">
				        <i class="fa fa-bars"></i>
					</button>
					<div class="brand">
						<a href="{{ url('/') }}">
							<img src="{{ asset('images/logo/logo-white.png') }}">
						</a>
					</div>
				</div>
				<ul class="nav navbar-nav navbar-right">
        			<li class="dropdown">
        				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
          				<ul class="dropdown-menu">
          					<li>
          						<a href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            		{{ Lang::get('auth.logout') }} <i class="fa fa-sign-out"></i>
	                            </a>
	                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	                                {{ csrf_field() }}
	                            </form>
          					</li>
          				</ul>
					</li>
				</ul>
			</nav>
			<div class="nav-side-menu shown" id="nav-side-menu">
				<i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
			  
				<div class="menu-list">
					<ul id="menu-content" class="menu-content collapse out">
						<li id="menu-item-dashboard">
							<a href="{{ url('/') }}">
								<div>
									<i class="fa fa-dashboard fa-lg"></i> {{ Lang::get('app.dashboard') }} 
								</div>
						  </a>
						</li>

						<li id="menu-item-records">
							<a href="{{ url('records') }}">
								<div>
									<i class="fa fa-file-text-o fa-lg"></i> 
									<span class="text-label">{{ Lang::get('app.documents') }}</span>
								</div>
							</a>
						</li>

						<li data-toggle="collapse" data-target="#storage" class="collapsed">
							<a href="#"><i class="fa fa-book fa-lg"></i> {{ Lang::get('app.references') }} <span class="arrow"></span></a>
						</li>  
						<ul class="sub-menu collapse" id="storage">
							<li id="menu-item-rooms">
								<a href="{{ url('rooms') }}"><div>{{ Lang::get('app.rooms') }}</div></a>
							</li>
							<li id="menu-item-shelves"><a href="{{ url('shelves') }}"><div>{{ Lang::get('app.shelf') }}</div></a></li>
							<li id="menu-item-boxes"><a href="{{ url('boxes') }}"><div>{{ Lang::get('app.boxes') }}</div></a></li>
							<li id="menu-item-sections"><a href="{{ url('sections') }}"><div>{{ Lang::get('app.sections') }}</div></a></li>
							<li id="menu-item-categories"><a href="{{ url('categories') }}"><div>{{ Lang::get('app.categories') }}</div></a></li>
						</ul>
						
						@if(Auth::user()->id == 1)
						<li id="menu-item-users">
							<a href="{{ url('users') }}">
								<div><i class="fa fa-users fa-lg"></i> {{ Lang::get('app.users') }}</div>
							</a>
						</li>
						@endif
					</ul>
				 </div>
			</div>
			@yield('content')
		</div>
		@else
			@yield('content')
		@endif
	</div>

	<!-- Scripts -->
	<script src="{{ asset('js/popper.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/select2/select2.min.js') }}"></script>
	<script src="{{ asset('js/bs-datepicker/bootstrap-datepicker.min.js') }}"></script>
	<script type="text/javascript">
		var root = "{{ url('/') }}";

		function hideSidebar(self) {
			$(self).removeClass('shown').addClass('collapsed');
			$('.app-contents').addClass('full');
		}

		function showSidebar(self) {
			$(self).show().removeClass('hidden').addClass('shown');
			$('.app-contents').removeClass('full');
		}

		$(document).ready(function() {
			var view = '{{ Route::getFacadeRoot()->current()->uri() }}';
			if(view == '/')
				$('#menu-item-dashboard').addClass('active')
			else
				$('#menu-item-' + view.split('/')[0]).addClass('active')
				.closest('ul.sub-menu').collapse('show')
				.prev('[data-toggle="collapse"]').addClass('active');

			$('#sidebar-toggle').click(function(event) {
				if($('#nav-side-menu').hasClass('shown')){
					$(self).one(
						'webkitTransitionEnd transitionend',
						function() { $(self).hide(); }
					);
					hideSidebar($('#nav-side-menu'));
				}
				else
					showSidebar($('#nav-side-menu'));
			});
		});
	</script>
</body>
</html>
