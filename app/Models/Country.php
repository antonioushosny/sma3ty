<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Country extends Authenticatable
{
 

    protected $fillable = [
        'name', 'image', 'status'
    ];

    public function cities()
    {
        return $this->hasMany('App\Models\City', 'country_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }
}
