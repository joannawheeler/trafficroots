<?php
/*
 * TrafficRoots Adserver
 * @author Cary White
 */

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use Log;
use DB;
use Crypt;
use Redis;
use Cookie;
use App\Zone;
use App\Site;
use App\Ad;
use App\Bid;
use App\DefaultAd;
use App\Creative;
use Illuminate\Http\Request;
use App\Http\Controllers\PixelController;
class AdserverController extends Controller
{
    public $visitor = array();
    public $handle = '';
    public $zone;
    public $ad_id;
    public $creative;
    public $cookie;
    public $campaign;
    public $debug = "Start\n";

    public function __construct()
    {

    }

    public function getIndex(Request $request)
    {
        $cookie = Cookie::get();
        if(isset($cookie['pixel'])){
            $this->visitor = unserialize($cookie['pixel']);
        }else{
            $pixel = new PixelController();
            $this->visitor = $pixel->getUser($request);
            setcookie('pixel',serialize($this->visitor),time() + 86400);
        }
        $this->debug .= print_r($this->visitor,true);   
        $geos = array();
        $geo[] = 'US';
        $geo[] = 'CA';
        if(!in_array($this->visitor['geo'], $geo)) $this->showGeoAd(); 
        $this->handle = $request->handle;
        if(strlen($this->handle)){
            $this->zone = Cache::remember('zone_'.$this->handle, 60, function()
            {
                return Zone::where('handle', $this->handle)->first();
            });
            $this->debug .= "Got Zone\n";
            if($this->zone){
                $ads = Cache::remember('ads_'.$this->handle, 10, function()
                {
                    return Ad::where('zone_handle', $this->handle)->where('status', 1)->orderBy('weight', 'desc')->get();
                });
                $this->debug .= "Got Ads\n";
                if(sizeof($ads)){
                    //we have buyers
                    if(sizeof($ads) == 1){
                        $ad = $ads[0];
                    }else{
                        $ad = $this->runLottery($ads);
                    }
                    if(!$ad->buyer_id){
                        $this->debug .= "No fixed ads, falling to bidding\n";
                        $bid = $this->runBidLottery();
                        $this->debug .= "Bidding Winner is Campaign ".$bid->id."\n";
                        if(is_object($bid)){
                            $this->ad_id = 'BID_'.$bid->id;
                            $this->showBidAd($bid);
                        }else{
                           $this->debug .= "Really?\n"; 
                           $this->showDefaultAd();
                        }
                    }
                    $this->ad_id = 'AD_'.$ad->id;
                    $this->showAd($ad);
                }else{
                   
                   $this->showDefaultAd();
                }
            }    
        }
    }
    public function runBidLottery()
    {
        $bids = Cache::remember('bids_'.$this->handle, 10, function()
        {
            return Bid::where('zone_handle', $this->handle)->where('status', 1)->get();       
        });
        if(sizeof($bids)){
            $this->debug .= sizeof($bids)." Bidder(s) found\n";
            $weights = array();
            $default = 100 / sizeof($bids);
            $cash = 0;
            //participation weight
            foreach($bids as $bid){
                $weights[$bid->id] = $default;
                $cash += $bid->bid;
            }
            $this->debug .= "Cash = $cash\n";
            //contribution weight
            foreach($bids as $bid){
                $weights[$bid->id] += ($bid->bid / $cash) * 100;
            }
            //lottery
            arsort($weights);
            $rand = mt_rand($default,200);
            $this->debug .= "Random number chosen: $rand\n";
            foreach($weights as $key => $value){
                $this->debug .= "Rand = $rand\nValue = $value\n";            
                if($rand <= $value){
                    foreach($bids as $bid){
                        if($bid->id == $key) {$this->debug .= "Returning Bid id ".$bid->id; return $bid;}
                    }
                }
            }
            $this->debug .= "WTF?\n";    
            $this->showDefaultAd();        
         }else{
            $this->showDefaultAd();
        }
    }
    public function runCreativeLottery($creatives)
    {
        $weight = mt_rand(0,100);
        foreach($creatives as $creative){
            if($weight <= $creative->weight) return $creative;       
        }
        return false;
        
    }
    public function runLottery($ads)
    {
        $weight = mt_rand(0,100);
        foreach($ads as $ad){
            if($weight <= $ad->weight) return $ad;       
        }
        return false;
    }
    public function showDefaultAd()
    {
        $this->debug .= "Showing Default Ad\n";
        $ads = Cache::remember('default_ads_'.$this->handle, 10, function(){
             return DefaultAd::where('location_type', $this->zone->location_type)->get();
        });
        die(str_replace("\n","<br />",$this->debug));
        $winner = $ads[mt_rand(0,sizeof($ads)-1)];
        $this->ad_id = 'DEF_'.$winner->id;
        $this->recordDefaultImpression($winner);
        if($winner->folder_id){
            $this->returnIframe($winner->folder_id);
        }else{
            $this->returnDiv($winner->media_id, $winner->link_id);
        } 
        echo "\n\n".str_replace("\n", "<br />",$this->debug); 
    }
    public function returnDiv($media_id, $link_id)
    {
        $out = '<!DOCTYPE html>
<html>
<head>
<style type="text/css">
    body, html {
        margin-left: 0px;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
    }
    a img { border: none; }
</style>
</head>
<body>';
        $out .= '<div title="Advertisement" width="100%" height="100%">';
        $media = DB::select("select * from buyers.media where id = $media_id");
        $link = DB::select("select * from buyers.links where id = $link_id");
        $out .= '<a href="'.$this->prepareLink($link[0]->url).'"><img src="https://buyers.trafficroots.com/'.$media[0]->file_location.'"></a></div>';
        $out .= "<pre>".str_replace("\n","<br />",$this->debug)."</pre>";
        $out .= '</body>
                 </html>';
        die($out); 
    }
    public function returnIframe($folder_id)
    {
        $out = '<!DOCTYPE html>
<html>
<head>
<style type="text/css">
    body, html {
        margin-left: 0px;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
    }
    a img { border: none; }
</style>
</head>
<body>';
        $sql = 'select * from `buyers`.`folders` where id = '.$folder_id;
        //die(''.$sql);
        $folder = DB::select('select * from `buyers`.`folders` where id = '.$folder_id);
        if(!$folder) die('fuck...');
        $iframe = '<iframe frameborder="0" width="100%" height="100%" style="overflow: hidden; position: absolute; allowtransparency="true" style="border:0px; margin:0px;" src="https://buyers.trafficroots.com'
        .$folder[0]->file_location.'"></iframe>';
        $out .= $iframe . "</body>\n</html>";
        die($out);
        die();
    }
    public function showGeoAd()
    {
        // todo: grab backfill ad
    }

