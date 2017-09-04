@extends('layouts.app')

@section('content')
<div class="app-contents">
    <div class="card">
        <div class="card-header">
            <i class="fa fa-user fa-2x"></i>
            <h3>{{ Lang::get('app.data') . ' ' . Lang::get('app.users') }}</h3>
            <div class="btn-group pull-right" role="group">
                <a class="btn btn-success" href="{{ url('users/create') }}">
                    <i class="fa fa-plus"></i>
                    {{ Lang::get('app.add') . ' ' . Lang::get('app.users') }}
                </a>
            </div>
        </div>

        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @if($items->count() > 0)
                        @foreach($items as $i => $item)
                            <tr>
                                <td>{{ ($items->perPage()*($items->currentPage()-1)) + $i + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="3">{{ Lang::get('app.no_items') }}</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
