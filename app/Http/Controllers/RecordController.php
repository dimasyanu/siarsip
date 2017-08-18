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

		$items = Record::with('section')->orderBy('records.name')->paginate($filters->limit);
		
		return view('records/index', ['items' => $items, 'filters' => $filters]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request) {
		$item                 = new Record();
        $item->category       = new RecordCategory();
        $item->category->tree = null;

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
		
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$item = Record::select(
            'records.id', 
            'records.name', 
            'records.section_id',
            'period',
			'quantity',
			'progress',
			'descriptions',
            'x.box_id',
            'x.name AS section_name',
            'y.shelf_id',
            'z.room_id'
        )->leftJoin('sections AS x', 'records.section_id', 'x.id')
        ->leftJoin('boxes AS y', 'x.box_id', 'y.id')
        ->leftJoin('shelves AS z', 'y.shelf_id', 'z.id')->find($id);
        // dd($item);
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
	public function destroy($id) {
		
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
