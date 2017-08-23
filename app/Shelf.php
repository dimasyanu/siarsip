<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shelf extends Model {
    public function room() {
        return $this->belongsTo('App\Room', 'room_id');
    }

    public function boxes() {
        return $this->hasMany('App\Box');
    }
}
