<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Auth;
use DB;
use App\Site;
use App\Zone;
use App\Browser;
use App\Platform;
use App\OperatingSystem;

class StatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getIndex()
    {

    }
    public function getRange($range)
    {
        try{
            switch($range){
                case 1:
                    $start_date = date('Y-m-d', strtotime('-1 week'));
                    break;
                case 2:
                    $start_date = date('Y-m-d', strtotime('-30 days'));
                    break;
                case 3:
                    $start_date = date('Y-m-d', strtotime('first day of this month'));
                    break;
                case 4:
                    $start_date = date('Y-m-d', strtotime('first day of this year'));
                    break;

            }
            return $start_date;
        }catch(Exception $e){
            Log::error($e->getMessage());
        }
    }
    public function getSiteStats($site_id, $range)
    {
        try{
           $user = Auth::getUser();
           $site = Site::where('id', $site_id)->first();
           if(!$user->is_admin){
               if(!$site->user_id == $user->id){
                   return false;
               }
           } 
           $zone_count = Zone::where('site_id', $site_id)->count();
           if(!$zone_count) return view('stats',['site' => $site, 'zone_count' => $zone_count]); 
           $start_date = $this->getRange($range);
           $query = "SELECT * 
                     FROM stats
                     WHERE site_id = $site_id
                     AND `date` BETWEEN '$start_date' AND '".date('Y-m-d')."'";
           $result = DB::select($query);
           if(sizeof($result)){
               $browsers = Browser::all();
               $platforms = Platform::all();
               $operating_systems = OperatingSystems::all();
               $sitedata = array();
               $zones = array();
               $big = array();
               $imps = 0;
               $clicks = 0;
               foreach($result as $row){
                  if(isset($sitedata[$row->date][$row->country_short]['impressions'])){
                      $sitedata[$row->date][$row->country_short]['impressions'] += $row->impressions;
                  }else{
                      $sitedata[$row->date][$row->country_short]['impressions'] = $row->impressions;
                  }
                  if(isset($sitedata[$row->date][$row->country_short]['clicks'])){
                      $sitedata[$row->date][$row->country_short]['clicks'] += $row->clicks;
                  }else{
                      $sitedata[$row->date][$row->country_short]['clicks'] = $row->clicks;
                  }
                  $clicks += $row->clicks;
                  $imps += $row->clicks;
                  if(isset($big['browsers'])){
                      $big['browsers'][$row->browser] += $row->impressions;
                  }else{
                      $big['browsers'][$row->browser] = $row->impressions;
                  }
                  if(isset($big['platforms'])){
                      $big['platforms'][$row->platform] += $row->impressions;
                  }else{
                      $big['platforms'][$row->platform] = $row->impressions;
                  }
                  if(isset($big['os'])){
                      $big['os'][$row->os] += $row->impressions;
                  }else{
                      $big['os'][$row->os] = $row->impressions;
                  }
               }

               return view('stats',['site' => $site, 'zone_count' => $zone_count, 'browsers' => $browsers, 'platforms' => $platforms, 'operating_systems' => $operating_systems, 'sitedata' => $sitedata, 'zones' => $zones, 'imps' => $imps, 'clicks' => $clicks]);
           }
        }catch(Exception $e){
            Log::error($e->getMessage());
        }
    }
    public function getZoneStats($zone_id, $range)
    {
        try{
            $start_date = $this->getRange($range);

        }catch(Exception $e){
            Log::error($e->getMessage());
        }
    }
}
