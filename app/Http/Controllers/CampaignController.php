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
            DB::table('campaign_targets')->where('campaign_id', intval($request->campaign_id))->update($data);
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
        $browsers = Browser::all();
        $platforms = Platform::all();
        $operating_systems = OperatingSystem::all();
        $cities = City::all();
        $states = State::all();
        $countries = Country::all();
        $location_types = LocationType::all();
        $module_types = ModuleType::all();

        return view('campaign_create', ['campaign_types' => $campaign_types,
                                       'categories' => $categories,
                                       'browsers' => $browsers,
                                       'platforms' => $platforms,
                                       'operating_systems' => $operating_systems,
                                       'cities' => $cities,
                                       'states' => $states,
                                       'countries' => $countries,
                                       'location_types' => $location_types,
                                       'module_types' => $module_types]);
    }
    public function postCampaign(Request $request)
    {
        $user = Auth::getUser();
        $campaign = new Campaign();
        $data = $request->all();
        $data['user_id'] = $user->id;
        $campaign->fill($data);
        $campaign->save();
        $id = $campaign->id;
        $targets = array();
        $targets['campaign_id'] = $campaign->id;
        $targets['user_id'] = $user->id;
        $target = new CampaignTarget();
        $target->fill($targets);
        $target->save();
        
        return redirect('/manage_campaign/'.$id);
    }
    public function createCreative(Request $request)
    {
        $user = Auth::getUser();
        $campaign = Campaign::where([['id', $request->id],['user_id', $user->id]])->first();
        $creatives = Creative::where([['campaign_id', $request->id],['user_id', $user->id]])->get();
        $media = Media::where([['status', 1],['location_type', $campaign->location_type],['user_id', $user->id]])->get();
        $folders = Folder::where([['status', 1],['location_type', $campaign->location_type],['user_id', $user->id]])->get();
        $links = Links::where([['status', 1],['user_id', $user->id]])->get();
        return view('new_creative', ['campaign' => $campaign, 'media' => $media, 'links' => $links, 'folders' => $folders]);
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
        $data = $request->all();
        $media = new Media();
        $user = Auth::getUser();
        $destination = 'uploads/'.$user->id;
        $path = $request->file('image_file')->store($destination);
        $data['user_id'] = $user->id;
        $data['file_location'] = $path;
        $media->fill($data);
        $media->save();
           // sending back with message
           Session::flash('success', 'Upload completed!');
        return redirect('/home');
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
        return redirect('/home');
    }
    public function createLink()
    {
        $categories = Category::all();
        return view('create_link', ['categories' => $categories]);
    }

    public function postLink(Request $request)
    {
        $data = $request->all();
        $user = Auth::getUser();
        $data['user_id'] = $user->id;
        $link = new Links();
        $link->fill($data);
        $link->save();
        return redirect('/home');
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
}
