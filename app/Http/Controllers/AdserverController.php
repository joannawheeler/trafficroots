<?php
/*
 * TrafficRoots Adserver
 * @author Cary White
 */

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use Log;
use DB;
use App\Zone;
use App\Site;
use App\Ad;
use App\DefaultAd;
use App\Creative;
use Illuminate\Http\Request;
use App\Http\Controllers\PixelController;
class AdserverController extends Controller
{
    public $visitor = array();
    public $handle = '';
    public $zone;

    public function __construct()
    {

    }

    public function getIndex(Request $request)
    {
        $pixel = new PixelController();
        $this->visitor = $pixel->getUser($request);   
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
            if($this->zone){
                $ads = Cache::remember('ads_'.$this->handle, 10, function()
                {
                    return Ad::where('zone_handle', $this->handle)->where('status', 1)->orderBy('weight', 'desc')->get();
                });
                if(sizeof($ads)){
                    //we have buyers
                    if(sizeof($ads) == 1){
                        $ad = $ads[0];
                    }else{
                        $ad = $this->runLottery($ads);
                    }
                    if($ad->bid){
                        $bid = $this->runBidLottery();
                        $this->showBidAd($bid);
                    }
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
            return Bids::where('handle', $this->handle)->where('status', 1)->get();       
        });
        if($bids){
            $weights = array();
            $default = 100 / sizeof($bids);
            $cash = 0;
            //participation weight
            foreach($bids as $bid){
                $weights[$bid->id] = $default;
                $cash += $bid->bid;
            }

            //contribution weight
            foreach($bids as $bid){
                $weights[$bid->id] += ($bid->bid / $cash) * 100;
            }
            //lottery
            arsort($weights);
            $rand = mt_rand(0,200);
            foreach($weights as $key => $value){
                if($rand <= $value){
                    foreach($bids as $bid){
                        if($bid->id == $value) return $bid;
                    }
                }
            }    
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
        $ads = Cache::remember('default_ads_'.$this->handle, 10, function(){
             return DefaultAd::where('location_type', $this->zone->location_type)->get();
        });
        $winner = $ads[mt_rand(0,sizeof($ads)-1)];
        $this->recordDefaultImpression($winner);
        if($winner->folder_id){
            $this->returnIframe($winner->folder_id);
        }else{
            $this->returnDiv($winner->media_id, $winner->link_id);
        } 
  
    }
    public function returnIframe($folder_id)
    {
        $sql = 'select * from `buyers`.`folders` where id = '.$folder_id;
        //die(''.$sql);
        $folder = DB::select('select * from `buyers`.`folders` where id = '.$folder_id);
        if(!$folder) die('fuck...');
        $iframe = '<iframe frameborder="0" width="100%" height="100%" style="overflow: hidden; position: absolute;" src="https://buyers.trafficroots.com'
                  .$folder[0]->file_location.'"></iframe>';
        echo $iframe;

    }
    public function showGeoAd()
    {
        // todo: grab backfill ad
    }

    public function showBidAd($bid)
    {
        $creatives = Cache::remember('bid_creatives_'.$bid->id, 10, function()
        {
            return BidCreative::where('bid_id', $bid->id)->orderBy('weight', 'desc')->get();
        });
        if(sizeof($creatives)){
            if(sizeof($creatives == 1)){
                $creative = $creatives[0];
            }else{
                $creative = $this->runCreativeLottery($creatives);
            }
        }
        $this->recordImpression($ad,$creative);
        $this->recordSale($bid);
        return view('ad',['creative' => $creative, 'ad' => $ad]);
    }
    public function recordSale($bid)
    {
        $keyname = 'SALE|'.$bid->id.'|'.$bid->bid;
        Cache::increment($keyname);
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
        $keyname = 'IMPRESSION|'.date('Y-m-d').'|'.$this->handle.'|'.$ad->id.'|'.$creative->id.'|'.serialize($this->visitor);
        Cache::increment($keyname);
    }
    public function recordDefaultImpression($ad)
    {
        $keyname = 'DEFAULT|'.date('Y-m-d').'|'.$this->handle.'|'.$ad->id.'|'.serialize($this->visitor);
        Cache::increment($keyname);
    }
}
