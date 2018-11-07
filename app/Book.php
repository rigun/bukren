<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function user(){
        return $this->belongsTo(User::class,'id_pemilik');
    }
    public function kategori(){
        return $this->belongsToMany('App\Kategori','kategori_buku','book_id','kategori_id');
    }

}