    public function showBidAd($bid)
    {
        if(!is_object($bid)) die($this->debug);
        $this->campaign = $bid->campaign_id;
        $creatives = Cache::remember('bid_creatives_'.$bid->id, 10, function()
        {
            return DB::select("SELECT * FROM buyers.creatives WHERE campaign_id = ".$this->campaign
                               ." AND status = 1 ORDER BY weight DESC");
        });
        if(sizeof($creatives)){
            if(sizeof($creatives == 1)){
                $creative = $creatives[0];
            }else{
                $creative = $this->runCreativeLottery($creatives);
            }
            $this->debug .= "Got Creative(s)\n";
            $this->recordImpression($bid,$creative);
            $this->debug .= "Impression Recorded\n";
            $this->recordSale($bid);
            $this->debug .= "Sale recorded\n";
            $this->creative = $creative->id;
            if($creative->folder_id){
                $this->returnIframe($creative->folder_id);
            }else{
                $this->returnDiv($creative->media_id,$creative->link_id);
            }
        }else{
            Log::error('no creatives for bid '.$bid->id);
        }
    }
    public function prepareLink($url)
    {
        $return = "https://publishers.trafficroots.com/click/";
        $clickdata = array();
        $clickdata['url'] = $url;
        $clickdata['zone'] = $this->handle;
        $clickdata['campaign'] = $this->ad_id;
        $clickdata['creative'] = $this->creative;
        $link = Crypt::encrypt(serialize($clickdata));
        $return .= $link;
        $this->debug .= "Destination Link: ".Crypt::decrypt($link);
        return $return;
    }
    public function recordSale($bid)
    {
        $keyname = 'SALE|'.$bid->id.'|'.$bid->bid;
        Redis::sadd('KEYS_SALES', $keyname);
        Redis::incr($keyname);    
    }
    public function showAd($ad)
    {
        $creatives = Cache::remember('creatives_'.$ad->ad_id, 10, function()
        {
            return Creative::where('ad_id', $ad->id)->orderBy('weight', 'desc')->get();
        });
        if(sizeof($creatives)){
            if(sizeof($creatives == 1)){
                $creative = $creatives[0];
            }else{
                $creative = $this->runCreativeLottery($creatives);
            }
        }
        $this->recordImpression($ad,$creative);
        return view('ad',['creative' => $creative, 'ad' => $ad]);
    }
    public function recordImpression($ad, $creative)
    {
        $keyname = 'IMPRESSION|'.date('Y-m-d').'|'.$this->handle.'|'.$this->ad_id.'|'.$creative->id.'|'.serialize($this->visitor);
        Redis::sadd('KEYS_IMPRESSIONS', $keyname);
        Redis::incr($keyname);    
    }
    public function recordDefaultImpression($ad)
    {
        $keyname = 'DEFAULT|'.date('Y-m-d').'|'.$this->handle.'|'.$this->ad_id.'|'.serialize($this->visitor);
        Redis::sadd('KEYS_DEFAULT', $keyname);
        Redis::incr($keyname);
    }
    public function clickedMe(Request $request)
    {
        $cookie = Cookie::get();
        if(isset($cookie['pixel'])){
            $this->visitor = unserialize($cookie['pixel']);
        }else{
            $pixel = new PixelController();
            $this->visitor = $pixel->getUser($request);
        }
        $query = unserialize(Crypt::decrypt($request->querystr));
        $url = $query['url'];
        $ad_id = $query['campaign'];
        $creative = $query['creative'];
        $zone_id = $query['zone'];

        $key = 'CLICK|'.date('Y-m-d').'|'.$ad_id.'|'.$creative.'|'.$zone_id;
        Redis::sadd('KEYS_CLICKS', $key);
        Redis::incr($key);
                
        return redirect($url);
    }
}
