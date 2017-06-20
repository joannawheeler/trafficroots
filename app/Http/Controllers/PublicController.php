<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Log;

class PublicController extends Controller
{

    public function aboutUs()
    {
        return view('about');
    }    //

    public function getLandingPage()
    {
        /* u.s. data */
        $sql = "SELECT SUM(impressions) as impressions, state 
                FROM site_analysis
                JOIN states ON site_analysis.state = states.state_name
                WHERE geo = 'US'
                AND legal = 1
                GROUP BY state
                ORDER BY impressions DESC
                LIMIT 20;";
         $result = DB::select($sql);
         $targeted_traffic = 0;
         foreach($result as $row){
             $targeted_traffic += $row->impressions;

         }
         $us_display = '<table id="us_table" class="table table-border table-hover table-stripe"><thead><tr><th>Chunk</th><th>State</th></tr></thead><tbody>';
         foreach($result as $row){
             $factor = round(($row->impressions / $targeted_traffic) * 100, 2);
             $us_display .= '<tr><td>'.$factor.' %</td><td>'.$row->state.'</td></tr>';
         }
         $us_display .= '</tbody></table>';

        /* global data */
        $sql = "SELECT SUM(impressions) as impressions, countries.country_name 
                FROM site_analysis
                JOIN countries ON site_analysis.geo = countries.country_short
                WHERE countries.targeted = 1
                GROUP BY country_name
                ORDER BY impressions DESC
                LIMIT 20;";
         $result = DB::select($sql);
         $targeted_traffic = 0;
         foreach($result as $row){
             $targeted_traffic += $row->impressions;

         }
         $geo_display = '<table id="geo_table" class="table table-border table-hover table-stripe"><thead><tr><th>Chunk</th><th>Country</th></tr></thead><tbody>';
         foreach($result as $row){
             $factor = round(($row->impressions / $targeted_traffic) * 100, 2);
             $geo_display .= '<tr><td>'.$factor.' %</td><td>'.$row->country_name.'</td></tr>';
         }
         $geo_display .= '</tbody></table>';

        return view('landing',['us_display' => $us_display, 'geo_display' => $geo_display]);
    }

    public function subscribeUser(Request $request)
    {
        /* implement Sendlane api 
         * returns boolean
         */
        Log::info('begin subscribe function');
        $return = array();
        $return['result'] = 'error';
        $this->validate($request, [
            'email' => 'required||email|unique:users|max:255',
            'first_name' => 'required',
            'last_name' => 'required',
            'list_id' => 'required',
          ]);
         Log::info('request validated');
         $api_key = '6d507e5b8b5474d';
         $hash_key = 'f7322a3aef2bb58d8aabf9f380e17d59';
         $api_url = 'https://trafficroots.sendlane.com/api/v1/';
         $command = 'list-subscriber-add';
         $list_id = intval($request->list_id);
         $email = $request->email;
         $first_name = $request->first_name;
         $last_name = $request->last_name;
         $url = $api_url.$command;
         $post = array('api' => $api_key, 'hash' => $hash_key, 'list_id' => $list_id, 'email' => $email, 'first_name' => $first_name, 'last_name' => $last_name);
         $ch = curl_init();
         Log::info('cUrl initiated');
         curl_setopt($ch,CURLOPT_URL, $url);
         curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($ch, CURLOPT_POST, 1);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
         $result = curl_exec($ch);
         if (!curl_errno($ch)) {
            $info = curl_getinfo($ch);
            if($info['http_code'] == 200){
                Log::info( 'Took '. $info['total_time']. ' seconds to send a request to '. $info['url']. "\n");
                $return['result'] = 'OK';
                $stuff = json_decode($result);
                $return['response'] = $stuff;
                return json_encode($return);
            }else{
                
                Log::error('Failed getting '.$info['url'].' : response code '.$info['http_code']);
            }
         } 
         return json_encode($return);
    }
}
