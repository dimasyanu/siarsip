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
		
		$storages = array();
		foreach ($rooms as $room) {
			$room_obj = new \stdClass();
			$room_obj->id = $room->id;
			$room_obj->name = $room->name;
			$room_obj->shelves = array();
			foreach ($room->shelves()->get() as $shelf) {
				$shelf_obj = new \stdClass();
				$shelf_obj->id = $shelf->id;
				$shelf_obj->name = $shelf->name;
				$shelf_obj->boxes = array();
				foreach ($shelf->boxes()->get() as $box) {
					$box_obj = new \stdClass();
					$box_obj->id = $box->id;
					$box_obj->name = $box->name;
					$box_obj->sections = array();
					foreach ($box->sections()->get() as $section) {
						$section_obj = new \stdClass();
						$section_obj->id = $section->id;
						$section_obj->name = $section->name;

						$box_obj->sections[] = $section_obj;
					}
					$shelf_obj->boxes[] = $box_obj;
				}
				$room_obj->shelves[] = $shelf_obj;
			}
			$storages[] = $room_obj;
		}
		return view('storages/index', ['storages' => $storages]);
	}
}
