<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('client_id', 'restaurant_id', 'notes', 'address', 'state', 'cost', 'commission', 'total', 'payment_method_id','net');

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function notification()
    {
        return $this->hasMany('App\Models\Notification');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot('quantity' ,'price_in_order' ,'special_notes');
    }

    public function paymentMethod()
    {
        return $this->belongsTo('App\Models\PaymentMethod');
    }

}
