<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
 use App\Notifications\MailResetPasswordNotification;
// use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable
{
    use Notifiable;
    // use SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password','mobile','image','device_token','role','status','lang','type',
        ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($token));
    }
    protected $hidden = [
        'password',
        //  'remember_token',
    ];
    public function generateToken()
    {
        $this->remember_token = str_random(60);
        $this->save();
        return $this->api_token;
    }

    public function doctorDetails()
    {
        return $this->hasOne('App\Models\doctorDetails', 'user_id', 'id');
    }

    public function appointments()
    {
        return $this->hasMany('App\Models\Appointment', 'doctor_id', 'id');
    }

    public function doctorChats()
    {
        return $this->hasMany('App\Models\Chat', 'doctor_id', 'id');
    }

    public function userChats()
    {
        return $this->hasMany('App\Models\Chat', 'user_id', 'id');
    }
    
    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }
    
}
