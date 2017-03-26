<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'price', 'image'];

    public function orders()
    {
    	return $this->belongsToMany('Order', 'orderdetails', 'order_id', 'product_id');
    }
}
