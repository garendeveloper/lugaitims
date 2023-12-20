<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function endAllSessions()
    {
        Session::flush();
        Auth::logout();
    }
    public function logout()
    {
        $this->endAllSessions();
        return redirect()->route('user.loginPage')->with('success', 'Thank you for using the app.');
    }
    public function login(Request $request)
    {
        $status = 0; $msg;

        $validator = Validator::make($request->all(), [
            'username' => 'required|min:5|string',
            'password' => 'required|min:6',
        ]);

        if($validator->fails())
            return redirect()->back()->withErrors($validator->messages())->withInput();
        
        if(Auth::attempt(['username'=> $request->username, 'password'=>$request->password]))
        {
            if(Auth::user()->role == 1)
                return redirect()->route('admin.home');
            else
                return redirect()->route('purchaser.home');
        }
        else
            return redirect()->back()->withErrors(['Error' => 'Username or Password is Invalid!']);
    }
}
