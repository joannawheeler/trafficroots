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
        //function to match zones to active campaigns
        $pairs = array();
        $zones = Zone::where('status', 1)->get();
        foreach($zones as $zone){
            Log::info("Checking zone ".$zone->handle);
            $categories = DB::select('select category from site_category where site_id = '.$zone->site_id);
            $allowed = array();
            if(sizeof($categories)){
            foreach($categories as $cat){
                $allowed[] = $cat->category;
            }
            $in = implode($allowed, ",")."\n";
            $sql = "select *
                                     from campaigns
                                     join campaign_targets
                                     on campaigns.id = campaign_targets.campaign_id
                                     where status = 1
                                     and location_type = ".$zone->location_type."
                                     and campaign_category in ($in)";
            Log::info($sql);
            $campaigns = DB::select($sql);
            
            foreach($campaigns as $camp){
                $pairs[] = "(NULL,'"
                           .$zone->handle."',"
                           .$zone->location_type.",1,"
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
            }
        }
        if(sizeof($pairs)){
        $prefix = "INSERT INTO bids (id,zone_handle,location_type,status,buyer_id,campaign_id,bid,country_id,state_id,city_id,category_id,device_id,os_id,browser_id,keywords,created_at,updated_at) VALUES";
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
            echo DB::error();
        } else {
            echo "Complete!\n";
        }
        }
    }
}
