<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CUtil;
use Illuminate\Http\Request;
use App\Ad;
use App\Bid;
use App\Creative;
use App\BidCreative;
use App\Browser;
use App\OperatingSystem;
use App\Platform;
use App\City;
use App\State;
use App\Country;
use App\Media;
use App\Folder;
use App\Campaign;
use App\CampaignTarget;
use App\CampaignType;
use App\Category;
use App\LocationType;
use App\ModuleType;
use App\StatusType;
use App\Links;
use DB;
use Log;
use Auth;
use Validator;
use Input;
use Session;
use Carbon\Carbon;

class CampaignController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getUserMedia(Request $request)
    {
        $user = Auth::getUser();
        if($request->has('category') && intval($request->category) && $request->has('location_type') && intval($request->location_type)){
            $response = array();
            if($user->allow_folders){
                $response['folders'] = "<option value=''>Choose One</option>";
                foreach(Folder::where('user_id', $user->id)->where('location_type', intval($request->location_type))->where('category', intval($request->category))->get() as $folder){
                    $response['folders'] .= "<option value='".$folder->id."'>".$folder->folder_name."</option>";
                }
            }else{
                $response['folders'] = '';
            }
            $response['media'] = "<option value=''>Choose One</option>";
            $response['links'] = "<option value=''>Choose One</option>";
            foreach(Media::where('user_id', $user->id)->where('location_type', intval($request->location_type))->where('category', intval($request->category))->get() as $media){
                $response['media'] .= "<option value='".$media->id."'>".$media->media_name."</option>";
            }
            foreach(Links::where('user_id', $user->id)->where('category', intval($request->category))->get() as $link){
                $response['links'] .= "<option value='".$link->id."'>".$link->link_name."</option>";
            }            
            return response()->json($response); 
        }
    }
    public function updateBid(Request $request)
    {
        Log::info('Began updating bid '.$request->camp_id);
        try{
            $bid = (float) $request->bid;
            if($bid){
                $user = Auth::getUser();
                $campaign = intval($request->camp_id);
                Campaign::where('id', $campaign)->where('user_id', $user->id)->update(array('bid' => $bid));
                return('All Changes Saved');
            }else{
                /* bid evaluates to false - invalid */
                return('Invalid Bid');
            }
        }catch(Exception $e){
            return $e->getMessage();
        } 
    }
    public function updateBudget(Request $request)
    {
	$user = Auth::getUser();
        try{
            $budget = (float) $request->daily_budget;
            if($budget){
                $campaign = intval($request->camp_id);
		Campaign::where('id', $campaign)->where('user_id', $user->id)->update(array('daily_budget' => $budget));
		Log::info($user->name.' updated daily budget for campaign '.$request->camp_id.' to $'.$budget);
                return('All Changes Saved');
            }else{
                /* bid evaluates to false - invalid */
                return('Invalid Budget');
																		                }
         }catch(Exception $e){
                return $e->getMessage();
 	 } 
    }
    public function updateTargets(Request $request)
    {
        try {
            $user = Auth::getUser();
            $data = array();
            if (is_array($request->states)) {
                $data['states'] = implode("|", $request->states);
            } else {
                $data['states'] = ''.$request->states;
            }
            if (is_array($request->platform_targets)) {
                $data['platforms'] = implode("|", $request->platform_targets);
            } else {
                $data['platforms'] = ''.$request->platform_targets;
            }
            if (is_array($request->operating_systems)) {
                $data['operating_systems'] = implode("|", $request->operating_systems);
            } else {
                $data['operating_systems'] = ''.$request->operating_systems;
            }
            if (is_array($request->browser_targets)) {
                $data['browsers'] = implode("|", $request->browser_targets);
            } else {
                $data['browsers'] = ''.$request->browser_targets;
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
	    $result = DB::select('SELECT * FROM campaign_targets WHERE campaign_id = '.$request->campaign_id);
	    if(!sizeof($result)) Log::info("WTF? No record yet??");
	    if(DB::table('campaign_targets')->where('campaign_id', intval($request->campaign_id))->update($data))
	    Log::info($user->name.' updated targets on campaign '.$request->campaign_id);
	    Log::info(print_r($data, true));
            return('All Changes Saved');
        } catch (Exception $e) {
            return ($e->getMessage);
        }
    }
    public function getCreatives(Request $request)
    {
        $creatives = Creative::where('campaign_id', $request->campaign_id);
        return $creatives;
    }
    public function createCampaign()
    {
        $campaign_types = CampaignType::all();
        $categories = Category::all();
        $location_types = LocationType::all();
        $module_types = ModuleType::all();
        
        $countries = '<option value="0" selected>All Countries</option><option value="840">US - United States of America</option><option value="124">CA - Canada</option>';
        $nations = Country::all();
        foreach($nations as $nation){
	    $countries .= '<option value="'.$nation->id.'">'.$nation->country_short.' - '.$nation->country_name.'</option>';
        }

        $states = '<option value="0" selected>All States</option>';
        $result = State::all();
        foreach($result as $row){
            $states .= '<option value="'.$row->state_short.'">'.$row->state_name.'</option>';
        }
        
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
	return view('campaign_create', ['user' => $user,
		                       'countries' => $countries,
		                       'campaign_types' => $campaign_types,
                                       'categories' => $categories,
                                       'browsers' => $browsers,
                                       'platforms' => $platforms,
                                       'operating_systems' => $operating_systems,
                                       'states' => $states,
                                       'countries' => $countries,
                                       'location_types' => $location_types,
                                       'module_types' => $module_types,
                                       'platforms' => $platform_targets,
                                       'browser_targets' => $browser_targets,
                                       'os_targets' => $operating_systems,
                                       'states' => $states]);
    }
    public function postCampaign(Request $request)
    {
	try{
        $user = Auth::getUser();
        $campaign = new Campaign();
	$data = $request->all();
	Log::info(print_r($data,true));
        $data['user_id'] = $user->id;
        $campaign->fill($data);
        $campaign->save();
	$id = $campaign->id;
	$request->campaign_id = $id;
        $targets = array();
        $targets['campaign_id'] = $campaign->id;
        $targets['user_id'] = $user->id;
        $target = new CampaignTarget();
	$target->fill($targets);
        $target->save();
	$this->updateTargets($request);  
        
        /* look for creatives */
        foreach($data as $key => $value){
            if(strpos($key, 'creative') === 0){
                $info = explode('_', $key);
                $size = sizeof($info);
		if($size == 3){
			/* it's a banner */
			$sql = "INSERT INTO creatives (campaign_id, user_id, description, media_id, link_id) VALUES(?,?,?,?,?);";
			DB::insert($sql, array($id, $user->id, $value, $info[1], $info[2]));

		}
		if($size == 2){
                    /* it's a folder */
                        $sql = "INSERT INTO creatives (campaign_id, user_id, description, folder_id) VALUES(?,?,?,?);";
			DB::insert($sql, array($id, $user->id, $value, $info[1]));
		}
            }
	}	
	$this->balanceCreatives($id);
        Session::flash('success', 'Campaign Created!'); 	
	return json_encode(array('status' => 'OK'));
	}catch(Exception $e){
            Log::error($e->getMessage());
	}
    }
    private function balanceCreatives($id)
    {
	$sql = "SELECT COUNT(*) AS records FROM creatives WHERE campaign_id = $id";
	$result = DB::select($sql);
	$count = $result[0]->records;
	$weight = round(100 / $count);
	$sql = "UPDATE creatives SET weight = ? WHERE campaign_id = ?";
	Log::info($sql);
	DB::update($sql, array($weight, $id));
	return true;
    }
    public function createCreative(Request $request)
    {
        $user = Auth::getUser();
        $campaign = Campaign::where([['id', $request->id],['user_id', $user->id]])->first();
        $creatives = Creative::where([['campaign_id', $request->id],['user_id', $user->id]])->get();
        $media = Media::where([['status', 1],['location_type', $campaign->location_type],['user_id', $user->id]])->get();
        $folders = Folder::where([['status', 1],['location_type', $campaign->location_type],['user_id', $user->id]])->get();
        $links = Links::where([['status', 1],['user_id', $user->id]])->get();
        return view('new_creative', ['user' => $user, 'campaign' => $campaign, 'media' => $media, 'links' => $links, 'folders' => $folders]);
    }
    public function postCreative(Request $request)
    {
        $user = Auth::getUser();
        $data = $request->all();
        $data['user_id'] = $user->id;
        if (isset($data['folder_id'])) {
            $data['folder_id'] = intval($data['folder_id']);
        }
        $current = Creative::where([['campaign_id', $data['campaign_id']],['user_id', $user->id],['status', 1]])->get();
        $ads = sizeof($current);
        if ($ads) {
            $weight = (100 / ($ads + 1));
            $creative = new Creative();
            $creative->fill($data);
            $creative->save();
            Creative::where([['campaign_id', $data['campaign_id']],['user_id', $user->id],['status', 1]])->update(['weight' => $weight]);
        } else {
            $data['weight'] = 100;
            $creative = new Creative();
            $creative->fill($data);
            $creative->save();
        }
        return redirect('/manage_campaign/'.$request->campaign_id);
    }

    public function createMedia()
    {
        $location_types = LocationType::all();
        $categories = Category::all();
        return view('media_upload', ['location_types' => $location_types, 'categories' => $categories]);
    }

    public function postMedia(Request $request)
    {
        $this->validate($request, [
            'media_name' => 'required|string',
            'category' => 'required|exists:categories,id',
            'location_type' => 'required|exists:location_types,id',
            'file' => 'required|mimes:jpeg,gif,png|max:300'
        ]);
        $data = $request->all();
        $media = new Media();
        $user = Auth::getUser();
        $destination = 'uploads/'.$user->id;
        $path = $request->file('file')->store($destination);
        $data['user_id'] = $user->id;
        $data['status'] = 5;
        $data['file_location'] = $path;
        $media->fill($data);
        $media->save();
        return response()->json([
            'id' => $media->id,
            'name' => $media->media_name,
            'category' => $media->category_type->category,
            'location_type' => $media->locationType->description,
            'status' => $media->status_type->description,
            'date' => Carbon::parse($media->created_at)->toDayDateTimeString(),
            'url' => asset($path)
        ]);
    }

    public function createFolder()
    {
        $location_types = LocationType::all();
        $categories = Category::all();
        return view('html5_upload', ['location_types' => $location_types, 'categories' => $categories]);
    }

    public function postFolder(Request $request)
    {
        $data = $request->all();
        $folder = new Folder();
        $user = Auth::getUser();
        $destination = 'uploads/'.$user->id;
        $path = $request->file('zfile')->store($destination);
        $data['user_id'] = $user->id;
        $data['file_location'] = $path;
        $folder->fill($data);
        $folder->save();
           // sending back with message
           Session::flash('success', 'Upload completed!');
        return redirect('/buyers');
    }
    public function createLink()
    {
        $categories = Category::all();
        return view('create_link', ['categories' => $categories]);
    }

    public function postLink(Request $request)
    {
        $this->validate($request, [
            'link_name' => 'required|string',
            'category' => 'required|exists:categories,id',
            'url' => 'required|url'
        ]);
        $data = $request->all();
        $data['user_id'] = Auth::getUser()->id;
        $data['status'] = 5;
        $link = new Links();
        $link->fill($data);
        $link->save();
        return response()->json([
            'id' => $link->id,
            'name' => $link->link_name,
            'category' => $link->category_type->category,
            'url' => $link->url,
            'status' => $link->status_type->description,
            'date' => Carbon::parse($link->created_at)->toDayDateTimeString()
        ]);
    }
    public function editCampaign(Request $request)
    {
        $user = Auth::getUser();
        $CUtil = new CUtil();
        $campaign = DB::select('select * from campaigns where id = '.$request->id.' and user_id = '.$user->id);
        if ($campaign) {
            $campaign_types = $CUtil->getCampaignTypes();
            $category = $CUtil->getCategories();
            $status_types = $CUtil->getStatusTypes();
            $location = $CUtil->getLocationTypes();
            foreach ($campaign as $camp) {
                $states = $CUtil->getStates($camp->id);
                $os_targets = $CUtil->getOperatingSystems($camp->id);
                $platforms = $CUtil->getPlatforms($camp->id);
                $browser_targets = $CUtil->getBrowsers($camp->id);
                $creatives = Creative::where('campaign_id', $camp->id)->get();
                if (!$creatives) {
                    $creatives = array();
                }
                $row = DB::table('campaign_targets')->where('campaign_id', $camp->id)->first();
                $media = DB::select('select * from media where user_id = '.$user->id.' and location_type = '.$camp->location_type);
                $links = DB::select('select * from links where user_id = '.$user->id.' and category = '.$camp->campaign_category);
                return view('manage_campaign', [
                    'campaign' => $camp,
                    'media' => $media,
                    'links' => $links,
                    'campaign_types' => $campaign_types,
                    'categories' => $category,
                    'status_types' => $status_types,
                    'location_types' => $location,
                    'creatives' => $creatives,
                    'states' => $states,
                    'os_targets' => $os_targets,
                    'browser_targets' => $browser_targets,
                    'platforms' => $platforms,
                    'keywords' => str_replace("|", ",", $row->keywords),
                    'user_id' => $user->id
                ]);
            }
        }
    }
    public function campaigns()
    {
        $user = Auth::user();
        $startDate = Carbon::now()->firstOfMonth()->toDateString();
        $endDate = Carbon::now()->endOfMonth()->toDateString();
        $campaigns = Campaign::with(['stats' => function ($query) use ($startDate, $endDate) {
            $query
                ->where('stat_date', '>=', $startDate)
                ->where('stat_date', '<=', $endDate);
        },'status_type','category','type'])
            ->where('user_id', $user->id)
            ->get();
        
        return view(
            'advertiser.campaigns',
            compact('campaigns', 'startDate', 'endDate')
        );
    }
    public function startCampaign(Request $request)
    {
        $user = Auth::user();
        if($request->id){
            $campaign = Campaign::where('id', $request->id)->where('user_id', $user->id)->get();
            if(sizeof($campaign)){
                /* campaign belongs to user */
                $update = array('status' => 1, 'updated_at' => DB::raw('NOW()'));
                DB::table('campaigns')->where('id', $request->id)->update($update);
                DB::table('bids')->where('campaign_id', $request->id)->update($update);
                Log::info($user->name." Activated Campaign ".$request->id);
                return('Campaign Activated!');
            }else{
                return('Campaign Not Found');
            }
        }else{
            return('Invalid Campaign ID!');           
        }

    }
    public function pauseCampaign(Request $request)
    {
        $user = Auth::user();
        if($request->id){
            $campaign = Campaign::where('id', $request->id)->where('user_id', $user->id)->get();
            if(sizeof($campaign)){
                /* campaign belongs to user */
                $update = array('status' => 3, 'updated_at' => DB::raw('NOW()'));
                DB::table('campaigns')->where('id', $request->id)->update($update);
                DB::table('bids')->where('campaign_id', $request->id)->update($update);
                Log::info($user->name." Paused Campaign ".$request->id);
                return('Campaign Paused!');
            }else{
                return('Campaign Not Found');
            }
        }else{
            return('Invalid Campaign ID!');
        }
    }
}
