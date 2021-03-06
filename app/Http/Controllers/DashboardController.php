<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lang;

use App\Box;
use App\Record;
use App\Room;
use App\Shelf;

class DashboardController extends Controller {
	
	public function __construct(){
        $this->middleware('auth');
    }

    public function __invoke() {
    	$data = new \stdClass();
    	$data->room_count = Room::count();
    	$data->shelf_count = Shelf::count();
    	$data->box_count = Box::count();
        $data->record_count = Record::count();

        $records = Record::select('records.id', 'records.name', 'records.updated_at', 'users.name AS editor')
                ->leftJoin('users', 'records.editor_id', 'users.id')
                ->orderBy('updated_at', 'DESC')->limit(10);

        $data->latest_records = $records->get();

    	return view('dashboard/index', ['data' => $data]);
    }
}
