@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
<div class="panel panel-default">
    <div class="panel-heading">
    	<div class="row">
			<div class="col-md-6" style="font-size: 14pt;">
				{{ Lang::get('app.details', ['item' => Lang::get('app.record')]) }}
			</div>
    	</div>
    </div>

    <div class="panel-body">
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
        <div class="col-md-12">
            <table class="table table-striped">
                <tbody>
                    <!-- Name -->
                    <tr>
                        <th class="text-middle col-sm-2 col-md-2">
                            {{ Lang::get('app.content') }}
                        </th>
                        <td class="col-sm-10 col-md-10">{{ $item->name }}</td>
                    </tr>

                    <!-- Record Category -->
                    <tr>
                        <th class="text-middle col-sm-2 col-md-2">
                            {{ Lang::get('app.category') }}
                        </th>
                        <td class="col-sm-10 col-md-10">
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
                </tbody>
            </table>
        </div>

        <!-- Period -->
        <div class="form-group">
            <label for="detail-period" class="col-sm-2">{{ Lang::get('app.period') }}</label>
            <div class="col-sm-2 col-md-2">
                <p id="detail-period">{{ $item->period }}</p>
            </div>
        </div>

        <!-- Quantiy -->
        <div class="form-group">
            <label for="detail-quantity" class="col-sm-1">{{ Lang::get('app.quantity') }}</label>
            <div class="col-sm-2 col-md-2">
                <p id="detail-quantity">{{ $item->quantity }}</p>
            </div>
        </div>

        <!-- Progress -->
        <div class="form-group">
            <label for="input-progress" class="col-sm-3">{{ Lang::get('app.progress') }}</label>
            <div class="col-sm-2 col-md-2">
                <p id="detail-progress">{{ $item->progress }}</p>
            </div>
        </div>

        <!-- Input Descriptions -->
        <div class="form-group">
            <label for="detail-descriptions" class="col-sm-2">{{ Lang::get('app.descriptions') }}</label>
            <div class="col-sm-5 col-md-5">
                <p id="detail-descriptions">{{ $item->descriptions }}</p>
            </div>
        </div>

        <!-- Section -->
        <div class="form-group">
            <label for="detail-section-id" class="col-sm-3">{{ Lang::get('app.save_to') }}</label>
            <div class="col-sm-2 col-md-2">
                <p id="detail-section">{{ $item->section->name }}</p>
            </div>
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
@endsection
