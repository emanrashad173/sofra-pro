<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = array('about_app', 'commission', 'commission_text','head_text' ,'app_link', 'payment_bank');

}
