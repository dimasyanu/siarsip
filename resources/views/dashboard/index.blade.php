@extends('layouts.app')

@section('content')
<div class="app-contents">
    <div class="col-md-12">
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
        <div class="col-md-4">
            <div class="card card-teal row">
                <div class="card-title col-md-12">
                	<i class="fa fa-cubes pull-right"></i>
                    <h2>{{ Lang::get('app.storages') }}</h2>
                </div>
                
                <div class="card-content col-md-12">
                	<ul>
	                    <li><a href="{{ url('rooms') }}" class="link-teal">
	                    	<strong>{{ Lang::get('app.rooms') }}</strong><span class="badge badge-teal pull-right">{{ $data->room_count }}</span>
	                    </a></li>
	                    <li><a href="{{ url('shelves') }}" class="link-teal">
	                    	<strong>{{ Lang::get('app.shelves') }}</strong><span class="badge badge-teal pull-right">{{ $data->shelf_count }}</span>
	                    </a></li>
	                    <li><a href="{{ url('boxes') }}" class="link-teal">
	                    	<strong>{{ Lang::get('app.boxes') }}</strong><span class="badge badge-teal pull-right">{{ $data->box_count }}</span>
	                    </a></li>
	                    <li><a href="#" class="link-teal">
	                    	<strong>{{ Lang::get('app.documents') }}</strong>
	                    	<div class="pull-right">
	                    		<span class="badge badge-teal">{{ $data->record_count }}</span>
	                    		<span class="badge badge-danger">0</span>
	                    	</div>
	                    </a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card card-blue row">
                <div class="card-title title-sm col-md-12">
                    <h4 class="pull-right">{{ Lang::get('app.last_modified_item', ['item' => Lang::get('app.records')]) }}</h4>
                	<i class="fa fa-pencil"></i>
                </div>
                
                <div class="card-content col-md-12" style="padding: 0">
                	<table class="table table-striped">
                		<tbody>
                			@foreach($data->latest_records as $record)
                			<tr>
                				<td class="col-md-6" style="text-align: justify;">{{ $record->name }}</td>
                				<td class="col-md-4"></td>
                				<td class="col-md-2 text-middle">{{ $record->updated_at }}</td>
                			</tr>
                			@endforeach
                		</tbody>
                	</table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('.carousel').carousel({
			interval: 2000
		})
	});
</script>
@endsection
