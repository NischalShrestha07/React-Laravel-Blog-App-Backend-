<?php

namespace App\Http\Controllers;


use App\Models\User;// this is imported
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;// this is imported
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    //method will show register page
    public function register()
    {
        return view("account.register");
    }

    public function processRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:5',
            'password_confirmation' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }

        //Now Register User
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->email = Hash::make($request->password);
        $user->save();

    }
    public function login()
    {

    }
}
