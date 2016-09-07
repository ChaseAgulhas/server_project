<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['products', 'comment'];

    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
