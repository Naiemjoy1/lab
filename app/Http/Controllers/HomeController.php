<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Medicine;
use App\Category;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function profile()
    {
        $users = User::orderby('id','asc')->where('id',Auth::id())->get();
        return view ('user.profile',compact('users'));
    }

    public function proedit($id)
    {
        $user = User::find($id);
        return view ('user.user_edit')->with('user',$user);  
    }

    public function proupdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);


        $user = User:: find($id);

        $user->name = $request->name;
        $user->email = $request->email;    
        $user->save();
        session()->flash('success','User Details Updated successfully !!');
        return redirect()->route('user.profile'); 
    }

       public function search(Request $request)

    {
        $search = $request->search;
        $medicines = Medicine::where('name','like','%'.$search.'%')
        ->orderby('id','desc')
        ->paginate(20);
        return view('search',compact('search','medicines'));
    } 

}
