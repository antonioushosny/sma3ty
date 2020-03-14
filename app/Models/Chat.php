<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
 

    protected $fillable = [
       'user_id','status','doctor_id'
    ];

    public function doctor()
    {
        return $this->belongsTo('App\Models\User', 'doctor_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }
}
