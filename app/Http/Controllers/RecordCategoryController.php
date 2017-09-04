<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lang;

use App\RecordCategory;

class RecordCategoryController extends Controller {
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

		if(!$filters->limit) $filters->limit = 25;

        if($filters->search)
            $query = RecordCategory::where('name', 'REGEXP', $filters->search)->orderBy('code');
        else
            $query = RecordCategory::orderBy('code');

		$items = $query->paginate($filters->limit);
		// dd($items->links());

		return view('record_categories/index', ['items' => $items, 'filters' => $filters]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request) {
		$old_id = $request->input('id');
		$item   = new RecordCategory();
		$parent = new \stdClass();

		if($old_id) {
			$old = RecordCategory::find($old_id);
			$item->parent_id = $old->parent_id;
			$parent->tree = RecordCategory::getNest($old->id);
		}
		else {
			$parent->tree = null;	
		}
		
		$parent->closest = RecordCategory::find($item->parent_id);

		return view('record_categories/edit', ['item' => $item, 'parent' => $parent]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$this->validateForm($request);
		
		$item = new RecordCategory();
		$this->setAttributes($item, $request);
		
		$status     = $item->save();
		$messages   = $status? Lang::get('app.save_success') : Lang::get('app.save_failed');
		
		switch ($request->get('action')) {
			case 'save':
				$action = '/' . $item->id.'/edit';
				break;
			case 'save-new':
				return redirect()->route('categories.create', ['id' => $item->id])->with('status', $status)->with('messages', $messages);
			default:
				$action = '';
				break;
		}

		return redirect('categories' . $action)->with('status', $status)->with('messages', $messages);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$item            = RecordCategory::find($id);
		$parent          = new \stdClass();
		$parent->closest = RecordCategory::find($item->parent_id);
		$parent->tree    = RecordCategory::getNest($id);

		return view('record_categories/edit', ['item' => $item, 'parent' => $parent]);
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
		
		$item = RecordCategory::find($request->input('id'));
		$this->setAttributes($item, $request);
		
		$status     = $item->save();
		$messages   = $status? Lang::get('app.save_success') : Lang::get('app.save_failed');
		
		switch ($request->get('action')) {
			case 'save':
				$action = '/' . $item->id.'/edit';
				break;
			case 'save-new':
				return redirect()->route('categories.create', ['id' => $item->id])->with('status', $status)->with('messages', $messages);
			default:
				$action = '';
				break;
		}

		return redirect('categories' . $action)->with('status', $status)->with('messages', $messages);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(RecordCategory $category) {
		$status = $category->delete();
		$data   = RecordCategory::orderBy('created_at', 'desc')->get();

		$messages = $status? Lang::get('app.delete_success') : Lang::get('app.delete_failed');
		
		return redirect()->route('categories.index')->with('status', $status)->with('messages', $messages);
	}

	private function setAttributes($item, Request $request){
		$item->parent_id     = $request->input('parent_id');
		$item->name          = $request->input('name');
		$item->code          = $request->input('code');
	}

	private function validateForm(Request $request){
		$this->validate($request, [
			'parent_id'  => 'required',
			'name'  => 'required',
			'code'  => 'required'
		]);
	}
}
