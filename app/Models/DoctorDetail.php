<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DoctorDetail extends Model
{
 

    protected $fillable = [
        'clinic', 'address', 'price','desc','status','country_id','city_id','area_id','specialties_id','user_id'
    ];

    public function doctor()
    {
        return $this->belongsTo('App\Models\User', 'doctor_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }

    public function area()
    {
        return $this->belongsTo('App\Models\Area', 'area_id', 'id');
    }

    public function specialties()
    {
        return $this->belongsTo('App\Models\Specialties', 'specialties_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }
    
}


 