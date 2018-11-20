<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class article extends Model
{
    public function user(){
        return $this->belongsTo(User::class,'author_id');
    }
}
