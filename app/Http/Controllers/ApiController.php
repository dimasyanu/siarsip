<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lang;

use App\ItemCategory;
use App\Shelf;

class ApiController extends Controller {
    public function __construct(){
        $this->middleware('auth');
    }

    public function getCategory(Request $request) {
    	$item = ItemCategory::find($request->input('id'));
    	echo json_encode($item->code);
    }

    public function getCategories(Request $request) {
    	$categories = ItemCategory::where('code', 'REGEXP', $request->q)
    		->orWhere('name', 'REGEXP', $request->q)->get();
    	echo json_encode($categories);
    }

    public function getNestedCategories(Request $request) {
    	$id = $request->input('id');
    	$categories = ItemCategory::getNest($id);
    	echo json_encode($categories);
    }

    public function getShelvesInRoom($id) {
    	$shelves = Shelf::where('room_id', $id)->get();
    	echo json_encode($shelves);
    }
}
