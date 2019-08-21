<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    
    public function user()
    {
    	return $this->belongsTo(User::class);
    }    
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }       
    public function carts()
    {
    	return $this->hasMany(Cart::class);
    }
}
