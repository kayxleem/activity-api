<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Auth\LoginRequest;
use Auth;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Admincontroller extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function login(LoginRequest $request)
    {
        $check = $request->all();
        //dd($check);
        if(Auth::guard('admin')->attempt(['email'=>$check['email'], 'password' =>$check['password']])){
            //dd($check);
            return redirect()->route('admin.dashboard');
        }else{
            return back()->with('error', 'invalid username or password');
        }
    }

    public function dashboard()
    {

        return view('admin.dashboard');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
