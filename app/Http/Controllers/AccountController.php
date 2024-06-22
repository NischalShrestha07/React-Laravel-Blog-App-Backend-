<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            return redirect()->route('account.register')->withInput()->withErrors(($validator));
        }
    }

}
