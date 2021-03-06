<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    protected $fillable = [
        'title','image','status','disc','type'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }
}
