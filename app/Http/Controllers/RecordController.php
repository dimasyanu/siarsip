<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

		if(!$filters->limit) $filters->limit = 25;

		$query = Record::with('section');

		if($filters->search)
            $query = $query->where ('records.name', 'regexp', $filters->search);

        $items = $query->orderBy('records.name')->paginate($filters->limit);
		
		return view('records/index', ['items' => $items, 'filters' => $filters]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request) {
		$item                 	= new Record();
		$item->category       	= RecordCategory::find($item->id);

		$references             = new \stdClass();
        $references->rooms      = Room::get();
        $references->shelves 	= array();
        $references->boxes   	= array();
        $references->sections	= array();

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
		$item->category->tree	= RecordCategory::getNest($item->category->id);
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
		$item->category->tree	= RecordCategory::getNest($item->category->id);

        $references = new \stdClass();
        $references->rooms    = Room::get();
        $references->shelves  = Shelf::where('room_id', $item->room_id)->get();
        $references->boxes    = Box::where('shelf_id', $item->shelf_id)->get();
        $references->sections = Section::where('box_id', $item->box_id)->get();

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
		$item->period       = $request->input('period');
		$item->quantity     = $request->input('quantity');
		$item->progress     = $request->input('progress');
		$item->descriptions = $request->input('descriptions');
	}

	private function validateForm(Request $request){
		$this->validate($request, [
			'name'          => 'required',
			'section_id'    => 'required',
			'category_id'   => 'required'
		]);
	}
}
