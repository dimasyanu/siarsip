<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

	// Shelves
	public function addShelf(Request $request) {
		$shelf = new Shelf();
		$shelf->room_id 	= $request->input('room_id');
		$shelf->name 	= $request->input('name');
		
		$status     = $shelf->save();
		$messages   = $status? Lang::get('app.save_success') : Lang::get('app.save_failed');

		return redirect('storages')->with('status', $status)->with('messages', $messages);
	}

	// Box
	public function addBox(Request $request) {
		$box = new Box();
		$box->shelf_id 	= $request->input('shelf_id');
		$box->name 	= $request->input('name');
		
		$status     = $box->save();
		$messages   = $status? Lang::get('app.save_success') : Lang::get('app.save_failed');

		return redirect('storages')->with('status', $status)->with('messages', $messages);
	}

	// Section
	public function addSection(Request $request) {
		$section            = new Section();
		$section->box_id 	= $request->input('box_id');
		$section->name 	    = $request->input('name');
		
		$status     = $section->save();
		$messages   = $status? Lang::get('app.save_success') : Lang::get('app.save_failed');

		return redirect('storages')->with('status', $status)->with('messages', $messages);
	}

	public function editStorage(Request $request, $storage, $id) {
		$item = $this->getItem($storage, $id);
		$item->name = $request->input('name');
		
		$status     = $item->save();
		$messages   = $status? Lang::get('app.save_success') : Lang::get('app.save_failed');

		return redirect('storages')->with('status', $status)->with('messages', $messages);
	}

	public function deleteStorage($storage, $id) {
		$item = $this->getItem($storage, $id);
		$status = $item->delete();
		$messages = $status? Lang::get('app.delete_success') : Lang::get('app.delete_failed');
		
		return redirect('storages')->with('status', $status)->with('messages', $messages);
	}

	private function getItem($storage, $id) {
		$item = null;
		switch ($storage) {
			case 'room'    : $item = Room::find($id);
				break;
			case 'shelf'   : $item = Shelf::find($id);
				break;
			case 'box'     : $item = Box::find($id);
				break;
			case 'section' : $item = Section::find($id);
				break;
		}
		return $item;
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
		$room = Room::find($request->input('room_id'));

		$params = [
			'item'    => new Shelf(), 
			'options' => $options,
			'room'    => $room
		];
		
		return view('storages/forms/shelf_form', $params);
	}

	public function getShelfFormById(Request $request, $id) {
		$item = Shelf::find($id);
		$action = $request->input('action');
		$options = $this->getOptions('shelf', $action);

		$params = [
			'item' 		=> $item, 
			'options' 	=> $options,
			'room'		=> $item->room
		];

		return view('storages/forms/shelf_form', $params);
	}

	// Box
	public function getBoxForm(Request $request) {
		$action  = $request->input('action');
		$options = $this->getOptions('box', $action);
		$shelf   = Shelf::find($request->input('shelf_id'));
		$params  = [
			'item'      => new Box(),
			'options'   => $options,
			'shelf' 	=> $shelf,
			'room'  	=> $shelf->room
		];

		return view('storages/forms/box_form', $params);
	}

	public function getBoxFormById(Request $request, $id) {
		$item 		= Box::find($id);
		$action 	= $request->input('action');
		$options 	= $this->getOptions('box', $action);		
		$params 	= [
			'item'      => $item, 
			'options'   => $options,
			'shelf' 	=> $item->shelf,
			'room'  	=> $item->shelf->room
		];

		return view('storages/forms/box_form', $params);
	}

	public function getSectionForm(Request $request) {
		$action  	= $request->input('action');
		$options 	= $this->getOptions('section', $action);
		$box   		= Box::find($request->input('box_id'));
		$params 	= [
			'item'      => new Section(),
			'options'   => $options,
			'box' 		=> $box,
			'shelf' 	=> $box->shelf,
			'room'  	=> $box->shelf->room
		];

		return view('storages/forms/section_form', $params);
	}

	public function getSectionFormById(Request $request, $id) {
		$item 		= Section::find($id);
		$action  	= $request->input('action');
		$options 	= $this->getOptions('section', $action);
		$params 	= [
			'item'      => $item,
			'options'   => $options,
			'box' 		=> $item->box,
			'shelf' 	=> $item->box->shelf,
			'room'  	=> $item->box->shelf->room
		];
		return view('storages/forms/section_form', $params);
	}

	private function getOptions($storage, $action) {
		$options = new \stdClass();
		$options->storage = $storage;
		$options->action = $action;

		return $options;
	}
}
