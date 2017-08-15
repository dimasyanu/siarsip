<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model {	
	public static function makeTree($id, &$data, &$code = '') {
		$item   = ItemCategory::find($id);
		
    	if($item->parent_id != 0)
    		ItemCategory::makeTree($item->parent_id, $data, $code);

		if(count($data) > 0) {
			$code .= end($data)->code.'-';
			$item->code = str_replace($code, '', $item->code);;
		}
    	$data[] = $item;
	}

	// Get list of Collection objects with parent-child sorting.
	public static function getNest($id) {
		$data = array();
		ItemCategory::makeTree($id, $data);
    	return $data;
    }
}
