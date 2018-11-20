<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    public function book(){
        return $this->hasMany('App\Book','id_kategori');
    }
    
}
