@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/list-table.css') }}">
<div class="app-contents">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-home fa-2x"></i>
            <h3>{{ Lang::get('app.data') . ' ' . Lang::get('app.rooms') }}</h3>
            <div class="btn-group pull-right" role="group">
                <a class="btn btn-success" href="{{ url('rooms/create') }}">
                    <i class="fa fa-plus"></i>
                    {{ Lang::get('app.add') . ' ' . Lang::get('app.rooms') }}
                </a>
            </div>
        </div>
        <div class="panel-body">
            @if(session('messages'))
                <div class="alert @if(session('status') == 1) alert-success @else alert-danger @endif" role="alert">{{ session('messages') }}</div>
            @endif
            <div class="list-table">
                <ul>
                    <li class="list-table-heading">
                        <div style="width: 50px;">#</div>
                        <div>{{ Lang::get('app.name') }}</div>
                        <div style="width: 100px;">{{ Lang::get('app.actions') }}</div>
                    </li>
                    <li class="list-table-body sub-list"></li>
                </ul>
            </div>
            <table class="table table-striped data-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No.</th>
                        <th>Name</th>
                        <th class="text-center" style="width: 100px;">{{ Lang::get('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if($rooms->count() > 0)
                        @foreach($rooms as $i => $room)
                            <tr data-id="{{ $room->id }}" <?php echo ($room->wardrobes ? ('data-toggle="collapse" data-target="#room-'. $room->id .'" class="accordion-toggle"') : ''); ?>>
                                <td>
                                    {{ $i + 1 }}
                                </td>
                                <td class="data-name">{{ $room->name }}</td>
                                <td>
                                    <div class="action-buttons btn-group pull-right" role="group" style="display: none;">
                                        <a href="{{ url('rooms/'.$room->id.'/edit') }}" type="button" class="btn btn-warning btn-xs">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="delete-btn btn btn-danger btn-xs">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                            <form action="{{ url('rooms/' . $room->id) }}" method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                            </form>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @if($room->wardrobes)
                            <tbody id="room-{{ $room->id }}" class="accordian-body collapse">
                                @foreach($room->wardrobes as $i => $wardrobe)
                                    <tr data-id="{{ $wardrobe->id }}" <?php echo ($wardrobe->boxes ? ('data-toggle="collapse" data-target="" class="accordion-toggle"'):''); ?>>
                                        <td class="hiddenRow">
                                            <div>
                                                {{ $wardrobe->name }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            @endif
                        @endforeach
                    @else
                        <tr><td colspan="3" class="text-center">{{ Lang::get('app.no_rooms') }}</td></tr>
                    @endif
                </tbody>
            </table>
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
