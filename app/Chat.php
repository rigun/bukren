<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    public function user1(){
        return $this->belongsTo(User::class,'id_user1');
    }
    public function user2(){
        return $this->belongsTo(User::class,'id_user2');
    }
}
