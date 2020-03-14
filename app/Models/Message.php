<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
 

    protected $fillable = [
       'chat_id','sender_id','recipient_id','text','status','type'
    ];

    public function sender()
    {
        return $this->belongsTo('App\Models\User', 'sender_id', 'id');
    }

    public function recipient()
    {
        return $this->belongsTo('App\Models\User', 'recipient_id', 'id');
    }

    public function chat()
    {
        return $this->belongsTo('App\Models\Chat', 'chat_id', 'id');
    }


   
}

 