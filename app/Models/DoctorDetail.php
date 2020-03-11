<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DoctorDetail extends Authenticatable
{
 

    protected $fillable = [
        'clinic', 'address', 'price','desc','status','country_id','city_id','area_id','specialties_id','user_id'
    ];

    public function doctor()
    {
        return $this->belongsTo('App\Models\User', 'doctor_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }
    
}


 