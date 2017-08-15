<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lang;

use App\Room;
use App\Shelf;
use App\Box;

class DashboardController extends Controller {
	
	public function __construct(){
        $this->middleware('auth');
    }

    public function __invoke() {
    	$data = new \stdClass();
    	$data->room_count = Room::count();
    	$data->shelf_count = Shelf::count();
    	$data->box_count = Box::count();
    	return view('dashboard/index', ['data' => $data]);
    }
}
