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
    public function index() {
        $items = RecordCategory::orderBy('code')->paginate(25);
        return view('record_categories/index', ['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $item            = new RecordCategory();
        $parent          = new \stdClass();
        $parent->closest = RecordCategory::find($item->parent_id);
        $parent->tree    = null;
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
                $action = '/create';
                break;
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
                $action = '/create';
                break;
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
