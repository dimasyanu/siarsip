<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lang;

use App\RecordCategory;
use App\Record;
use App\Box;
use App\Room;
use App\Section;
use App\Shelf;

class RecordController extends Controller {
	public function __construct(){
		$this->middleware('auth');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		$filters = new \stdClass();
		$filters->search = $request->input('search');
		$filters->limit  = $request->input('limit');
		$filters->page   = $request->input('page');

		$filters->room_id      = $request->input('room');
		$filters->shelf_id     = $request->input('shelf');
		$filters->box_id       = $request->input('box');
		$filters->section_id   = $request->input('section');

		$references             = new \stdClass();
		$references->rooms      = Room::get();
		$references->shelves    = array();
		$references->boxes      = array();
		$references->sections   = array();

		if(!$filters->limit) $filters->limit = 25;

		// $query = Record::with('section');
		$query = Record::select(
            'records.*', 
            'a.name AS section_name', 
            'b.name AS box_name', 
            'c.name AS shelf_name', 
            'd.name AS room_name'
        )->leftJoin('sections AS a', 'records.section_id', 'a.id')
        ->leftJoin('boxes AS b', 'a.box_id', 'b.id')
        ->leftJoin('shelves AS c', 'b.shelf_id', 'c.id')
        ->leftJoin('rooms AS d', 'c.room_id', 'd.id');

		if($filters->room_id || $filters->shelf_id || $filters->box_id || $filters->section_id){
			if($filters->section_id) {
				$query = $query->where('a.id', $filters->section_id);
				$section = Section::find($filters->section_id);
				$filters->room_id     	= $section->box->shelf->room->id;
				$filters->shelf_id    	= $section->box->shelf->id;
				$filters->box_id      	= $section->box->id;
				$references->sections 	= Section::where('box_id', $section->box->id)->get();
				$references->boxes    	= Box::where('shelf_id', $section->box->shelf->id)->get();
				$references->shelves  	= Shelf::where('room_id', $section->box->shelf->room->id)->get();
			}
			elseif($filters->box_id) {
				$query = $query->where('b.id', $filters->box_id);
				$box = Box::find($filters->box_id);
				$filters->room_id       = $box->shelf->room->id;
				$filters->shelf_id      = $box->shelf->id;
				$references->sections 	= Section::where('box_id', $box->id)->get();
				$references->boxes      = Box::where('shelf_id', $box->shelf->id)->get();
				$references->shelves    = Shelf::where('room_id', $box->shelf->room->id)->get();
			}
			elseif($filters->shelf_id) {
				$query = $query->where('c.id', $filters->shelf_id);
				$shelf = Shelf::find($filters->shelf_id);
				$filters->room_id = $shelf->room->id;
				$references->boxes = Box::where('shelf_id', $shelf->id)->get();
				$references->shelves = Shelf::where('room_id', $shelf->room->id)->get();
			}
			elseif($filters->room_id) {
				$query = $query->where('d.id', $filters->room_id);
				$references->shelves = Shelf::where('room_id', $filters->room_id)->get();
			}
		}

		if($filters->search)
			$query = $query->where ('records.name', 'regexp', $filters->search);

		$items = $query->orderBy('records.name')->paginate($filters->limit);
		
		return view('records/index', ['items' => $items, 'filters' => $filters, 'references' => $references]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request) {
		$item                 	= new Record();
		$item->category       	= RecordCategory::find($item->id);
		$item->date_type		= 0;

		$references             = new \stdClass();
		$references->rooms      = Room::get();
		$references->shelves 	= array();
		$references->boxes   	= array();
		$references->sections	= array();

		$references->criteria	= DB::table('record_criteria')->get();
		$references->media		= DB::table('record_media')->get();
		$references->progress	= DB::table('record_progress')->get();

		return view('records/edit', ['item' => $item, 'references' => $references]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$this->validateForm($request);
		
		$item = new Record();
		$this->setAttributes($item, $request);
		
		$status     = $item->save();
		$messages   = $status? Lang::get('app.save_success') : Lang::get('app.save_failed');
		
		switch ($request->get('action')) {
			case 'save':
				$action = '/' . $item->id.'/edit';
				break;
			case 'save-new':
				$action = '/create';
				break;
			default:
				$action = '';
				break;
		}

		return redirect('records' . $action)->with('status', $status)->with('messages', $messages);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id){
		$item = Record::find($id);
		if($item->category_id != 0)
			$item->category->tree	= RecordCategory::getNest($item->category->id);

		$item->criteria = DB::table('record_criteria')->find($item->criteria)->name;
		$item->media 	= DB::table('record_media')->find($item->media)->name;
		$item->progress = DB::table('record_progress')->find($item->progress)->name;

		return view('records/details', ['item' => $item]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$item = Record::find($id);
		$item->room_id			= $item->section->box->shelf->room->id;
		$item->shelf_id			= $item->section->box->shelf->id;
		$item->box_id			= $item->section->box->id;
		$item->section_id		= $item->section->id;
		
		if($item->category)
			$item->category->tree	= RecordCategory::getNest($item->category->id);
		
		if($item->date)
			$item->date 		= date("d-m-Y", strtotime($item->date));

		$references = new \stdClass();
		$references->rooms    = Room::get();
		$references->shelves  = Shelf::where('room_id', $item->room_id)->get();
		$references->boxes    = Box::where('shelf_id', $item->shelf_id)->get();
		$references->sections = Section::where('box_id', $item->box_id)->get();

		$references->criteria	= DB::table('record_criteria')->get();
		$references->media		= DB::table('record_media')->get();
		$references->progress	= DB::table('record_progress')->get();

		return view('records/edit', ['item' => $item, 'references' => $references]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$this->validateForm($request);
		// dd($request->input('date'));
		
		$item = Record::find($request->input('id'));
		$this->setAttributes($item, $request);
		
		$status     = $item->save();
		$messages   = $status? Lang::get('app.save_success') : Lang::get('app.save_failed');
		
		switch ($request->get('action')) {
			case 'save':
				$action = '/' . $item->id.'/edit';
				break;
			case 'save-new':
				$action = '/create';
				break;
			default:
				$action = '';
				break;
		}

		return redirect('records' . $action)->with('status', $status)->with('messages', $messages);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Record $record) {
		$status = $record->delete();
		$data   = Record::orderBy('created_at', 'desc')->get();

		$messages = $status? Lang::get('app.delete_success') : Lang::get('app.delete_failed');
		
		return redirect()->route('records.index')->with('status', $status)->with('messages', $messages);
	}

	private function setAttributes($item, Request $request){
		$item->name         = $request->input('name');
		$item->section_id   = $request->input('section_id');
		$item->category_id  = $request->input('category_id');
		$item->date 		= date("Y-m-d", strtotime($request->input('date')));
		$item->date_type	= $request->input('date_type');
		$item->vendor     	= $request->input('vendor');
		$item->criteria     = $request->input('criteria');
		$item->media        = $request->input('media');
		$item->unit         = $request->input('unit');
		$item->quantity     = $request->input('quantity');
		$item->progress     = $request->input('progress');
		$item->descriptions = $request->input('descriptions');
		$item->condition 	= $request->input('condition');
		$item->value 		= $request->input('value');
	}

	private function validateForm(Request $request){
		$this->validate($request, [
			'name'          => 'required',
			'section_id'    => 'required',
			'category_id'   => 'required'
		]);
	}
}
