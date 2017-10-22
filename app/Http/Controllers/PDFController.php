<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Record;
use App\Room;
use App\Section;
use App\Shelf;
use PDF;

class PDFController extends Controller {
	public function __construct(){
		$this->middleware('auth');
	}

	public function getPDF() {
		$records = Record::get();
		$pdf = PDF::loadView('pdf.records', ['records' => $records]);
		return $pdf->download('arsip.pdf');
	}

	public function printRecords($by, $id) {
		$record_fields = [
			'records.id', 
			'records.name', 
			'records.date', 
			'records.quantity', 
			'records.progress', 
			'records.descriptions',
			'a.box_id',
			'b.name AS box_name',
			'b.shelf_id',
			'c.name AS shelf_name',
			'c.room_id',
			'd.name AS room_name'
		];

		$query = Record::select($record_fields)
				->leftJoin('sections AS a', 'records.section_id', 'a.id')
				->leftJoin('boxes AS b', 'a.box_id', 'b.id')
				->leftJoin('shelves AS c', 'b.shelf_id', 'c.id')
				->leftJoin('rooms AS d', 'c.room_id', 'd.id');

		switch ($by) {
			case 'room':
				$query = $query->where('d.id', $id);
				break;
			
			case 'shelf':
				$query = $query->where('c.id', $id);
				break;

			case 'box':
				$query = $query->where('b.id', $id);
				break;

			default: break;
		}

		$items = $query->get();
		$rooms = $this->getSortedArray($items);
		// dd($rooms);

		return view('pdf/preview', ['rooms' => $rooms]);
	}

	public function printAllPreview() {
		$shelf_fields = ['shelves.id', 'shelves.name', 'rooms.name AS room_name'];
		$shelves_obj = $this->buildQuery($shelf_fields, 'shelves.id')->get()->toArray();
		$shelves = array();
		foreach ($shelves_obj as $shelf) { 
			$shelves[$shelf->id] = $shelf; 
			$shelves[$shelf->id]->boxes = array(); 
		}

		$box_fields = ['boxes.id', 'boxes.name', 'boxes.shelf_id'];
		$boxes_obj = $this->buildQuery($box_fields, 'boxes.id')->get()->toArray();
		$boxes = array();
		foreach ($boxes_obj as $box) { 
			$boxes[$box->id] = $box; 
			$boxes[$box->id]->records = array(); 
		}

		$record_fields = [
			'records.id', 
			'records.name', 
			'records.date', 
			'records.quantity', 
			'records.progress', 
			'records.descriptions',
			'sections.box_id'
		];
		$records_obj = $this->buildQuery($record_fields)->get();

		foreach ($records_obj as $record)
			$boxes[$record->box_id]->records[] = $record;
		foreach ($boxes as $box)
			$shelves[$box->shelf_id]->boxes[] = $box;

		return view('pdf.records', ['shelves' => $shelves]);
	}

	public function printShelfPreview($id) {
		$data = $this->buildQuery(['rooms.name AS room_name', 'shelves.name AS shelf_name'], 'shelves.id', ['shelves.id', '=', $id])->get()->toArray();
		
		$box_fields = ['boxes.id', 'boxes.name'];
		$boxes_obj = $this->buildQuery($box_fields, 'boxes.id', ['shelves.id', '=', $id])->get()->toArray();

		$boxes = array();
		foreach ($boxes_obj as $box) { 
			$boxes[$box->id] = $box; 
			$boxes[$box->id]->records = array(); 
		}

		$record_fields = [
			'records.id', 
			'records.name', 
			'records.date', 
			'records.quantity', 
			'records.progress', 
			'records.descriptions',
			'sections.box_id'
		];
		$records_obj = $this->buildQuery($record_fields, null, ['shelves.id', '=', $id])->get();
		foreach ($records_obj as $record)
			$boxes[$record->box_id]->records[] = $record;

		return view('pdf.shelf', ['boxes' => $boxes, 'data' => $data[0]]);
	}

	public function printBoxPreview($id) {
		$data_fields = [
			'rooms.name AS room_name', 
			'shelves.name AS shelf_name',
			'boxes.name AS box_name'
		];

		$data = $this->buildQuery($data_fields, 'boxes.id', ['boxes.id', '=', $id])->get()->toArray();

		$record_fields = [
			'records.id', 
			'records.name', 
			'records.date', 
			'records.quantity', 
			'records.progress', 
			'records.descriptions',
			'sections.box_id'
		];
		$records = $this->buildQuery($record_fields, null, ['boxes.id', '=', $id]);
		$records = $records->orderBy('records.date', 'asc')->get()->toArray();
		return view('pdf.box', ['records' => $records, 'data' => $data[0]]);
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

	private function getSortedArray($items) {
		$rooms = array();
		foreach ($items as $key => $item) {
			if(!array_key_exists($item->room_id, $rooms)) {
				$room = new \stdClass();
				$room->name = $item->room_name;
				$room->shelves = array();
				$rooms[$item->room_id] = $room;
			}

			if(!array_key_exists($item->shelf_id, $rooms[$item->room_id]->shelves)) {
				$shelf = new \stdClass();
				$shelf->name = $item->shelf_name;
				$shelf->boxes = array();
				$rooms[$item->room_id]->shelves[$item->shelf_id] = $shelf;
			}

			if(!array_key_exists($item->box_id, $rooms[$item->room_id]->shelves[$item->shelf_id]->boxes)) {
				$box = new \stdClass();
				$box->name = $item->box_name;
				$box->records = array();
				$rooms[$item->room_id]->shelves[$item->shelf_id]->boxes[$item->box_id] = $box;
			}

			$rooms[$item->room_id]->shelves[$item->shelf_id]->boxes[$item->box_id]->records[$item->id] = $item;
		}

		return $rooms;
	}
}
