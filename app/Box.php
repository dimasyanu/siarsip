<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Box extends Model {
    public function shelf() {
        return $this->belongsTo('App\Shelf', 'shelf_id');
    }

    public function sections() {
        return $this->hasMany('App\Section');
    }
}
