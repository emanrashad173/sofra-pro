<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;



class Client extends Authenticatable implements JWTSubject
{
    protected $guard = 'clients';
    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'password', 'pin_code', 'district_id', 'api_token','activation','address');

    public function district()
    {
        return $this->belongsTo('App\Models\District');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function tokens()
    {
        return $this->morphMany('App\Models\Token', 'tokenable');
    }

    public function notifications()
    {
        return $this->morphMany('App\Models\Notification', 'notifiable');
    }

    protected $hidden = [
        'password','api_token'
    ];

    //JWTAuth
    public function getJWTIdentifier()
    {
      return $this->getKey(); //Eloquent Model method
    }

    public function getJWTCustomClaims()
    {
     return [];
    }

}
