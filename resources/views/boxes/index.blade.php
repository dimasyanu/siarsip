@extends('layouts.app')

@section('content')
<div class="app-contents">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-cubes fa-2x"></i>
            <h3>{{ Lang::get('app.data') . ' ' . Lang::get('app.boxes') }}</h3>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ url('boxes/create') }}">
                    <i class="fa fa-plus"></i>
                    {{ Lang::get('app.add') . ' ' . Lang::get('app.boxes') }}
                </a>
                <button type="button" class="filter-toggle btn btn-primary collapsed" data-toggle="collapse" data-target="#filter-panel">
                    <i class="fa fa-filter"></i> {{ Lang::get('app.filter') }}
                </button>
            </div>
        </div>
        <div id="filter-panel" class="row collapse{{ $filters->search ? ' in':'' }}" style="margin: 0;">
            <div class="col-md-12" style="padding: 30px 10px 20px 10px;">
                <div class="col-md-4">
                    <form action="" class="search-form">
                        <div class="form-group has-feedback{{ $filters->search ? ' open' : '' }}">
                            <label for="search" class="sr-only">{{ Lang::get('app.search') }}</label>
                            <input type="text" class="form-control" name="search" id="search" placeholder="{{ Lang::get('app.search') }}..." value="{{ $filters->search }}">
                            <i class="fa fa-search form-control-feedback"></i>
                        </div>
                    </form>
                </div>
                <div class="col-md-2 pull-right">
                    <form action="{{ url()->current() . '?' . ($filters->search ? 'search='.$filters->search.'&':'') . 'limit=' }}">
                        <select id="filter-limit" class="form-control" name="limit" onchange="this.form.submit()">
                            <option value="5" {{ $items->perPage()==5?'selected':'' }}>5</option>
                            <option value="10" {{ $items->perPage()==10?'selected':'' }}>10</option>
                            <option value="15" {{ $items->perPage()==15?'selected':'' }}>15</option>
                            <option value="25" {{ $items->perPage()==25?'selected':'' }}>25</option>
                            <option value="50" {{ $items->perPage()==50?'selected':'' }}>50</option>
                            <option value="100" {{ $items->perPage()==100?'selected':'' }}>100</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
        <div class="panel-body">
            @if(session('messages'))
                <div class="alert @if(session('status') == 1) alert-success @else alert-danger @endif" role="alert">{{ session('messages') }}</div>
            @endif
            <table class="table table-striped data-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No.</th>
                        <th>Name</th>
                        <th>Rak</th>
                        <th>Ruangan</th>
                        <th class="text-center" style="width: 100px;">{{ Lang::get('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if($items->count() > 0)
                        @foreach($items as $i => $item)
                            <tr data-id="{{ $item->id }}">
                                <td>
                                    {{ ($items->perPage()*($items->currentPage()-1)) + $i + 1 }}
                                </td>
                                <td class="data-name">{{ $item->name }}</td>
                                <td class="data-shelf">{{ $item->shelf_name }}</td>
                                <td class="data-room">{{ $item->room_name }}</td>
                                <td>
                                    <div class="action-buttons btn-group pull-right" role="group" style="display: none;">
                                        @if($item->hasRecords)
                                        <a href="{{ url('box/print/'.$item->id) }}" type="button" class="btn btn-info btn-xs" target="_blank">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </a>
                                        @endif
                                        <a href="{{ url('boxes/'.$item->id.'/edit') }}" type="button" class="btn btn-warning btn-xs">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="delete-btn btn btn-danger btn-xs">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                            <form action="{{ url('boxes/' . $item->id) }}" method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                            </form>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="4" class="text-center">{{ Lang::get('app.no_items') }}</td></tr>
                    @endif
                </tbody>
            </table>
            <div class="text-center">
                @php 
                    $link_requests = array();

                    if($filters->limit != 25)
                        $link_requests['limit'] = $filters->limit;
                        
                    if($filters->search)
                        $link_requests['search'] = $filters->search;
                @endphp

                {{ $items->appends($link_requests)->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="delete-modal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ Lang::get('app.delete_item') }}</h4>
            </div>
            <div class="modal-body">
                <p>{!! trans('app.delete_confirmation') !!}</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="confirm-delete" class="btn btn-danger">{{ Lang::get('app.delete') }}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('app.cancel') }}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript" src="{{ asset('js/crud.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var selectedItem;
        $('.delete-btn').click(function(event) {
            selectedItem = $(this).closest('tr');
            var name = selectedItem.find('.data-name').text();
            itemId = selectedItem.data('id');
            $('#delete-modal').modal('show')
            .find('.modal-body').find('strong').text(name);
        });

        $('#delete-modal').on('show.bs.modal', function(e) {
            $('#confirm-delete').click(function(event) {
                selectedItem.find('.delete-btn form').submit();
            });
        });
    });
</script>
@endsection
