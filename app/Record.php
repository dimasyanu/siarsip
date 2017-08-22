<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model {
    public function section() {
        return $this->belongsTo('App\Section', 'section_id');
    }

    public function category() {
    	return $this->belongsTo('App\RecordCategory', 'category_id');	
    }
}
