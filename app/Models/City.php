<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class City extends Authenticatable
{
 

    protected $fillable = [
        'name', 'image', 'status','country_id'
    ];

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'id');
    }

    public function areas()
    {
        return $this->hasMany('App\Models\Area', 'city_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }

}
