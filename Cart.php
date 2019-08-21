<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Cart extends Model
{
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
    public static function totalCarts()
    {
        if (Auth::check()) {
            $carts = Cart::where('user_id',Auth::id())
                    ->orwhere('order_id',NULL)
                    ->where('ip_address',request()->ip())
                    ->get();    
        }else{
            $carts = Cart::where('ip_address',request()->ip())->where('order_id',NULL)->get();          
        }

        return $carts;
    }   



}
