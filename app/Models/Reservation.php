<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Authenticatable
{
 

    protected $fillable = [
        'date', 'from', 'to','status','doctor_id','user_id','appointments_id'
    ];

    public function doctor()
    {
        return $this->belongsTo('App\Models\User', 'doctor_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function appointment()
    {
        return $this->belongsTo('App\Models\Appointment', 'appointments_id', 'id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
 
}
