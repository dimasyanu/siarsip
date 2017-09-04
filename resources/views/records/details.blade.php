@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
<div class="app-contents">
    <div class="card">
        <div class="card-header">
        	<div class="row">
    			<div class="col-md-6" style="font-size: 14pt;">
    				{{ Lang::get('app.details', ['item' => Lang::get('app.record')]) }}
    			</div>
        	</div>
        </div>

        <div class="card-body auto-y">
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
                            <th class="text-middle">
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
                                        <div class="tree">
                                            <ul>
                                            @foreach($item->category->tree as $i => $cat)
                                                <li style="list-style: none; padding-left: {{ ($i+1)*18 }}px">{{ $cat->code.' - '.$cat->name }}</li>
                                            @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Period -->
                        <tr>
                            <th class="text-middle">
                                {{ Lang::get('app.period') }}
                            </th>
                            <td>{{ $item->period }}</td>
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
                            <td>{{ $item->section->name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <input type="hidden" id="id" name="id" value="{{ $item->id }}">
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="btn-group" role="group">
                        <a href="{{ url('records') }}" class="btn btn-default">
                            <i class="fa fa-times"></i>  {{ Lang::get('app.close') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
