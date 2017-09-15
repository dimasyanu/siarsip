<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lang;

use App\Box;
use App\Room;
use App\Section;
use App\Shelf;

class SectionController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $references             = new \stdClass();
        $references->rooms      = Room::get();
        $references->shelves    = array();
        $references->boxes      = array();
        $references->sections   = array();

        $filters = new \stdClass();
        $filters->search = $request->input('search');
        $filters->limit  = $request->input('limit');
        $filters->page   = $request->input('page');

        $filters->room_id  = $request->input('room');
        $filters->shelf_id = $request->input('shelf');
        $filters->box_id   = $request->input('box');

        if(!$filters->limit) $filters->limit = 25;

        $query = Section::select(
            'sections.id', 
            'sections.name', 
            'x.name AS box_name', 
            'y.name AS shelf_name', 
            'z.name AS room_name'
        )->leftJoin('boxes AS x', 'sections.box_id', 'x.id')
        ->leftJoin('shelves AS y', 'x.shelf_id', 'y.id')
        ->leftJoin('rooms AS z', 'y.room_id', 'z.id');

        if($filters->room_id || $filters->shelf_id || $filters->box_id){
            if($filters->box_id) {
                $query = $query->where('x.id', $filters->box_id);
                $box = Box::find($filters->box_id);
                $filters->room_id = $box->shelf->room->id;
                $filters->shelf_id = $box->shelf->id;
                $references->boxes = Box::where('shelf_id', $box->shelf->id)->get();
                $references->shelves = Shelf::where('room_id', $box->shelf->room->id)->get();
            }
            elseif($filters->shelf_id) {
                $query = $query->where('y.id', $filters->shelf_id);
                $shelf = Shelf::find($filters->shelf_id);
                $filters->room_id = $shelf->room->id;
                $references->boxes = Box::where('shelf_id', $shelf->id)->get();
                $references->shelves = Shelf::where('room_id', $shelf->room->id)->get();
            }
            elseif($filters->room_id) {
                $query = $query->where('z.id', $filters->room_id);
                $references->shelves = Shelf::where('room_id', $filters->room_id)->get();
            }
        }

        if($filters->search)
            $query = $query->where('sections.name', 'regexp', $filters->search);

        $items = $query->orderBy('name')->paginate($filters->limit);
        // dd(sizeof($references->shelves));
        return view('sections/index', ['items' => $items, 'filters' => $filters, 'references' => $references]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $references              = new \stdClass();
        $references->rooms       = Room::get();
        $references->shelves     = array();
        $references->boxes       = array();

        return view('sections/edit', ['item' => new Section(), 'references' => $references]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validateForm($request);
        
        $item = new Section();
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

        return redirect('sections' . $action)->with('status', $status)->with('messages', $messages);
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
        $item = Section::select(
            'sections.id', 
            'sections.name', 
            'sections.box_id',
            'x.shelf_id',
            'y.room_id'
        )->leftJoin('boxes AS x', 'sections.box_id', 'x.id')
        ->leftJoin('shelves AS y', 'x.shelf_id', 'y.id')->find($id);
        $references = new \stdClass();
        $references->rooms = Room::get();
        $references->shelves = Shelf::where('room_id', $item->room_id)->get();
        $references->boxes = Box::where('shelf_id', $item->shelf_id)->get();

        return view('sections/edit', ['item' => $item, 'references' => $references]);
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
        
        $item = Section::find($request->input('id'));
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

        return redirect('sections' . $action)->with('status', $status)->with('messages', $messages);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section) {
        $status = $section->delete();
        $data   = Section::orderBy('created_at', 'desc')->get();

        $messages = $status? Lang::get('app.delete_success') : Lang::get('app.delete_failed');
        
        return redirect()->route('sections.index')->with('status', $status)->with('messages', $messages);
    }

    private function setAttributes($item, Request $request){
        $item->name          = $request->input('name');
        $item->box_id    = $request->input('box_id');
    }

    private function validateForm(Request $request){
        $this->validate($request, [
            'name'    => 'required',
            'box_id'  => 'required'
        ]);
    }
}
