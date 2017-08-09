<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Box;
use App\Room;
use App\Section;
use App\Shelf;

class StorageController extends Controller {
    public function __construct(){
        $this->middleware('auth');
    }

    public function index() {
    	$rooms 		= Room::orderBy('name')->get();

    	foreach ($rooms as $i => $room) {
    		$shelves 	= Shelf::where('room_id', $room->id)->orderBy('name')->get();

    		if($shelves->count() > 0){
    			foreach ($shelves as $j => $shelf) {
    				$boxes 	= Box::where('shelf_id', $shelf->id)->orderBy('name')->get();

    				if($boxes->count() > 0){
    					foreach ($boxes as $k => $box) {
    						$sections = Section::where('box_id', $box->id)->orderBy('name')->get();
    						if($sections->count() > 0)
    							$box->sections = $sections;
    					}

    					$shelf->boxes = $boxes;
    				}
    			}
    			$room->shelves = $shelves;
    		}
    	}
        // dd($rooms);

    	return view('storages/index', ['rooms' => $rooms]);
    }
}
