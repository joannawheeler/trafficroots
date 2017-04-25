<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class ConfirmController extends Controller
{
    public function confirm(Request $request)
    {
        if(strlen($request->handle)){
            $user = User::where('handle', $request->handle)->where('status', 0);
            if(sizeof($user)){
                User::where('handle', $request->handle)->update(['status' => 1]);
            }

        }
        return redirect('/home');
    }    //
}
