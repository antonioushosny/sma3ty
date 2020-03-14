<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
 

    protected $fillable = [
        'day', 'from', 'to','status','doctor_id'
    ];

    public function doctor()
    {
        return $this->belongsTo('App\Models\User', 'doctor_id', 'id');
    }

    public function reservation()
    {
        return $this->hasOne('App\Models\Reservation', 'appointments_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }
    
}
