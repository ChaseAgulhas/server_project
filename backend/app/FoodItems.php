<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodItems extends Model
{
    protected $fillable = ['name', 'price', 'amountAvailable'];
}
