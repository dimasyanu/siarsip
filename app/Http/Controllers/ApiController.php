<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lang;

use App\Shelf;

class ApiController extends Controller {
    public function __construct(){
        $this->middleware('auth');
    }

    public function getShelvesInRoom($id) {
    	$shelves = Shelf::where('room_id', $id)->get();

    	echo json_encode($shelves);
    }
}
