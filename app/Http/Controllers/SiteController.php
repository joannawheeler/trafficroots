<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Log;
use DB;
use App\Site;
use App\Category;

class SiteController extends Controller
{
    public $categories = '';
    public function __construct()
    {
         $this->middleware('auth');
         $cats = Category::all();
         foreach($cats as $cat){
             $this->categories .= "<option value=\"".$cat->id."\">".$cat->category."</option>";
         }
    }
    public function index()
    {
        $user = Auth::user();
        $sites = DB::select('SELECT sites.*, categories.category 
                             FROM sites 
                             JOIN categories 
                             ON sites.site_category = categories.id
                             WHERE sites.user_id = '.$user->id);
        //$sites = Site::where('user_id', $user->id)->get();    
        return view('sites',['user' => $user, 'sites' => $sites, 'categories' => $this->categories]);
    }
    public function postSite(Request $request)
    {
        try{
            $user = Auth::user();
            $data = $request->all();
            $site = new Site();
            $site->site_name = $data['site_name'];
            $site->site_url = $data['site_url'];
            $site->site_category = $data['site_category'];
            $site->user_id = $user->id;
            $site->site_handle = uniqid();
            $site->save();

            return redirect()->action('HomeController@index');
        }catch(Exception $e){
            Log::error($e->getMessage());
        }
    }
    public function getSite($site_id)
    {
        $user = Auth::user();
        $site = Site::where('site_id', $site_id)->get();
        return view('site',['user' => $user, 'site' => $site]);
    }
    public function analyzeSite(Request $request)
    {
        $site_handle = $request->handle;
        $user = Auth::user();
        $site = Site::where('site_handle', $site_handle)->where('user_id', $user->id)->first();
        if(sizeof($site)){
            $geo_table = '<table id="geo_table" width="100%" class="table table-striped table-border table-hover data-table2"><thead><tr><th>Geo</th><th>Country</th><th>Impressions</th></tr></thead><tbody>';
            $sql = "SELECT geo, sum(impressions) as impressions, country_name 
                    FROM site_analysis 
                    JOIN countries ON site_analysis.geo = countries.country_short
                    WHERE site_handle = '".$site_handle."' GROUP BY geo, country_name ORDER BY impressions DESC";
            $result = DB::select($sql);
            if(sizeof($result)){
                foreach($result as $row){
                     $geo_table .= "\n<tr><td>".$row->geo."</td><td>".$row->country_name."</td><td>".$row->impressions."</td></tr>";
                }
            }
            $geo_table .= "</tbody>\n</table>";

            $state_table = '<table id="state_table" width="100%" class="table table-striped table-border table-hover data-table1"><thead><tr><th>State</th><th>Impressions</th></tr></thead><tbody>';
            $sql = "SELECT state, sum(impressions) as impressions FROM site_analysis WHERE site_handle = '".$site_handle."' AND geo = 'US' GROUP BY state ORDER BY impressions DESC";
            $result = DB::select($sql);
            if(sizeof($result)){
                foreach($result as $row){
                     $state_table .= "\n<tr><td>".$row->state."</td><td>".$row->impressions."</td></tr>";
                }
            }
            $state_table .= "</tbody>\n</table>";

            $city_table = '<table id="city_table" width="100%" class="table table-striped table-border table-hover data-table2"><thead><tr><th>City</th><th>State</th><th>Impressions</th></tr></thead><tbody>';
            $sql = "SELECT city, state, sum(impressions) as impressions FROM site_analysis WHERE site_handle = '".$site_handle."' AND geo = 'US' GROUP BY city, state ORDER BY impressions DESC";
            $result = DB::select($sql);
            if(sizeof($result)){
                foreach($result as $row){
                     $city_table .= "\n<tr><td>".$row->city."</td><td>".$row->state."</td><td>".$row->impressions."</td></tr>";
                }
            }
            $city_table .= "</tbody>\n</table>";

            $device_table = '<table id="device_table" width="100%" class="table table-striped table-border table-hover data-table1"><thead><tr><th>Country</th><th>Impressions</th></tr></thead><tbody>';
            $sql = "SELECT platforms.platform, sum(site_analysis.impressions) as impressions 
                    FROM site_analysis 
                    JOIN platforms ON site_analysis.device = platforms.id 
                    WHERE site_handle = '".$site_handle."' GROUP BY platform ORDER BY impressions DESC";
            $result = DB::select($sql);
            if(sizeof($result)){
                foreach($result as $row){
                     $device_table .= "\n<tr><td>".$row->platform."</td><td>".$row->impressions."</td></tr>";
                }
            }
            $device_table .= "</tbody>\n</table>";

            $browser_table = '<table id="browser_table" width="100%" class="table table-striped table-border table-hover data-table1"><thead><tr><th>Browser</th><th>Impressions</th></tr></thead><tbody>';
            $sql = "SELECT browsers.browser, sum(site_analysis.impressions) as impressions 
                    FROM site_analysis 
                    JOIN browsers ON site_analysis.browser = browsers.id
                    WHERE site_handle = '".$site_handle."' GROUP BY browser ORDER BY impressions DESC";
            $result = DB::select($sql);
            if(sizeof($result)){
                foreach($result as $row){
                     $browser_table .= "\n<tr><td>".$row->browser."</td><td>".$row->impressions."</td></tr>";
                }
            }
            $browser_table .= "</tbody>\n</table>";

            $os_table = '<table id="os_table" width="100%" class="table table-striped table-border table-hover data-table1"><thead><tr><th>Operating System</th><th>Impressions</th></tr></thead><tbody>';
            $sql = "SELECT operating_systems.os, sum(site_analysis.impressions) as impressions 
                    FROM site_analysis
                    JOIN operating_systems ON site_analysis.os = operating_systems.id 
                    WHERE site_handle = '".$site_handle."' GROUP BY os ORDER BY impressions DESC";
            $result = DB::select($sql);
            if(sizeof($result)){
                foreach($result as $row){
                     $os_table .= "\n<tr><td>".$row->os."</td><td>".$row->impressions."</td></tr>";
                }
            }
            $os_table .= "</tbody>\n</table>";

            return view('analysis', ['site' => $site, 'geo_table' => $geo_table, 'state_table' => $state_table, 'city_table' => $city_table, 'device_table' => $device_table, 'browser_table' => $browser_table, 'os_table' => $os_table]);

        }
    }

}
