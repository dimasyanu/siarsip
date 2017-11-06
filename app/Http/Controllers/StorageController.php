<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Box;
use App\Room;
use App\Section;
use App\Shelf;

use DB;

class StorageController extends Controller {
	public function __construct(){
		$this->middleware('auth');
	}

	public function index() {
		$rooms 		= $this->natOrder(Room::select('id', 'name'), 'name');
		
		$storages = array();
		foreach ($rooms as $room) {
			$room_obj = new \stdClass();
			$room_obj->id = $room->id;
			$room_obj->name = $room->name;
			$room_obj->shelves = array();
			foreach ($this->natOrder($room->shelves(), 'name') as $shelf) {
				$shelf_obj = new \stdClass();
				$shelf_obj->id = $shelf->id;
				$shelf_obj->name = $shelf->name;
				$shelf_obj->boxes = array();
				foreach ($this->natOrder($shelf->boxes(), 'name') as $box) {
					$box_obj = new \stdClass();
					$box_obj->id = $box->id;
					$box_obj->name = $box->name;
					$box_obj->sections = array();
					foreach ($this->natOrder($box->sections(), 'name') as $section) {
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

	private function natOrder($obj, $str) {
		return $obj->orderBy(DB::raw('LENGTH('.$str.')'))->orderBy($str)->get();
	}
}
