@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
<div class="app-contents">
    <div class="panel auto-y">
        <div class="panel-heading">
        	<div class="row">
    			<div class="col-md-6" style="font-size: 14pt;">
    				{{ Lang::get('app.details', ['item' => Lang::get('app.record')]) }}
    			</div>
        	</div>
        </div>

        <div class="panel-body auto-y">
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

            <!-- Category -->
            <div class="container" style="margin-top: 16px;">
                <table class="table table-striped">
                    <tbody>
                        <!-- Name -->
                        <tr>
                            <th class="text-middle" style="width">
                                {{ Lang::get('app.content') }}
                            </th>
                            <td>{{ $item->name }}</td>
                        </tr>

                        <!-- Record Category -->
                        <tr>
                            <th class="text-middle">
                                {{ Lang::get('app.category') }}
                            </th>
                            <td>
                                <div class="panel panel default">
                                    <div class="panel-body">
                                        @if($item->category_id == 0)
                                        {{ Lang::get('app.not_categorized') }}
                                        @else
                                        <div class="tree">
                                            <ul>
                                            @foreach($item->category->tree as $i => $cat)
                                                <li style="list-style: none; padding-left: {{ ($i+1)*18 }}px">{{ $cat->code.' - '.$cat->name }}</li>
                                            @endforeach
                                            </ul>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Date -->
                        <tr>
                            <th class="text-middle">
                                {{ Lang::get('app.date') }}
                            </th>
                            <td>{{ $item->date?$item->date:'-' }}</td>
                        </tr>

                        <!-- Quantiy -->
                        <tr>
                            <th class="text-middle">
                                {{ Lang::get('app.quantity') }}
                            </th>
                            <td>{{ $item->quantity }}</td>
                        </tr>

                        <!-- Progress -->
                        <tr>
                            <th class="text-middle">
                                {{ Lang::get('app.progress') }}
                            </th>
                            <td>{{ $item->progress }}</td>
                        </tr>

                        <!-- Input Descriptions -->
                        <tr>
                            <th class="text-middle">
                                {{ Lang::get('app.descriptions') }}
                            </th>
                            <td>{{ $item->descriptions }}</td>
                        </tr>

                        <!-- Section -->
                        <tr>
                            <th class="text-middle">
                                {{ Lang::get('app.save_to') }}
                            </th>
                            <td><div>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="width: 20%">{{ Lang::get('app.room') }}</th>
                                            <td style="width: 80%">{{ $item->section->box->shelf->room->name }}</td>
                                        </tr>
                                        <tr>
                                            <th style="width: 20%">{{ Lang::get('app.shelf') }}</th>
                                            <td style="width: 80%">{{ $item->section->box->shelf->name }}</td>
                                        </tr>
                                        <tr>
                                            <th style="width: 20%">{{ Lang::get('app.box') }}</th>
                                            <td style="width: 80%">{{ $item->section->box->name }}</td>
                                        </tr>
                                        <tr>
                                            <th style="width: 20%">{{ Lang::get('app.section') }}</th>
                                            <td style="width: 80%">{{ $item->section->name }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <input type="hidden" id="id" name="id" value="{{ $item->id }}">
            <div class="col-sm-2">
                <div class="btn-group" role="group">
                    <a href="{{ url('records') }}" class="btn btn-default">
                        <i class="fa fa-times"></i>  {{ Lang::get('app.close') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
