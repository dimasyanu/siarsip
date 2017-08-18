<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lang;

use App\Box;
use App\RecordCategory;
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
}
