<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Cache;
use DB;
use Log;
use App\Zone;
use App\Site;
use App\Browser;
use App\OperatingSystem;
use App\Platform;
use App\Country;
use App\City;
use App\State;

class GatherKeysController extends Controller
{
    public function __construct()
    {

    }
    public function getIndex()
    {
        $this->gatherSiteKeys();
        $this->gatherImpressions();
    }
    public function gatherSiteKeys()
    {
        Log::info('Gather Site Keys began');
        /* get browser definitions */
        $browsers = array();
        $browsers[0] = 'Other';
        $b = Browser::all();
        foreach($b as $row){
           $browsers[$row->id] = $row->browser;
        }
        /* get platform definitions */
        $platforms = array();
        $platforms[0] = 'Other';
        $p = Platform::all();
        foreach($p as $row){
            $platforms[$row->id] = $row->platform;
        }
        /* get os definitions */
        $os = array();
        $os[0] = 'Other';
        $o = OperatingSystem::all();
        foreach($o as $row){
            $os[$row->id] = $row->os;
        }
        
        $str = 'laravel:SITE|*';
        $keys = Redis::keys($str);
        foreach($keys as $key => $value){
            $mydata = explode('|',$value);
            $site = Site::where('site_handle', $mydata[1])->first();
               
            $impressions = Redis::getset($value, 0);
            if($impressions){
            Log::info($site['site_name'].' - handle: '.$mydata[1].' Key: '.$value.' has a value of '.$impressions);
            $sql = "INSERT INTO site_analysis (site_handle, stat_date, geo, state, city, device, browser, os, impressions)
                    VALUES('".$mydata[1]."','".$mydata[2]."','".$mydata[3]."','".$mydata[4]."','".$mydata[5]."',";
            $device = 0;
            foreach($platforms as $k => $v){
                if($mydata[6] == $v) {
                    $device = $k;
                }
            }    
            $browser = 0;
            foreach($browsers as $k => $v){
                if($mydata[8] == $v){
                    $browser = $k;
                }
            }
            $myos = 0;
            foreach($os as $k => $v){
                if($mydata[7] == $v){
                    $myos = $k;
                }
            }
            $sql .= "$device,$browser,$myos, $impressions) ON DUPLICATE KEY UPDATE impressions = impressions + $impressions";
            DB::insert($sql);
            }else{
                Redis::del($value);
            }
                   
        }





        Log::info('Gather Site Keys ended.');        

    }
    public function transposeUser($user)
    {
        $data = array();
        if(is_array($user)){
            $platform = Platform::where('platform', $user['platform'])->get();
            $browser = Browser::where('browser', $user['browser'])->get();
            $os = OperatingSystem::where('os', $user['os'])->get();
            $country = Country::where('country_short', $user['geo'])->get();
            if(!sizeof($country)){
                DB::insert("INSERT INTO countries VALUES(NULL,'".$user['geo']."','',NULL,NULL);");
                $country = Country::where('country_short', $user['geo'])->get();
            }
            $state = State::where('state_name', $user['state'])->get();
            $city = City::where('state_code', $state[0]->id)->where('city_name', $user['city'])->get();
            if(!sizeof($city)){
                DB::insert("INSERT INTO cities VALUES(NULL,'".$user['city']."',".$state[0]->id.",NULL,NULL);");
                $city = City::where('state_code', $state[0]->id)->where('city_name', $user['city'])->get();
            }
            $data['platform'] = $platform[0]->id;
            $data['browser'] = $browser[0]->id;
            $data['os'] = $os[0]->id;
            $data['country'] = $country[0]->id;
            $data['state'] = $state[0]->id;
            $data['city'] = $city[0]->id;

        }
        return $data;

    }
    public function gatherImpressions()
    {
        // 'IMPRESSION|'.date('Y-m-d').'|'.$this->handle.'|'.$this->ad_id.'|'.$creative->id.'|'.serialize($this->visitor);
        /* get impression keys */
        $pairs = array();
        do{
            $keyname = Redis::spop('KEYS_IMPRESSIONS');
            if(strlen(trim($keyname))){
                $val = Redis::get($keyname);
                Redis::del($keyname);
                $stuff = explode("|", $keyname);
                $visitor = unserialize($stuff[5]);
                $zone = Zone::where('handle', $stuff[2])->first();
          
                $data = $this->transposeUser($visitor);
                $pair = '('.$zone->site_id.','
                        .$zone->id.",'"
                        .$stuff[3]."',"
                        .$stuff[4].','
                        .$data['country'].','
                        .$data['state'].','
                        .$data['city'].','
                        .$data['platform'].','
                        .$data['os'].','
                        .$data['browser'].','
                        .$val.",'"
                        .$stuff[1]."')";
                 $pairs[] = $pair;
            }
        }while(!$keyname == '');
        if(sizeof($pairs)){
        $prefix = "INSERT INTO stats (`site_id`,`zone_id`,`ad_id`,`ad_creative_id`,
                   `country_id`,`state_code`,`city_code`,`platform`,`os`,`browser`,`impressions`,`stat_date`) VALUES";
        $suffix = " ON DUPLICATE KEY UPDATE `impressions` = `impressions` + VALUES(`impressions`);";
        $query = $prefix.implode(",",$pairs).$suffix;
        DB::insert($query);
        Log::info($query);
        }
        Log::info('Impressions Gathered');
    }
}
