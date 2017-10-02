<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lang;

use App\Box;
use App\RecordCategory;
use App\Room;
use App\Section;
use App\Shelf;

class ApiController extends Controller {
	public function __construct(){
		$this->middleware('auth');
	}

	public function getBoxesInShelf($shelf_id) {
		$boxes = Box::where('shelf_id', $shelf_id)->get();
		echo json_encode($boxes);
	}

	public function getCategory(Request $request) {
		$item = RecordCategory::find($request->input('id'));
		echo json_encode($item->code);
	}

	public function getCategories(Request $request) {
		$categories = RecordCategory::where('code', 'REGEXP', $request->q)
			->orWhere('name', 'REGEXP', $request->q)->get();
		echo json_encode($categories);
	}

	public function getNestedCategories(Request $request) {
		$id = $request->input('id');
		$categories = RecordCategory::getNest($id);
		echo json_encode($categories);
	}

	public function getSectionsInBox($box_id) {
		$sections = Section::where('box_id', $box_id)->get();
		echo json_encode($sections);
	}

	public function getShelvesInRoom($room_id) {
		$shelves = Shelf::where('room_id', $room_id)->get();
		echo json_encode($shelves);
	}

	public function addRoom(Request $request) {
		$room = new Room();
		$room->name = $request->input('name');
		
		$status     = $room->save();
		$messages   = $status? Lang::get('app.save_success') : Lang::get('app.save_failed');

		return redirect('storages')->with('status', $status)->with('messages', $messages);
	}

	public function editRoom(Request $request, $id) {
		$room = Room::find($id);
		$room->name = $request->input('name');
		
		$status     = $room->save();
		$messages   = $status? Lang::get('app.save_success') : Lang::get('app.save_failed');

		return redirect('storages')->with('status', $status)->with('messages', $messages);
	}

	public function deleteRoom($id) {
		$status = Room::find($id)->delete();
		$messages = $status? Lang::get('app.delete_success') : Lang::get('app.delete_failed');
		
		return redirect('storages')->with('status', $status)->with('messages', $messages);
	}
}
