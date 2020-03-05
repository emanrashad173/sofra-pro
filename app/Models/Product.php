<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = array('name', 'description', 'price', 'image', 'preparation_time', 'restaurant_id');
    protected $hidden = ['image'];
    protected $appends = ['photo'];

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order');
    }

    public function getPhotoAttribute()
    {
        return asset($this->image);
    }

}
