<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
 

    protected $fillable = [
        'name', 'image', 'status','city_id'
    ];

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }
    
}
