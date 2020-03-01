<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{

    protected $table = 'offers';
    public $timestamps = true;
    protected $fillable = array('name' ,'image', 'description', 'from_date', 'to_date', 'restaurant_id','price');
    protected $hidden = ['image'];
    protected $appends = ['photo'];

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }


    public function getPhotoAttribute()
    {
        return asset($this->image);
    }

}
