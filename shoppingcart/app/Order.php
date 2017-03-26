<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'name', 'email', 'phone', 'status'];

    public function products()
    {
    	return $this->belongsToMany('App\Product', 'orderdetails', 'order_id', 'product_id');
    }
}
