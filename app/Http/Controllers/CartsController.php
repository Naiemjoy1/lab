<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Auth;


class CartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.pages.carts');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'medicine_id'=> 'required'
        ],
        [
            'medicine_id.required' =>'Please Select A product'
        ]);
        if (Auth::check()) {
        $cart = Cart::orwhere('user_id',Auth::id())
                    ->orwhere('medicine_id', $request->medicine_id)
                    ->first();            
        }else{
        $cart = Cart::where('ip_address',request()->ip())
                    ->where('medicine_id', $request->medicine_id)
                    ->first();
        }

        if (!is_null($cart)) {
            $cart->increment('product_quantity');
        }else{
        $cart = new Cart();
        $cart->medicine_id = $request->medicine_id;
        $cart->sub_price = $cart->medicine->price;
        $cart->ip_address = $request->ip();
        $cart->sub_price = $cart->medicine->price;
        $cart->save();            
        }
return json_encode(['status' => 'success','Message' => 'Item Added to your cart']) ;

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $cart = Cart::where('ip_address',request()->ip())
                    ->where('medicine_id', $request->proId)
                    ->first();
        $cart->medicine_quantity = $request->qty;
        $cart->update(); 
        
    } 


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart = Cart::find($id);
        if (!is_null($cart)) {
            $cart->delete();
        }else{
            return redirect()->route('carts');
        }
        session()->flash('success','Deleted the item');
        return back();
    }
}
