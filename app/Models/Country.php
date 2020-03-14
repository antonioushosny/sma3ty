<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
 
    protected $fillable = [
        'name', 'image', 'status'
    ];

    public function cities()
    {
        return $this->hasMany('App\Models\City', 'country_id', 'id')->with('areas');
    }

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }
}
