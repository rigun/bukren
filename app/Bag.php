<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bag extends Model
{
    public function barang(){
        return $this->belongsTo('App\Book','barang_id');
    }
    public function pemilik(){
        return $this->belongsTo('App\User','pemilik_id');
    }
}
