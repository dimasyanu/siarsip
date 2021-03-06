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
		   		<div class="col-md-12">
			    	<div id="image-slider" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						<ol class="carousel-indicators">
							<li data-target="#image-slider" data-slide-to="0" class="active"></li>
							<li data-target="#image-slider" data-slide-to="1"></li>
							<li data-target="#image-slider" data-slide-to="2"></li>
							<li data-target="#image-slider" data-slide-to="3"></li>
							<li data-target="#image-slider" data-slide-to="4"></li>
						</ol>

						<!-- Wrapper for slides -->
						<div class="carousel-inner" role="listbox">
							<div class="item active">
								<div class="image-container" data-src="{{ asset('images/pic2.jpg') }}"></div>
							</div>
							<div class="item">
								<div class="image-container" data-src="{{ asset('images/pic3.jpg') }}"></div>
							</div>
							<div class="item">
								<div class="image-container" data-src="{{ asset('images/pic4.jpg') }}"></div>
							</div>
							<div class="item">
								<div class="image-container" data-src="{{ asset('images/pic6.jpg') }}"></div>
							</div>
							<div class="item">
								<div class="image-container" data-src="{{ asset('images/pic5.jpg') }}"></div>
							</div>
						</div>
					</div>
				</div>
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
		                			<th class="text-center">{{ Lang::get('app.user') }}</th>
		                			<th class="text-center">{{ Lang::get('app.timestamp') }}</th>
		                		</thead>
		                		<tbody>
		                			@foreach($data->latest_records as $record)
		                			<tr>
		                				<td style="width: 70%; text-align: justify;">{{ $record->name }}</td>
		                				<td style="width: 10%; text-align: justify;">{{ $record->editor=='' ? Lang::get('app.unknown_user') : $record->editor }}</td>
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
		$('.carousel-inner .item .image-container').each(function(index, el) {
			$(this).css('background-image', 'url(\'' + $(this).data('src') + '\')');
		});

		$('.carousel').carousel({
			interval: 3000
		});
		
		animateCount($('#room-count'));
		animateCount($('#shelf-count'));
		animateCount($('#box-count'));
		animateCount($('#record-count'));
	});
</script>
@endsection
