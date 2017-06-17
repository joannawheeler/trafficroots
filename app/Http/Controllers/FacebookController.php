<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class FacebookController extends Controller
{
    public function __construct()
    {

    }

    public function login(Request $request)
    {
        if($this->checkToken($request->facebook, $request->user_id)){
        $result = User::where('email',$request->email)->first();
        if(count($result)){
            //user is already registered
            Auth::loginUsingId($result->id);
            $info = array();
            $info['status'] = 'verified';
            $info['url'] = '/home';

            return json_encode($info);
        }else{
           //new user
           $data = array();
           $data['name'] = $request->name;
           $data['facebook'] = $request->facebook;
           $data['email'] = $request->email;
           $data['password'] = bcrypt($request->facebook);
           $data['created_at'] = date('Y-m-d H:i:s');
           $user = new User();
           $user->fill($data);
           $user->save();
           Auth::loginUsingId($user->id);
            $info['status'] = 'verified';
            $info['url'] = '/home';

            return json_encode($info);
        }
        }else{
            $info['status'] = 'not verified';
            $info['url'] = '/login';

            return json_encode($info);
       }        
    }

    public function checkToken($token, $user_id)
    {
        $secret = 'bc15fb052f05833c8d5403c0dd12f934';
        $app_id = '107703369819007';
        $valid = true;
        $url = "https://graph.facebook.com/oauth/access_token?client_id=$app_id&client_secret=$secret&grant_type=client_credentials";
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ));
        $response = json_decode(curl_exec($ch));
        $access_token = $response->access_token;

        $url = "https://graph.facebook.com/debug_token?input_token=$token&access_token=$access_token";
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ));
        $response = json_decode(curl_exec($ch),true);
        if(!isset($response['data']['app_id'])) return false;
        if(!$response['data']['app_id'] == $app_id) $valid = false;        
        if(!$response['data']['user_id'] == $user_id) $valid = false;

        return $valid;
    }
}
