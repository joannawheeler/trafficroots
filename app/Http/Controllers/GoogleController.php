<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function __construct()
    {

    }

    public function login(Request $request)
    {
        $result = User::where('email',$request->email)->first();
        if(count($result)){
            //user is already registered
            Auth::loginUsingId($result->id);
            return redirect()->route('/home');
        }else{
           //new user
           $data = array();
           $data['name'] = $request->name;
           $data['google'] = $request->google;
           $data['email'] = $request->email;
           $data['password'] = bcrypt($request->google);
           $data['created_at'] = date('Y-m-d H:i:s');
           $user = new User();
           $user->fill($data);
           $user->save();
           Auth::loginUsingId($user->id);
           return redirect()->route('/home');
        }
    }    //
}
