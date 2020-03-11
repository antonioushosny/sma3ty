<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Specialties extends Authenticatable
{
    protected $table = 'specialties';
    protected $fillable = [
        'name', 'image', 'status'
    ];

    public function doctors()
    {
        return $this->hasMany('App\Models\User', 'doctor_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }
}
