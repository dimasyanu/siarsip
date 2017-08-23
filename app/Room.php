<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model {
    public function shelves() {
    	return $this->hasMany('App\Shelf');
    }
}
