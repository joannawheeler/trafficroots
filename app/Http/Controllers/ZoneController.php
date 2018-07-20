<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ad;
use App\AdCreative;
use App\Site;
use App\Zone;
use App\Media;
use App\Links;
use App\ModuleType;
use App\LocationType;
use App\PublisherBooking;
use App\Country;
use App\Browser;
use App\OperatingSystem;
use App\City;
use App\State;
use App\Platform;
use DB;
use Log;
use Auth;
use Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\ZoneCreated;



class ZoneController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }
    public function getCustomAd(Request $request)
    {
        $handle = $request->handle;
        $user = Auth::getUser();
        $zone = Zone::where('handle', $handle)->where('pub_id', $user->id)->first();
	if(!$zone) return redirect('/sites');
	Log::info('Zone Id is '.$zone->id);
        Log::info('Zone Site Id is '.$zone->site_id);

	$site = Site::where('id', $zone->site_id)->first();
        	
	$ads = Ad::where('zone_handle', $handle)->where('status', 1)->get();
	$weight = $rtb_weight = 0;
	foreach($ads as $ad){
		if($ad->buyer_id == 0){
			$rtb_weight = $ad->weight;
		} elseif ($ad->fixed == 1) {
			$weight  += $ad->weight;
		} 
	}
	$check = 75 - $weight;
	if($check){
		$available = $check;
	} else {
		$available = 0;
	}

        $countries = '<option value="0" selected>All Countries</option><option value="840">US - United States of America</option><option value="124">CA - Canada</option>';
        $nations = Country::all();
        foreach($nations as $nation){
	    $countries .= '<option value="'.$nation->id.'">'.$nation->country_short.' - '.$nation->country_name.'</option>';
        }

	$states = '<option value="0" selected>All States</option>';
	$result = State::where('country_id', 840)->get();
        foreach($result as $row){
	    $states .= '<option value="'.$row->id.'">'.State::find($row->id)->country_name['country_name'].' - '.$row->state_name.'</option>';
	}
	$result = State::where('country_id', '<>', 840)->orderby('country_id')->orderby('state_name')->get();
        foreach($result as $row){
	    $states .= '<option value="'.$row->id.'">'.State::find($row->id)->country_name['country_name'].' - '.$row->state_name.'</option>';
	}	
        $counties = '<option value="0" selected>All Counties</option>'; 
        $systems = OperatingSystem::all();
        $operating_systems = '<option value="0" selected>All Operating Systems</option>';
        foreach($systems as $row){
            $operating_systems .= '<option value="'.$row->id.'">'.$row->os.'</option>';
        }
        
        $browsers = Browser::all();
        $browser_targets = '<option value="0" selected>All Browsers</option>';
        foreach($browsers as $row){
            $browser_targets .= '<option value="'.$row->id.'">'.$row->browser.'</option>';
        }

        $platforms = Platform::all();
        $platform_targets = '<option value="0" selected>All Platforms</option>';
        foreach($platforms as $row){
            $platform_targets .= '<option value="'.$row->id.'">'.$row->platform.'</option>';
	}
	$user = Auth::getUser();
	return view('custom_ad', ['user' => $user,
		'zone' => $zone,
		'site' => $site,
				       'available' => $available,
		                       'countries' => $countries,
                                       'browsers' => $browsers,
                                       'platforms' => $platforms,
                                       'operating_systems' => $operating_systems,
                                       'states' => $states,
                                       'countries' => $countries,
                                       'platforms' => $platform_targets,
                                       'browser_targets' => $browser_targets,
				       'os_targets' => $operating_systems,
				       'counties' => $counties,
                                       'states' => $states]);
    }
    public function pauseCustomAd(Request $request)
    {
         // pause ad and throw its weight back to the RTB
	 $user = Auth::getUser();
         if(!$user->allow_folders) return 'Not Authorized';;
	 $input = $request->all();
         $ad = DB::table('ads')->where('id', $request->id)->first();
	 if($ad->buyer_id != $user->id) return redirect('/');

	 $default = DB::table('ads')->where('zone_handle', $ad->zone_handle)->where('buyer_id', 0)->first();
	 if(!$default) return redirect('/');
	 DB::table('ads')->where('id', $ad->id)->update(array('status' => 3));
	 $new_weight = $ad->weight + $default->weight;
	 if($new_weight > 100) {
             $new_weight = 100;
             Log::error('Weight had to be corrected');
	 }
	 DB::table('ads')->where('id', $default->id)->update(array('weight' => $new_weight));
	 Log::info('User '.$user->name.' paused Ad '.$ad->id.' on zone '.$ad->zone_handle);
	 return redirect('/zone_manage/'.$ad->zone_handle)->with('alert-info', 'Custom Ad Paused Successfully!');

    }
    public function resumeCustomAd(Request $request)
    {
         // pause ad and throw its weight back to the RTB
	 $user = Auth::getUser();
         if(!$user->allow_folders) return 'Not Authorized';;
	 $input = $request->all();
         $ad = DB::table('ads')->where('id', $request->id)->first();
	 if($ad->buyer_id != $user->id) return redirect('/');

	 $default = DB::table('ads')->where('zone_handle', $ad->zone_handle)->where('buyer_id', 0)->first();
	 if(!$default) return redirect('/');
	 $new_weight = $default->weight - $ad->weight;
	 if($new_weight < 0) {
             $new_weight = 0;
             Log::error('Weight had to be corrected');
	 }

	 DB::table('ads')->where('id', $ad->id)->update(array('status' => 1));
	 DB::table('ads')->where('id', $default->id)->update(array('weight' => $new_weight));
	 Log::info('User '.$user->name.' resumed Ad '.$ad->id.' on zone '.$ad->zone_handle);
	 return redirect('/zone_manage/'.$ad->zone_handle)->with('alert-info', 'Custom Ad Resumed Successfully');

    }
    public function postCustomAd(Request $request)
    {    try{
            $user = Auth::getUser();
            if(!$user->allow_folders) return 'Not Authorized';;
	    $input = $request->all();
	    $new_ad = array();
	    $new_ad['description'] = $input['campaign_name'];
	    $new_ad['zone_handle'] = $input['handle'];
            $new_ad['location_type'] = $input['location_type'];
            $new_ad['buyer_id'] = $user->id;

	    if(date('Y-m-d',strtotime($input['daterange_start'])) > date('Y-m-d')){
		    $new_ad['status'] = 5;
            }else{
		    $new_ad['status'] = 1;
	    }
	    $new_ad['start_date'] = date('Y-m-d',strtotime($input['daterange_start']));
	    $new_ad['end_date'] = strlen($input['daterange_end']) ? date('Y-m-d',strtotime($input['daterange_end'])) : null;
	    if($new_ad['end_date'] && $new_ad['end_date'] < $new_ad['start_date']){
                return json_encode(array('result' => 'Invalid End Date - cannot be before Start Date'));
            }

	    $creatives = array();

	    foreach($input as $key => $value){
		    if(strpos($key, 'creative') === 0) {
			    Log::info("$key = $value");
			    $creatives[] = $value;
		    }
	    }
	    if(!sizeof($creatives)) return ('Looks like there are no creatives defined for your ad');
	    $zone = Zone::where('handle', $request->handle)->where('pub_id', $user->id)->first();
            if($zone->site_id){
		    $sql = 'select * from ads where zone_handle = ? and buyer_id = 0';
		    $rtb = DB::select($sql, array($request->handle));
		    $available = $rtb[0]->weight;
		    if($available - $request->campaign_weight){
			    if($new_ad['status'] == 1) DB::table('ads')->where('zone_handle', $request->handle)->where('buyer_id', 0)->update(array('weight' => ($available - $request->campaign_weight)));
                            $new_ad['weight'] = $request->campaign_weight;
		    }else{
                            $new_ad['weight'] = round($available / 2);
		    }
								
		    $data = $this->createTargets($request);
		    $insert_array = array_merge($new_ad, $data);
                    $insert_array['created_at'] = date('Y-m-d H:i:s');
		    $ad = new Ad();
		    $ad->fill($insert_array);
		    $ad->save();
		    $ad_id = $ad->id;
		    if($ad_id){
				
				DB::table('ads')->where('id', $ad_id)->update(array('fixed' => $request->distributeWeight));
				$this->balanceAds($request->handle);
			    foreach($creatives as $key => $creative){
		            $new_creative = array();
                            $stuff = explode('|', $creative);
			    /* create media */
                            $ins = array();
			    $ins['user_id'] = $user->id;
			    $ins['location_type'] = $input['location_type'];
			    $ins['media_name'] = $stuff[0].'_'.$key;
			    $ins['category'] = 0;
			    $ins['file_location'] = $stuff[1];
			    $ins['created_at'] = date('Y-m-d H:i:s');
			    $ins['status'] = 1;
			    $media = new Media();
			    $media->fill($ins);
			    $media->save();
			    $media_id = $media->id;

			    /* create link */
                            $ins = array();
			    $ins['user_id'] = $user->id;
			    $ins['link_name'] = $stuff[0].'_'.$key;
			    $ins['category'] = 0;
			    $ins['url'] = $stuff[2];
			    $ins['created_at'] = date('Y-m-d H:i:s');
			    $ins['status'] = 1;
			    $link = new Links();
			    $link->fill($ins);
			    $link->save();
			    $link_id = $link->id;
				}
			    /* make creative */
				$ins = array();
			    $ins['ad_id'] = $ad_id;
				$ins['description'] = $stuff[0];
			    $ins['weight'] = 0;
			    $ins['media_id'] = $media_id;
			    $ins['link_id'] = $link_id;
			    $ins['status'] = 1;
			    $ins['created_at'] = date('Y-m-d H:i:s');
			    $creative = new AdCreative();
			    $creative->fill($ins);
			    $creative->save();
				$this->balanceCreatives($creative->ad_id);
		    }
		    return json_encode(array('result' => 'OK'));
            }else{
		    return redirect('/sites');
	    }
          }catch(Throwable $t){
            return $t->getMessage();
          }
    }
	
	public function createTargets(Request $request)
    {
        try {
	    $data = array();
	    if(is_array($request->countries)){
		$data['country_id'] = implode("|",$request->countries);
	    }else{
		$data['country_id'] = ''.$request->countries;
            }
            if (is_array($request->states)) {
                $data['state_id'] = implode("|", $request->states);
            } else {
                $data['state_id'] = ''.intval($request->states);
            }
            if (is_array($request->counties)) {
                $data['county_id'] = implode("|", $request->counties);
            } else {
                $data['county_id'] = ''.intval($request->counties);
            }
	    if (is_array($request->platform_targets)) {
                $data['device_id'] = implode("|", $request->platform_targets);
            } else {
                $data['device_id'] = ''.$request->platform_targets;
            }
            if (is_array($request->operating_systems)) {
                $data['os_id'] = implode("|", $request->operating_systems);
            } else {
                $data['os_id'] = ''.$request->operating_systems;
            }
            if (is_array($request->browser_targets)) {
                $data['browser_id'] = implode("|", $request->browser_targets);
            } else {
                $data['browser_id'] = ''.$request->browser_targets;
            }
            if (strlen(trim($request->keyword_targets))) {
                $data['keywords'] = str_replace(",", "|", $request->keyword_targets);
            } else {
                $data['keywords'] = '';
            }

            foreach ($data as $key => $value) {
                if (is_null($value)) {
                    $data[$key] = '0';
                }
	    }
	    if(isset($request->frequency_capping)) $data['frequency_capping'] = intval($request->frequency_capping);
            return $data;
        } catch (Exception $e) {
            return ($e->getMessage);
        }
    }

	
   	public function updateTargets(Request $request)
    {
        try {
			$user = Auth::getUser();
			$data = array();
			if(is_array($request->countries)){
			$data['country_id'] = implode("|",$request->countries);
			}else{
			$data['country_id'] = ''.$request->countries;
            }
            if (is_array($request->states)) {
                $data['state_id'] = implode("|", $request->states);
            } else {
                $data['state_id'] = ''.intval($request->states);
            }
            if (is_array($request->counties)) {
                $data['county_id'] = implode("|", $request->counties);
            } else {
                $data['county_id'] = ''.intval($request->counties);
            }
	    if (is_array($request->platform_targets)) {
                $data['device_id'] = implode("|", $request->platform_targets);
            } else {
                $data['device_id'] = ''.$request->platform_targets;
            }
            if (is_array($request->operating_systems)) {
                $data['os_id'] = implode("|", $request->operating_systems);
            } else {
                $data['os_id'] = ''.$request->operating_systems;
            }
            if (is_array($request->browser_targets)) {
                $data['browser_id'] = implode("|", $request->browser_targets);
            } else {
                $data['browser_id'] = ''.$request->browser_targets;
            }
            if (strlen(trim($request->keyword_targets))) {
                $data['keywords'] = str_replace(",", "|", $request->keyword_targets);
            } else {
                $data['keywords'] = '';
            }
            foreach ($data as $key => $value) {
                if (is_null($value)) {
                    $data[$key] = '0';
                }
	    	}		
			if(isset($request->frequency_capping)) $data['frequency_capping'] = intval($request->frequency_capping);
           	if(DB::table('ads')->where('id', $request->ad_id)->update($data))
           	Log::info($user->name.' updated targets on Ad Campaign '.$request->ad_id);
           	Log::info(print_r($data, true));
            return('All Changes Saved');
		} catch (Exception $e) {
			return ($e->getMessage);
		}
    }
	
	public function updateCounties(Request $request)
    {
		try{
            $this->updateTargets($request);
			$CUtil = new CUtil();
			$output = $CUtil->getCounties($request->ad_id, 1);
            return($output);
		}catch(Throwable $t){
            Log::error($t->getMessage());
		}
    }
	
    public function manageZone(Request $request)
    {
	    if(strlen($request->handle)){
            $user = Auth::getUser();
            $ads = Ad::where('zone_handle', $request->handle)->get();
	    $zone = Zone::where('handle', $request->handle)->where('pub_id', $user->id)->first();
	    $site = Site::where('id', $zone->site_id)->first();
            $countries = '<option value="0" selected>All Countries</option><option value="840">US - United States of America</option><option value="124">CA - Canada</option>';
            $nations = Country::all();
            foreach($nations as $nation){
		$countries .= '<option value="'.$nation->id.'">'.$nation->country_short.' - '.$nation->country_name.'</option>';
	    }
            $platforms = Platform::all();
	    $platform_targets = '<option value="0" selected>All Platforms</option>';
	    foreach($platforms as $row){
               $platform_targets .= '<option value="'.$row->id.'">'.$row->platform.'</option>';
	    }
	    if($zone){
	       return view('zone_manage', array('ads' => $ads, 'zone' => $zone, 'site' => $site, 'countries' => $countries, 'devices' => $platform_targets));
	    }else{
	       return redirect('/sites');
	    }
        }
    }
     public function getZones($site_id)
	 {
		 $user = Auth::getUser();
		 if ($user->user_type == 99) {
			 $site = Site::where('id', $site_id)->first();
		 } else {
			 $site = Site::where('id', $site_id)->where('user_id', $user->id)->first();
		 }
		 if (!sizeof($site)) {
			 $msg = 'Invalid Site';
			 return ($msg);
		 } else {
			 $sql = "SELECT DISTINCT(stat_date) FROM site_analysis WHERE site_handle = '".$site->site_handle."'";
			 $result = DB::select($sql);
			 if (sizeof($result) < 3) {
				 $msg = '<div><p>For all new sites, 72 hours of traffic analysis is required before Zone Creation can be activated.</p><br /><p>Please insert the following image tag on your site`s main index page.  When sufficient data has been gathered, your site can be added to our inventory and you will be able to create zones!</p><br />This code will show a transparent 1x1 GIF image.<br /><br /><code>'.htmlspecialchars('<img alt="Trafficroots Analysis Pixel" src="'.env('APP_URL', 'http://localhost').'/pixel/'.$site->site_handle.'" style="display:none;">');
				 $msg .= '</code><br /><br /><a href="/analysis/'.$site->site_handle.'"><button type="button" class="btn-u">View Site Analysis Data</button></a></div>';
				 $msg = $site->site_name .'|'.$msg;
				 return $msg;
			 } else {
				 $msg = '<div><h3>Your Trafficroots Analysis Pixel</h3><code>'.htmlspecialchars('<img alt="Trafficroots Analysis Pixel" src="'.env('APP_URL', 'http://localhost').'/pixel/'.$site->site_handle.'" style="display:none;">');
				 $msg .= '</code><br /><br /><a href="/analysis/'.$site->site_handle.'"><button type="button" class="btn-u">View Site Analysis Data</button></a><br /><br />';
				 $zones = Zone::where('site_id', $site_id)
					 ->join('location_types', 'zones.location_type', '=', 'location_types.id')
					 ->select('zones.id', 'zones.handle', 'zones.description', 'zones.status', 'zones.location_type', 'location_types.description as location', 'location_types.width', 'location_types.height')
					 ->get();
				 if (sizeof($zones)) {
					 $msg .= '<table class="table table-hover table-border table-striped table-condensed" width="100%" id="zones_table"><thead><tr><th>Zone ID</th><th>Description</th><th>Width</th><th>Height</th><th>Location</th><th>Stats</th></thead><tbody>';
					 foreach ($zones as $zone) {
						 $msg .= '<tr><td>'.$zone->id.'</td><td>'.$zone->description.'</td><td>'.$zone->width.'</td><td>'.$zone->height.'</td><td>'.$zone->location.'</td><td><a href="/zonestats/'.$zone->id.'"><i class="fa fa-bar-chart zone-stat" aria-hidden="true"></i></a></td><tr>';
						 $msg .= '</table>';
						 $msg .= '<br /><br /><a href="/addzone/'.$site_id.'"><button type="button" class="btn-u">Create A Zone on '.$site->site_name.'</button></a></div>';
						 $msg = $site->site_name .'|'.$msg;
						 return($msg);
					 }
				 } else {
					 $msg .= '<h4>No Zones Defined on '.$site->site_name.'</h4>';
					 $msg .= '<br /><br /><a href="/addzone/'.$site_id.'"><button type="button" class="btn-u">Create A Zone on '.$site->site_name.'</button></a></div>';
					 $msg = $site->site_name .'|'.$msg;
					 return($msg);
				 }
			 }
		 }
	 }
	
    private function insertFirstAd($handle, $location_type)
    {
        try {
            $ad = new Ad();
	    $data = array();
	    $data['description'] = 'Default Ad';
            $data['zone_handle'] = $handle;
            $data['location_type'] = $location_type;
            $data['weight'] = 100;
            $data['status'] = 1;
            $ad->fill($data);
            $ad->save();
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
    private function insertPublisherBooking($handle)
    {
        try {
            $zone = Zone::where('handle', $handle)->first();
            $booking = new PublisherBooking();
            $data = array();
            $data['zone_id'] = $zone->id;
            $data['site_id'] = $zone->site_id;
            $data['pub_id'] = $zone->pub_id;
            $data['start_date'] = date('Y-m-d');
            $data['end_date'] = date('Y-m-d', strtotime('last day of this month'));
            $booking->fill($data);
            $booking->save();
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
    public function dstore(Request $request)
    {
        try {
            $user = Auth::getUser();
            $data = $request->all();
            $site = Site::where('id', $data['site_id'])->
                          where('user_id', $user->id)->
                          first();
            if (sizeof($site)) {
                $zone = new Zone();
                $data['handle'] = bin2hex(random_bytes(5));
                $data['pub_id'] = $user->id;
                $zone->fill($data);
                $zone->save();
                $this->insertFirstAd($data['handle'], $data['location_type']);
                $this->insertPublisherBooking($data['handle']);
                Session::flash('status', 'Zone Creation was Successful');
                return redirect()->action('HomeController@index');
            } else {
                Log::error('zone creation failed - invalid site');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function store(Site $site, Request $request)
    {
        $this->validate($request, [
            'description' => [
                'required',
                'max:128',
                Rule::unique('zones')
                    ->where('pub_id', Auth::user()->id)
                    ->where('site_id', $site->id)
            ],
            'location_type' => 'required|exists:location_types,id'
        ]);
        $site->addZone($request->description, $request->location_type);
        session()->flash('status', [
            'type' => 'success',
            'message' => 'Zone added successfully'
        ]);
        /* below line of code fails */
        //Mail::to(Auth::user()->email)->send(new ZoneCreated());
        return;
    }

    public function edit(Zone $zone, Request $request)
    {
        $this->validate($request, [
            'description' => [
                'required',
                'max:128',
                Rule::unique('zones')
                    ->ignore($zone->id)
                    ->where('pub_id', Auth::user()->id)
                    ->where('site_id', $zone->site_id)
            ]        
        ]);
        $zone->description = $request->description;
        $zone->save();
        session()->flash('status', [
            'type' => 'success',
            'message' => 'Zone updated successfully'
        ]);
        return;
    }
	
	public function editCustomAd(Request $request)
    {
		$user = Auth::getUser();
		$CUtil = new CUtil();

		$ads = DB::select('select * from ads where id = '.$request->id);
		
        if ($ads) {
			$category = $CUtil->getCategories();
            $status_types = $CUtil->getStatusTypes();
            $location = $CUtil->getLocationTypes();
			
			foreach ($ads as $camp) {
				$availableWeight = Ad::where('zone_handle', $camp->zone_handle)->where('status', 1)->get();
				$weight = $rtb_weight = 0;
				foreach($availableWeight as $ad_weight){
					if($ad_weight->buyer_id == 0){
						$rtb_weight = $ad_weight->weight;
					} elseif ($ad_weight->fixed == 1) {
						$weight  += $ad_weight->weight;
					} 
				}
				$check = 75 - $weight;
				if($check){
					$available = $check;
				} else {
					$available = 0;
				}
				
				$countries = $CUtil->getCountries($camp->id, 1);
                $states = $CUtil->getStates($camp->id, 1);
                $os_targets = $CUtil->getOperatingSystems($camp->id, 1);
                $platforms = $CUtil->getPlatforms($camp->id, 1);
				$browser_targets = $CUtil->getBrowsers($camp->id, 1);
				$counties = $CUtil->getCounties($camp->id, 1);
				$creatives = AdCreative::where('ad_id', $camp->id)->get();
                if (!$creatives) {
                    $creatives = array();
                }
				$row = $camp->keywords;
			}
		
			$frequencyCapping = '<option value="0">Disabled</option><option value="1">1 Impression Per 24 Hours</option><option value="2">2 Impressions Per 24 Hours</option><option value="3">3 Impressions Per 24 Hours</option><option value="4">4 Impressions Per 24 Hours</option><option value="5">5 Impressions Per 24 Hours</option>';

			return view('zone_manage_customAd', [
						'ad' => $camp,
						'frequencyCapping' => $frequencyCapping,
						'location_types' => $location,
						'status_types' => $status_types,
						'countries' => $countries,
						'states' => $states,
						'os_targets' => $os_targets,
						'browser_targets' => $browser_targets,
						'platforms' => $platforms,
						'keywords' => str_replace("|", ",", $row),
						'counties' => $counties,
						'creatives' => $creatives,
						'available_weight' => $available
			]);
		}
    }
	
	public function updateWeight(Request $request)
    {
        try{
			$ads = Ad::find($request->ad_id);
            if($ads){
				if ($request->distributeWeight == 1) {
					$ads->weight = $request->weight;
				}
				$ads->fixed = $request->distributeWeight;
				$ads->save();
				$this->balanceAds($request->handle);
				return('Weight has been updated.');
			}else{
                /* bid evaluates to false - invalid */
                return('Invalid Weight');
			}
         }catch(Exception $e){
                return $e->getMessage();
 	 	} 
    }
	
	private function balanceAds($handle)
    {
		$ads = Ad::where('zone_handle', $handle)->where('status', 1)->get();
		$weight = $auto_weight = $rtb_weight = 0;
		$available = 75; 
		foreach($ads as $ad){
			if($ad->fixed == 1) {
				$weight += $ad->weight;
			} 
		}

		if ($weight) {
			$available = 75-$weight;
		}

		$count = Ad::where('zone_handle', $handle)
				->where('buyer_id', '!=', 0)
				->where('fixed', 0)
				->count();
		if ($count) {
			$weight = ($available / $count);
			$sql = "UPDATE ads SET weight = ? WHERE zone_handle = ? and buyer_id != 0 and fixed = 0";
			Log::info($sql);
			DB::update($sql, array($weight, $handle));

			$sql = "UPDATE ads SET weight = ? WHERE zone_handle = ? and buyer_id = 0";
			Log::info($sql);
			DB::update($sql, array(25, $handle));
		} else {
			$weight = 100-$weight;
			$sql = "UPDATE ads SET weight = ? WHERE zone_handle = ? and buyer_id = 0";
			Log::info($sql);
			DB::update($sql, array($weight, $handle));
		}
		return true;
    }

	public function updateImpressionCap(Request $request)
    {
	$user = Auth::getUser();
        try{
            $impression_cap = (float)($request->impression_cap);
            if($impression_cap){
                $ad = intval($request->ad_id);
				Ad::where('id', $ad)->update(array('impression_cap' => $impression_cap));
				Log::info($user->name.' Updated Impression Capping for Custom Ad '.$request->ad_id.' to $'.$impression_cap);
                return('Impression Capping has been updated');
            }else{
                /* bid evaluates to false - invalid */
                return('Invalid Impression Capping');
			}
         }catch(Exception $e){
                return $e->getMessage();
 	 	} 
    }
	
	public function updateFrequencyCap(Request $request)
    {
	$user = Auth::getUser();
        try{
            $frequency = (float)($request->frequency_cap);
            if($frequency){
                $ad = intval($request->ad_id);
				Ad::where('id', $ad)->update(array('frequency_capping' => $frequency));
				Log::info($user->name.' Updated Frequency Capping for Custom Ad '.$request->ad_id.' to $'.$frequency);
                return('Frequency Capping has been updated');
            }else{
                /* bid evaluates to false - invalid */
                return('Invalid Frequency Capping');
			}
         }catch(Exception $e){
                return $e->getMessage();
 	 	} 
    }
	
	public function updateStartDate(Request $request)
    {
	$user = Auth::getUser();
        try{
            $start_date = ($request->start_date);
            if($start_date){
                $ad = intval($request->ad_id);
				Ad::where('id', $ad)->update(array('start_date' => $start_date));
				Log::info($user->name.' Updated start date for Custom Ad '.$request->ad_id.' to $'.$start_date);
                return('Start Date has been updated');
            }else{
                /* bid evaluates to false - invalid */
                return('Invalid Weight');
			}
         }catch(Exception $e){
                return $e->getMessage();
 	 	} 
    }
	
	public function updateEndDate(Request $request)
    {
	$user = Auth::getUser();
        try{
            $end_date = ($request->end_date);
            if($end_date){
                $ad = intval($request->ad_id);
				Ad::where('id', $ad)->update(array('end_date' => $end_date));
				Log::info($user->name.' Updated End Date for Custom Ad '.$request->ad_id.' to $'.$end_date);
                return('End Date has been updated');
            }else{
                /* bid evaluates to false - invalid */
                return('Invalid End Date');
			}
         }catch(Exception $e){
                return $e->getMessage();
 	 	} 
    }
	
	public function createCreative(Request $request)
    {
        $user = Auth::getUser();
        $ad = Ad::where('id', $request->id)->first();
        $creatives = AdCreative::where('ad_id', $request->id)->get();
        $media = Media::where([['status', 1],['location_type', $ad->location_type],['user_id', $user->id]])->get();
        $links = Links::where([['status', 1],['user_id', $user->id]])->get();
        return view('new_creative', ['user' => $user, 'campaign' => $ad, 'media' => $media, 'links' => $links, 'view_type' => 2]);
    }
	
	public function postCreative(Request $request)
    {
		try{
			$user = Auth::getUser();
			/* create media */
			$ins = array();
			$ins['user_id'] = $user->id;
			$ins['location_type'] = $request->location_type;
			$ins['category'] = 0;
			$ins['media_name'] = $request->description.'_0';
			$ins['file_location'] = $request->banner_link;
			$ins['created_at'] = date('Y-m-d H:i:s');
			$ins['status'] = 1;
			$media = new Media();
			$media->fill($ins);
			$media->save();		
			$media_id = $media->id;

			/* create link */
			$ins = array();
			$ins['user_id'] = $user->id;
			$ins['category'] = 0;
			$ins['link_name'] = $request->description.'_0';
			$ins['url'] = $request->click_link;
			$ins['created_at'] = date('Y-m-d H:i:s');
			$ins['status'] = 1;
			$link = new Links();
			$link->fill($ins);
			$link->save();
			$link_id = $link->id;

			/* make creative */
			$ins = array();
			$ins['ad_id'] = $request->campaign_id;
			$ins['description'] = $request->description;
			$ins['weight'] = 0;
			$ins['media_id'] = $media_id;
			$ins['link_id'] = $link_id;
			$ins['status'] = 1;
			$ins['created_at'] = date('Y-m-d H:i:s');
			$creative = new AdCreative();
			$creative->fill($ins);
			$creative->save();
			$this->balanceCreatives($creative->ad_id); 
			
			return redirect('/edit_custom_ad/'.$request->campaign_id)->with('creative_updated', 'Success! A new creative has been added.');
		}catch(Throwable $t){
		return $t->getMessage();
	  }
    }
	
	private function balanceCreatives($id)
    {
		$sql = "SELECT COUNT(*) AS records FROM ad_creatives WHERE ad_id = ".$id;
		$result = DB::select($sql);
		$count = $result[0]->records;
		if($count){
			$weight = round(100 / $count);
			$sql = "UPDATE ad_creatives SET weight = ? WHERE ad_id = ?";
			Log::info($sql);
			DB::update($sql, array($weight, $id));
		}
		return true;
    }
	
	
	public function editCreative(Request $request)
    {
		$user = Auth::getUser();
        $creative = AdCreative::find($request->id);
		$campaign = Ad::find($creative->ad_id);
		return view('edit_creative', ['creative' => $creative, 'campaign' => $campaign, 'view_type'=>2]);
    }
	
	public function updateCreative(Request $request)
    {
		try{
			$user = Auth::getUser();
			$creative = AdCreative::find($request->creative_id);
			$creative->status = 1;
			$creative->description = $request->description;
			$media = Media::find($creative->media_id);
			$link = Media::find($creative->link_id);
			
			
			
			$creative->save();
			if (!($media->file_location == $request->banner_link)){
				$update = array('file_location' => $request->banner_link, 'updated_at' => DB::raw('NOW()'));
				DB::table('media')->where([['id', $creative->media_id],['user_id', $user->id]])->update($update);
				Log::info($user->name." Updated media for AdCreative id ".$request->creative_id);
			}
			if (!($link->url == $request->click_link)){
				$update = array('url' => $request->click_link, 'updated_at' => DB::raw('NOW()'));
				DB::table('links')->where([['id', $creative->link_id],['user_id', $user->id]])->update($update);
				Log::info($user->name." Updated link for AdCreative id ".$request->creative_id);
			}
						
			$this->balanceCreatives($creative->ad_id); 
			
			return redirect('/edit_custom_ad/'.$request->campaign_id)->with('creative_updated', 'Success! Creative has been updated.');
			
		} catch(Exception $e){
            return $e->getMessage();
        }
    }
	
	public function checkBank()
    {
		$bank = new CreditAchController();
	 	$balance = intval($bank->getBalance());
		if(!$balance) return false;
		return true;
    }

    public function addZone($site_id)
    {
        try {
            $user = Auth::getUser();
            $site = Site::where('id', $site_id)->
                          where('user_id', $user->id)->
                          first();
            if (sizeof($site)) {
                $module_types = ModuleType::all();
                $location_types = LocationType::all();
                $locations = $modules = '';
                foreach ($location_types as $loc) {
                    $locations .= "<option value=\"".$loc->id."\">".$loc->description." - ".$loc->width."x".$loc->height."</option>";
                }
                foreach ($module_types as $mod) {
                    $modules .= "<option value=\"".$mod->id."\">".$mod->description."</option>";
                }
                return view('addzone', ['site' => $site, 'location_types' => $locations, 'module_types' => $modules]);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
