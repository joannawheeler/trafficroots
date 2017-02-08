<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use App\Zone;
use App\ModuleType;
use App\LocationType;
use DB;
use Log;
use Auth;
use Session;
class ZoneController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth"); 
   
    }
    public function getZones($site_id)
    {
        $user = Auth::getUser();
        if($user->user_type == 99){
            $site = Site::where('id', $site_id)->first();
        }else{
            $site = Site::where('id', $site_id)->where('user_id', $user->id)->first();
        }
        if(!sizeof($site)){
            $msg = 'Invalid Site';
            return ($msg);
        }else{
            $sql = "SELECT DISTINCT(stat_date) FROM site_analysis WHERE site_handle = '".$site->site_handle."'";
            $result = DB::select($sql);
            if(sizeof($result) < 3){
                $msg = '<div><p>For all new sites, 72 hours of traffic analysis is required before Zone Creation can be activated.</p><br /><p>Please insert the following image tag on your site`s main index page.  When sufficient data has been gathered, your site can be added to our inventory and you will be able to create zones!</p><br />This code will show a transparent 1x1 GIF image.<br /><br /><code>'.htmlspecialchars('<img alt="Trafficroots Analysis Pixel" src="'.env('APP_URL', 'http://localhost').'/pixel/'.$site->site_handle.'" width: 1px; height: 1px;>');
                $msg .= '</code><br /><br /><a href="/analysis/'.$site->site_handle.'"><button type="button" class="btn-u">View Site Analysis Data</button></a></div>';
                $msg = $site->site_name .'|'.$msg;
                return $msg;
            }else{
                $msg = '<div><h3>Your Trafficroots Analysis Pixel</h3><code>'.htmlspecialchars('<img alt="Trafficroots Analysis Pixel" src="'.env('APP_URL', 'http://localhost').'/pixel/'.$site->site_handle.'" width: 1px; height: 1px;>');
                $msg .= '</code><br /><br /><a href="/analysis/'.$site->site_handle.'"><button type="button" class="btn-u">View Site Analysis Data</button></a><br /><br />';
            $zones = Zone::where('site_id', $site_id)
                     ->join('location_types', 'zones.location_type', '=', 'location_types.id')
                     ->select('zones.id','zones.handle','zones.description','zones.status','zones.location_type','location_types.description as location','location_types.width','location_types.height')
                     ->get();
            if(sizeof($zones)){
                $msg .= '<table class="table table-hover table-border table-striped table-condensed" width="100%" id="zones_table"><thead><tr><th>Zone ID</th><th>Description</th><th>Width</th><th>Height</th><th>Location</th><th>Stats</th></thead><tbody>';
                foreach($zones as $zone){
                    $msg .= '<tr><td>'.$zone->id.'</td><td>'.$zone->description.'</td><td>'.$zone->width.'</td><td>'.$zone->height.'</td><td>'.$zone->location.'</td><td><a href="/zonestats/'.$zone->id.'"><i class="fa fa-bar-chart zone-stat" aria-hidden="true"></i></a></td><tr>';
                }
                $msg .= '</table>';
                $msg .= '<br /><br /><a href="/addzone/'.$site_id.'"><button type="button" class="btn-u">Create A Zone on '.$site->site_name.'</button></a></div>';
                $msg = $site->site_name .'|'.$msg;
                return($msg);
            }else{
                $msg .= '<h4>No Zones Defined on '.$site->site_name.'</h4>';
                $msg .= '<br /><br /><a href="/addzone/'.$site_id.'"><button type="button" class="btn-u">Create A Zone on '.$site->site_name.'</button></a></div>';
                $msg = $site->site_name .'|'.$msg;
                return($msg);
            }
            }

        }
    }
    public function postZone(Request $request)
    {
        try{
            $user = Auth::getUser();
            $data = $request->all();
            $site = Site::where('id', $data['site_id'])->
                          where('user_id', $user->id)->
                          first();
            if(sizeof($site)){
                $zone = new Zone();
                $data['handle'] = bin2hex(random_bytes(5));
                $zone->fill($data);
                $zone->save();
                Session::flash('status', 'Zone Creation was Successful');
                return redirect()->action('HomeController@index');
            }else{
                Log::error('zone creation failed - invalid site');
            }       
        }catch(Exception $e){
            Log::error($e->getMessage());
        }
    }
    public function addZone($site_id)
    {
        try{
            $user = Auth::getUser();
            $site = Site::where('id', $site_id)->
                          where('user_id', $user->id)->
                          first();
            if(sizeof($site)){
               $module_types = ModuleType::all();
               $location_types = LocationType::all(); 
               $locations = $modules = '';
               foreach($location_types as $loc){
                   $locations .= "<option value=\"".$loc->id."\">".$loc->description." - ".$loc->width."x".$loc->height."</option>";
               }
               foreach($module_types as $mod){
                   $modules .= "<option value=\"".$mod->id."\">".$mod->description."</option>";
               }
               return view('addzone',['site' => $site, 'location_types' => $locations, 'module_types' => $modules]);
            }
        }catch(Exception $e){
            Log::error($e->getMessage());
        }   
    }
}
