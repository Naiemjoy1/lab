<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Admin;
use App\User;
use Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index()
    {
        return view('admin');
    }
    public function show()
    {
        $users = User::orderby('id','asc')->get();
        return view ('admin.users',compact('users'));
    }


    public function delete($id)
    {
        $user = User:: find($id);
        if (!is_null($user)) {
            $user->delete();
        }
        session()->flash('success','User deleted successfully !!');
        return back();
    }

}
