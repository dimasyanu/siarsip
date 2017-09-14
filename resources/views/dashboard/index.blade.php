@extends('layouts.app')

@section('content')
<div class="app-contents">
	<div class="panel auto-y">	
		<div class="panel-heading">
			<i class="fa fa-dashboard fa-2x"></i>
			<h4>{{ Lang::get('app.dashboard') }}</h4>
		</div>
		<div class="panel-body" style="padding: 15px; overflow-y: auto;">
		    <div class="row">
		    	@if(false)
		    	<div class="col-md-8">
		    		<div id="pictures-slider" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						<ol class="carousel-indicators">
							<li data-target="#pictures-slider" data-slide-to="0" class="active"></li>
							<li data-target="#pictures-slider" data-slide-to="1"></li>
							<li data-target="#pictures-slider" data-slide-to="2"></li>
						</ol>

						<!-- Wrapper for slides -->
						<div class="carousel-inner" role="listbox">
							<div class="carousel-item active">
								<img src="{{ asset('images/picture-1.jpg')}}" alt="picture-1" style="height: 100%; margin-top: -90px;">
								<div class="carousel-caption"></div>
							</div>
							<div class="carousel-item">
								<img src="{{ asset('images/picture-2.jpg')}}" alt="picture-2" style="margin-top: -180px;">
								<div class="carousel-caption"></div>
							</div>
							<div class="carousel-item">
								<img src="{{ asset('images/picture-3.jpg')}}" alt="picture-3" style="margin-top: -60px;">
								<div class="carousel-caption"></div>
							</div>
						</div>
					</div>
		    	</div>
		    	@endif
		        <div class="col-md-12">
		        	<h4 class="alt-heading">{{ Lang::get('app.storages') }}</h4>
					<div class="row value-cards">
						<div class="col-md-3 col-sm-6">
							<a href="{{ url('rooms') }}" style="text-decoration: none;">
					            <div class="card db-card bg-blue" style="height: 100px; overflow: hidden">
					                <div class="card-body">
					                	<div class="container">
						                	<h2 id="room-count" data-val="{{ $data->room_count }}" style="font-weight: 300; text-align: right;">0</h2>
						                	<h4>{{ Lang::get('app.rooms') }}</h4>
						                </div>
					                	<i class="fa fa-home"></i>
					                </div>
					            </div>
				            </a>
				        </div>

				        <div class="col-md-3 col-sm-6">
					        <a href="{{ url('shelves') }}" style="text-decoration: none;">
					            <div class="card db-card bg-red" style="height: 100px; overflow: hidden">
					                <div class="card-body">
					                	<div class="container">
						                	<h2 id="shelf-count" data-val="{{ $data->shelf_count }}" style="font-weight: 300; text-align: right;">0</h2>
						                	<h4>{{ Lang::get('app.shelves') }}</h4>
						                </div>
					                	<i class="fa fa-columns"></i>
					                </div>
					            </div>
				            </a>
				        </div>

				        <div class="col-md-3 col-sm-6">
					        <a href="{{ url('boxes') }}" style="text-decoration: none;">
					            <div class="card db-card bg-green" style="height: 100px; overflow: hidden">
					                <div class="card-body">
					                	<div class="container">
						                	<h2 id="box-count" data-val="{{ $data->box_count }}" style="font-weight: 300; text-align: right;">0</h2>
						                	<h4>{{ Lang::get('app.boxes') }}</h4>
						                </div>
					                	<i class="fa fa-dropbox"></i>
					                </div>
					            </div>
				            </a>
				        </div>

				        <div class="col-md-3 col-sm-6">
					        <a href="{{ url('records') }}" style="text-decoration: none;">
					            <div class="card db-card bg-dark" style="height: 100px; overflow: hidden">
					                <div class="card-body">
					                	<div class="container">
						                	<h2 id="record-count" data-val="{{ $data->record_count }}" style="font-weight: 300; text-align: right;">0</h2>
						                	<h4>{{ Lang::get('app.records') }}</h4>
						                </div>
					                	<i class="fa fa-files-o"></i>
					                </div>
					            </div>
				            </a>
				        </div>
			        </div>
		        </div>
		        <div class="col-md-12" style="margin-top: 15px;">
		        	<h4 class="alt-heading">{{ Lang::get('app.last_modified_item', ['item' => Lang::get('app.records')]) }}</h4>
		            <div class="card" style="border: 0;">
		                <div class="card-body col-md-12" style="padding: 0">
		                	<table class="table middle-align">
		                		<thead class="grey">
		                			<th>{{ Lang::get('app.name') }}</th>
		                			<th class="text-center">{{ Lang::get('app.timestamp') }}</th>
		                		</thead>
		                		<tbody>
		                			@foreach($data->latest_records as $record)
		                			<tr>
		                				<td style="width: 80%; text-align: justify;">{{ $record->name }}</td>
		                				<td class="text-center" style="width: 20%;">{{ date('d M Y', strtotime($record->updated_at)) . ', ' . date('H:i', strtotime($record->updated_at)) }}</td>
		                			</tr>
		                			@endforeach
		                		</tbody>
		                	</table>
		                </div>
		            </div>
		        </div>
		    </div>
	    </div>
	</div>
</div>
<script type="text/javascript">
	function animateCount(el) {
		var value = parseInt($(el).data('val'));
		$({someValue: 0}).delay(800).animate({someValue: value}, {
		    duration: 2000,
		    step: function() { 
		        $(el).text(Math.ceil(this.someValue));
		    }
		});
	}
	$(document).ready(function() {
		$('.carousel').carousel({
			interval: 2000
		});
		
		animateCount($('#room-count'));
		animateCount($('#shelf-count'));
		animateCount($('#box-count'));
		animateCount($('#record-count'));
	});
</script>
@endsection
