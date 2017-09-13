<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use Lang;

class RoomController extends Controller {
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
        // $filters->page   = $request->input('page');

        if(!$filters->limit) $filters->limit = 25;

        if($filters->search)
            $query = Room::where('name', 'REGEXP', $filters->search)->orderBy('name');
        else
            $query = Room::orderBy('name');
        
        $items = $query->paginate($filters->limit);

        // dd($items->perPage());

        return view('rooms/index', ['items' => $items, 'filters' => $filters]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('rooms/edit', ['item' => new Room()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validateForm($request);
        
        $item = new Room();
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

        return redirect('rooms' . $action)->with('status', $status)->with('messages', $messages);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $item = Room::find($id);
        return view('rooms/edit', ['item' => $item]);
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
        
        $item = Room::find($request->input('id'));
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

        return redirect('rooms' . $action)->with('status', $status)->with('messages', $messages);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room) {
        $status = $room->delete();
        $data   = Room::orderBy('name')->get();

        $messages = $status? Lang::get('app.delete_success') : Lang::get('app.delete_failed');
        
        return redirect()->route('rooms.index')->with('status', $status)->with('messages', $messages);
    }

    private function setAttributes($item, Request $request){
        $item->name          = $request->input('name');
    }

    private function validateForm(Request $request){
        $this->validate($request, [
            'name'  => 'required',
        ]);
    }
}
