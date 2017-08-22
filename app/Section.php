<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model {
    public function box() {
        return $this->belongsTo('App\Box', 'box_id');
    }
}
