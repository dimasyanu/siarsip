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


	/*------------------------------- Simple CRUD Section --------------------------------*/

	// Rooms
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

	// Shelves
	public function addShelf(Request $request) {
		$shelf = new Shelf();
		$shelf->room_id 	= $request->input('room_id');
		$shelf->name 	= $request->input('name');
		
		$status     = $shelf->save();
		$messages   = $status? Lang::get('app.save_success') : Lang::get('app.save_failed');

		return redirect('storages')->with('status', $status)->with('messages', $messages);
	}

	public function editShelf(Request $request, $id) {
		$shelf = Shelf::find($id);
		$shelf->name = $request->input('name');
		
		$status     = $shelf->save();
		$messages   = $status? Lang::get('app.save_success') : Lang::get('app.save_failed');

		return redirect('storages')->with('status', $status)->with('messages', $messages);
	}

	public function deleteShelf($id) {
		$status = Shelf::find($id)->delete();
		$messages = $status? Lang::get('app.delete_success') : Lang::get('app.delete_failed');
		
		return redirect('storages')->with('status', $status)->with('messages', $messages);
	}

	// Shelves
	public function addBox(Request $request) {
		$box = new Box();
		$box->shelf_id 	= $request->input('shelf_id');
		$box->name 	= $request->input('name');
		
		$status     = $box->save();
		$messages   = $status? Lang::get('app.save_success') : Lang::get('app.save_failed');

		return redirect('storages')->with('status', $status)->with('messages', $messages);
	}

	/* ------------------------- Get Form Section --------------------------*/

	public function getRoomForm(Request $request) {
		$action = $request->input('action');
		$options = $this->getOptions('room', $action);
		return view('storages/forms/room_form', ['item' => new Room(), 'options' => $options]);
	}

	public function getRoomFormById(Request $request, $id) {
		$item = Room::find($id);
		$action = $request->input('action');
		$options = $this->getOptions('room', $action);
		return view('storages/forms/room_form', ['item' => $item, 'options' => $options]);
	}

	public function getShelfForm(Request $request) {
		$action = $request->input('action');
		$options = $this->getOptions('shelf', $action);
		$rooms = Room::all();
		$params = [
			'item' => new Shelf(), 
			'options' => $options,
			'rooms' => $rooms,
			'room_id' => $request->input('room_id')
		];
		
		return view('storages/forms/shelf_form', $params);
	}

	public function getShelfFormById(Request $request, $id) {
		$item = Shelf::find($id);
		$action = $request->input('action');
		$options = $this->getOptions('shelf', $action);
		$rooms = Room::all();
		$params = [
			'item' => $item, 
			'options' => $options,
			'rooms' => $rooms,
			'room_id' => $item->room->id
		];

		return view('storages/forms/shelf_form', $params);
	}

	// Box
	public function getBoxForm(Request $request) {
		$action  = $request->input('action');
		$options = $this->getOptions('box', $action);
		$rooms   = Room::all();
		$shelf   = Shelf::find($request->input('shelf_id'));
		$shelves = Shelf::where('room_id', $shelf->room->id)->get();
		$params = [
			'item' => new Box(),
			'options' => $options,
			'rooms' => $rooms,
			'shelves' => $shelves,
			'shelf_id' => $request->input('shelf_id'),
			'room_id' => $shelf->room->id
		];

		return view('storages/forms/box_form', $params);
	}

	public function getBoxFormById(Request $request, $id) {
		$item = Box::find($id);
		$action = $request->input('action');
		$options = $this->getOptions('box', $action);
		$rooms = Room::all();
		$shelves = Shelf::where('room_id', $item->shelf->room->id);
		$params = [
			'item' => $item, 
			'options' => $options,
			'rooms' => $rooms,
			'shelves' => $shelves,
			'room_id' => $item->room->id
		];

		return view('storages/forms/box_form', $params);
	}

	public function getSectionForm() {
		return view('storages/forms/section_form', $params);
	}

	public function getSectionFormById($id) {
		$item = Room::find($id);
		return view('storages/forms/section_form', ['item' => $item]);
	}

	private function getOptions($storage, $action) {
		$options = new \stdClass();
		$options->storage = $storage;
		$options->action = $action;

		return $options;
	}
}
