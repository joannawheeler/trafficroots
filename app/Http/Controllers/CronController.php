<?php
/**
 * Automation Controller for Trafficroots Adserver Operation
 * @author Cary White
 * 2017
 */
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use Log;
use DB;
use Crypt;
use Cookie;
use App\Zone;
use App\Category;
use App\Site;
use App\Ad;
use App\Bid;
use App\BidCreative;
use App\DefaultAd;
use App\Creative;
use Illuminate\Http\Request;
use App\Http\Controllers\PixelController;

class CronController extends Controller
{
    
    public function __construct()
    {
        //initialize whatever here
    }


    public function bidRoller()
    {
        Log::info("Bid Roller Running");
        $this->activatePending();
        //function to match zones to active campaigns
        $pairs = array();
        $zones = Zone::where('status', 1)->get();
        foreach($zones as $zone){
            //Log::info("Checking zone ".$zone->handle);
            /* make sure there is at least a bid Ad record for this zone */
            $ad = DB::select('select * from ads where zone_handle = ?', array($zone->handle));
            if(!sizeof($ad)) {
                $data['zone_handle'] = $zone->handle;
                $data['location_type'] = $zone->location_type;
                $data['weight'] = 100;
                $data['status'] = 1;
                $data['created_at'] = DB::raw('NOW()');
                DB::table('ads')->insert($data);
            }
            /* get allowed categories for this site */
            $categories = DB::select('select category from site_category where site_id = '.$zone->site_id);
            $allowed = array();
            
            if(sizeof($categories)){
            foreach($categories as $cat){
                $allowed[] = $cat->category;
            }
            $in = implode($allowed, ",")."\n";
   
            /* get all active campaigns for this location type and among the allowed categories */
            $sql = "select *
                    from campaigns
                    join campaign_targets
                    on campaigns.id = campaign_targets.campaign_id
                    where status = 1
                    and location_type = ".$zone->location_type."
                    and campaign_category in ($in)";
            //Log::info($sql);
            $campaigns = DB::select($sql);
            
             
            foreach($campaigns as $camp){
                $pairs[] = "('"
                           .$zone->handle."',"
                           .$zone->location_type.",5,"
                           .$camp->user_id.","
                           .$camp->id.","
                           .$camp->bid.",'"
                           .$camp->geos."','"
                           .$camp->states."','"
                           .$camp->cities."',"
                           .$camp->campaign_category.",'"
                           .$camp->platforms."','"
                           .$camp->operating_systems."','"
                           .$camp->browsers."','"
                           .$camp->keywords."',NOW(),NOW())";
                 
            }
            }else{
                Log::info("No Categories found for zone ".$zone->handle);
                foreach(Category::all() as $category){
                    $insert = array('site_id' => $zone->site_id, 'category' => $category->id);
                    DB::table('site_category')->insert($insert);         
                }
                Log::info("Allowed Categories Created for Site ".$zone->site_id);
            }
        }
        if(sizeof($pairs)){
        $prefix = "INSERT INTO bids (zone_handle,location_type,status,buyer_id,campaign_id,bid,country_id,state_id,city_id,category_id,device_id,os_id,browser_id,keywords,created_at,updated_at) VALUES";
        $suffix = " ON DUPLICATE KEY UPDATE 
                    bid = VALUES(`bid`), 
                    country_id = VALUES(`country_id`), 
                    state_id = VALUES(`state_id`), 
                    city_id = VALUES(`city_id`), 
                    category_id = VALUES(`category_id`),
                    device_id = VALUES(`device_id`),
                    os_id = VALUES(`os_id`),
                    browser_id = VALUES(`browser_id`),
                    keywords = VALUES(`keywords`),
                    updated_at = NOW();";
        $result = DB::insert($prefix.implode($pairs,",").$suffix);           
        if(!$result){
            Log::error(DB::error());
        } else {
            Log::info("Bid Roller Complete!");
        }
        }
    }
    
    /* activate any pending bids after 36 hours */
    public function activatePending()
    {
        $mydate = date('Y-m-d H:i:s',strtotime("-36 hours"));
        $sql = "SELECT `bids`.* 
                FROM `bids`
                JOIN `campaigns`
                ON `bids`.`campaign_id` = `campaigns`.`id`
                WHERE `campaigns`.`status` = ?  
                AND `bids`.`status` = ?
                AND `bids`.`created_at` < ?;";
        $result = DB::select($sql, array(1, 5, $mydate));
        if(sizeof($result)){
            Log::info(sizeof($result).' Pending Bids to Activate');
            foreach($result as $row){
                $sql = 'UPDATE `bids` SET `status` = ? WHERE `id` = ?';
                DB::update($sql, array(1, $row->id));
                $info = 'Campaign '.$row->campaign_id.' Activated on Zone '.$row->zone_handle;
                Log::info($info);                
            }
        }else{
            Log::info('No Pending Bids to Activate.');
        }
    }
}
