@extends('layouts.app')

@section('content')
<div class="app-contents">
    <div class="col-md-12">
        <div class="col-md-4">
            <div class="card row">
                <div class="card-title col-md-12">
                	<i class="fa fa-cubes pull-right"></i>
                    <h2>{{ Lang::get('app.storages') }}</h2>
                </div>
                
                <div class="card-content col-md-12">
                	<ul>
	                    <li><a href="{{ url('rooms') }}" class="link-teal">
	                    	{{ Lang::get('app.rooms') }}<span class="badge badge-teal pull-right">{{ $data->room_count }}</span>
	                    </a></li>
	                    <li><a href="{{ url('shelves') }}" class="link-teal">
	                    	{{ Lang::get('app.shelves') }}<span class="badge badge-teal pull-right">{{ $data->shelf_count }}</span>
	                    </a></li>
	                    <li><a href="{{ url('boxes') }}" class="link-teal">
	                    	{{ Lang::get('app.boxes') }}<span class="badge badge-teal pull-right">{{ $data->box_count }}</span>
	                    </a></li>
	                    <li><a href="#" class="link-teal">
	                    	{{ Lang::get('app.documents') }}
	                    	<div class="pull-right">
	                    		<span class="badge badge-teal">0</span>
	                    		<span class="badge badge-danger">0</span>
	                    	</div>
	                    </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
