<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Cache;
use DB;
use Log;
use App\Site;
use App\Browser;
use App\OperatingSystem;
use App\Platform;

class GatherKeysController extends Controller
{
    public function __construct()
    {

    }
    public function getIndex()
    {
        $this->gatherSiteKeys();
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





        Log::info('Gather Keys ended.');        

    }
}
