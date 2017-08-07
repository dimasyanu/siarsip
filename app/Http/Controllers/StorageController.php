<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Box;
use App\Room;
use App\Section;
use App\Wardrobe;

class StorageController extends Controller {
    public function __construct(){
        $this->middleware('auth');
    }

    public function index() {
    	$rooms 		= Room::orderBy('name')->get();

    	foreach ($rooms as $i => $room) {
    		$wardrobes 	= Wardrobe::where('room_id', $room->id)->orderBy('name')->get();

    		if($wardrobes->count() > 0){
    			foreach ($wardrobes as $j => $wardrobe) {
    				$boxes 	= Box::where('wardrobe_id', $wardrobe->id)->orderBy('name')->get();

    				if($boxes->count() > 0){
    					foreach ($boxes as $k => $box) {
    						$sections = Section::where('box_id', $box->id)->orderBy('name')->get();
    						if($boxes->count() > 0)
    							$box->sections = $sections;
    					}

    					$wardrobe->boxes = $boxes;
    				}
    			}
    			$room->wardrobes = $wardrobes;
    		}
    	}

    	return view('storages/index', ['rooms' => $rooms]);
    }
}
