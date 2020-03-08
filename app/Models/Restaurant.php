<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;



class Restaurant extends Authenticatable implements JWTSubject
{
    protected $guard = 'restaurants';
    protected $table = 'restaurants';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'password', 'minimum_order', 'delivery_cost', 'whats_num', 'phone_contact', 'image', 'activation', 'pin_code', 'district_id', 'rate', 'api_token','address');
    protected $hidden = [
        'password','api_token','image'
    ];
    protected $appends = ['photo'];


    public function getPhotoAttribute()
    {
        return asset($this->image);
    }

    public function district()
    {
        return $this->belongsTo('App\Models\District');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }

    public function payment()
    {
        return $this->hasMany('App\Models\Payment');
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
