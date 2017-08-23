<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lang;

use App\Room;
use App\Shelf;

class ShelfController extends Controller {
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

        $query = Shelf::select('shelves.id', 'shelves.name', 'rooms.name AS room_name')
                ->leftJoin('rooms', 'shelves.room_id', 'rooms.id');

        if($filters->search)
            $query = $query->where ('shelves.name', 'regexp', $filters->search);
                        //->orWhere ('rooms.name', 'regexp', $filters->search);

        $items = $query->orderBy('name')->paginate(25);
        
        $usedShelves_obj = $this->buildQuery('shelves.id', 'shelves.id')->get();
        $usedShelves = array();
        foreach ($usedShelves_obj as $key => $shelf)
            $usedShelves[] = $shelf->id;

        foreach ($items as $item)
            if(in_array((string)$item->id, $usedShelves))
                $item->hasRecords = true;

        return view('shelves/index', ['items' => $items, 'filters' => $filters]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $room_id = $request->input('room_id');

        $item = new Shelf();
        $item->room_id = $room_id;
        if($room_id)
            $item->storage_mode = true;

        $rooms = Room::get();

        return view('shelves/edit', ['item' => $item, 'rooms' => $rooms]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validateForm($request);
        
        $item = new Shelf();
        $this->setAttributes($item, $request);
        
        $status     = $item->save();
        $messages   = $status? Lang::get('app.save_success') : Lang::get('app.save_failed');
        
        switch ($request->get('action')) {
            case 'save':
                $action = 'shelves/' . $item->id.'/edit';
                break;
            case 'save-new':
                $action = 'shelves/create';
                break;
            default:
                $action = $request->input('storage_mode')?'storages':'shelves';
                break;
        }

        return redirect($action)->with('status', $status)->with('messages', $messages);
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
        $item = Shelf::find($id);
        $rooms = Room::get();
        return view('shelves/edit', ['item' => $item, 'rooms' => $rooms]);
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
        
        $item = Shelf::find($request->input('id'));
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

        return redirect('shelves' . $action)->with('status', $status)->with('messages', $messages);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shelf $shelf) {
        $status = $shelf->delete();
        $data   = Shelf::orderBy('created_at', 'desc')->get();

        $messages = $status? Lang::get('app.delete_success') : Lang::get('app.delete_failed');
        
        return redirect()->route('shelves.index')->with('status', $status)->with('messages', $messages);
    }

    private function setAttributes($item, Request $request){
        $item->name          = $request->input('name');
        $item->room_id       = $request->input('room_id');
    }

    private function validateForm(Request $request){
        $this->validate($request, [
            'name'  => 'required',
            'room_id'  => 'required'
        ]);
    }

    private function buildQuery($fields, $group = null, $condition = null) {
        $query = DB::table('records')->select($fields)
        ->leftJoin('sections', 'records.section_id', 'sections.id')
        ->leftJoin('boxes', 'sections.box_id', 'boxes.id')
        ->leftJoin('shelves', 'boxes.shelf_id', 'shelves.id')
        ->leftJoin('rooms', 'shelves.room_id', 'rooms.id');

        if($group)
            $query = $query->groupBy($group);
        if($condition)
            $query = $query->where($condition[0], $condition[1], $condition[2]);


        return $query;
    }
}
