<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lang;

use App\Box;
use App\Room;
use App\Shelf;

class BoxController extends Controller {
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

        $query = Box::select(
            'boxes.id', 
            'boxes.name', 
            'x.name AS shelf_name', 
            'y.name AS room_name'
        )->leftJoin('shelves AS x', 'boxes.shelf_id', 'x.id')
        ->leftJoin('rooms AS y', 'x.room_id', 'y.id');

        if($filters->search)
            $query = $query->where ('boxes.name', 'regexp', $filters->search);

         $items = $query->orderBy('name')->paginate(25);

        return view('boxes/index', ['items' => $items, 'filters' => $filters]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $references = new \stdClass();
        $references->rooms = Room::get();
        $references->shelf = new \stdClass();
        $references->shelf->id = 0;
        $references->shelf->name = Lang::get('app.select_item', ['item' => Lang::get('app.shelf')]);

        return view('boxes/edit', ['item' => new Shelf(), 'references' => $references]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validateForm($request);
        
        $item = new Box();
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

        return redirect('boxes' . $action)->with('status', $status)->with('messages', $messages);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $item = Box::select('boxes.id', 'boxes.name', 'boxes.shelf_id','shelves.room_id')
            ->leftJoin('shelves', 'boxes.shelf_id', 'shelves.id')
            ->find($id);
        $references = new \stdClass();
        $references->rooms = Room::get();
        $references->shelf = Shelf::find($item->shelf_id);
        return view('boxes/edit', ['item' => $item, 'references' => $references]);
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
        
        $item = Box::find($request->input('id'));
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

        return redirect('boxes' . $action)->with('status', $status)->with('messages', $messages);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Box $box) {
        $status = $box->delete();
        $data   = Box::orderBy('created_at', 'desc')->get();

        $messages = $status? Lang::get('app.delete_success') : Lang::get('app.delete_failed');
        
        return redirect()->route('boxes.index')->with('status', $status)->with('messages', $messages);
    }

    private function setAttributes($item, Request $request){
        $item->name          = $request->input('name');
        $item->shelf_id       = $request->input('shelf_id');
    }

    private function validateForm(Request $request){
        $this->validate($request, [
            'name'  => 'required',
            'shelf_id'  => 'required'
        ]);
    }
}
