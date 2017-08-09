@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/list-table.css') }}">
<div class="app-contents">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-cubes fa-2x"></i>
            <h3>{{ Lang::get('app.data') . ' ' . Lang::get('app.storages') }}</h3>
        </div>
        <div class="panel-body">
            @if(session('messages'))
                <div class="alert @if(session('status') == 1) alert-success @else alert-danger @endif" role="alert">{{ session('messages') }}</div>
            @endif
            <div class="list-table"><ul>
                <li class="list-table-heading">
                    <div class="text-center col-md-1"></div>
                    <div class="col-md-9">{{ Lang::get('app.name') }}</div>
                    <div class="text-center col-md-2"></div>
                </li>
                @if($rooms->count() > 0)
                @foreach($rooms as $i => $room)
                    @if($room->shelves)
                    <li class="col-md-12 collapsed" data-toggle="collapse" data-target="#room-{{ $room->id }}" aria-expanded="false">
                        <div class="col-md-9">
                    @else
                    <li class="col-md-12">
                        <div class="col-md-9" style="padding-left: 31px;">
                    @endif
                        <span></span>{{ $room->name }}</div>
                    </li>
                    @if($room->shelves)
                    <ul id="room-{{ $room->id }}" class="sub-list collapse col-md-12">
                        @foreach($room->shelves as $j => $shelf)
                        @if($shelf->boxes)
                        <li class="col-md-12 collapsed" data-toggle="collapse" data-target="#shelf-{{ $shelf->id }}" class="accordion-toggle">
                            <div class="col-md-9" style="padding-left: 32px;">
                        @else
                        <li class="col-md-12">
                            <div class="col-md-9" style="padding-left: 52px;">
                        @endif
                            <span></span> {{ $shelf->name }}</div>
                        </li>
                        @if($shelf->boxes)
                        <ul id="shelf-{{ $shelf->id }}" class="sub-list collapse col-md-12">
                            @foreach($shelf->boxes as $k => $box)
                            @if($box->sections)
                            <li class="col-md-12 collapsed" data-toggle="collapse" data-target="#box-{{ $box->id }}" class="accordion-toggle">
                                <div class="col-md-9" style="padding-left: 54px;">
                            @else
                            <li class="col-md-12">
                                <div class="col-md-9" style="padding-left: 70px;">
                            @endif
                                <span></span>{{ $box->name }}</div>
                            </li>
                            @if($box->sections)
                            <ul id="box-{{ $box->id }}" class="sub-list collapse col-md-12">
                                @foreach($box->sections as $l => $section)
                                <li class="col-md-12">
                                    <div class="col-md-9" style="padding-left: 90px;">{{ $section->name }}</div>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                            @endforeach
                        </ul>
                        @endif
                        @endforeach
                    </ul>
                    @endif
                @endforeach
                @endif
            </ul></div>
        </div>
    </div>
</div>
<script type="text/javascript">
</script>
@endsection
