<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['location','time', 'laterTime', 'timeInput', 'item'];

    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
