<?php

namespace App\Http\Controllers\AuthAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
 use AuthenticatesUsers;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('authAdmin.login');
    }

   public function login(Request $request)
    {
        $this->validate($request ,[

            'email'=>'required|email',
            'password'=>'required|min:5',
        ]);

        $credential = [
            'email'=> $request->email,
            'password'=> $request->password,
        ];

        if (Auth::guard('admin')->attempt($credential, $request->member)) {
                return redirect()->intended(route('admin.home'));
            }else{
                session()->flash('error','Email or Password did not matched.');
                return redirect()->route('admin.login');
            }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return  redirect()->route('admin.login');
    }
}
