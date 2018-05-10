<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Auth;
use DB;
use App\Site;
use App\Campaign;
use App\Stat;
use App\Zone;
use App\Country;
use App\Browser;
use App\Platform;
use App\OperatingSystem;
use Carbon\Carbon;
ini_set('memory_limit','4096M');
set_time_limit(0);

class StatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getIndex()
    {
    }
    public function site(Request $request)
    {
        $site = new Site();
        $mysite = $site->where('id', $request->site)->first();
        $startDate = Carbon::now()->firstOfYear();
        $endDate = Carbon::now()->endOfMonth();
        $stats = $mysite->getStats()
                ->where('stat_date', '>=', $startDate)
                ->where('stat_date', '<=', $endDate)->get();
        return view('site-stats', ['site' => $mysite, 'site_name' => $mysite['site_name'], 'stats' => $stats]);
    }
    public function filtered(Request $request)
    {
        $dateRange = explode(' - ', $request->daterange);
        $startDate = Carbon::parse($dateRange[0]);
        $endDate = Carbon::parse($dateRange[1]);
        $sites = $request->has('sites') ? $request->get('sites') : Auth::getUser()->sites->pluck('id');
        $stats = Stat::whereIn('site_id', $sites);
        
        if ($request->has('countries')) {
            $stats->whereIn('country_id', $request->get('countries'));
        }
        $stats = $stats
            ->where('stat_date', '>=', $startDate->toDateString())
            ->where('stat_date', '<=', $endDate->toDateString())
            ->get();

        return view('pub-stats', compact('stats', 'startDate', 'endDate'));
    }
    public function pub()
    {
        $startDate = Carbon::now()->firstOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $stats = Stat::whereIn(
                'site_id',
                Auth::getUser()->sites->pluck('id')
            )
            ->where('stat_date', '>=', $startDate->toDateString())
            ->where('stat_date', '<=', $endDate->toDateString())
            ->get();
        
        return view('pub-stats', compact('stats', 'startDate', 'endDate'));
    }
    public function filteredCampaigns(Request $request)
    {
        $dateRange = explode(' - ', $request->daterange);
        $startDate = Carbon::parse($dateRange[0]);
        $endDate = Carbon::parse($dateRange[1]);
        $sites = $request->has('sites') ? $request->get('sites') : Auth::getUser()->sites->pluck('id');
        $stats = Stat::whereIn('site_id', $sites);
        
        if ($request->has('countries')) {
            $stats->whereIn('country_id', $request->get('countries'));
        }
        $stats = $stats
            ->where('stat_date', '>=', $startDate->toDateString())
            ->where('stat_date', '<=', $endDate->toDateString())
            ->get();

        return view('pub-stats', compact('stats', 'startDate', 'endDate'));
    }
    public function campaign($campaign)
    {
        // $this->authorize('view', $campaign);
        $startDate = Carbon::now()->firstOfMonth()->toDateString();
        $endDate = Carbon::now()->endOfMonth()->toDateString();
        $campaign = Campaign::with(['stats' => function ($query) use ($startDate, $endDate) {
            $query
                ->with(['city','country','state','platformType','operatingSystem','browserType'])
                ->where('stat_date', '>=', $startDate)
                ->where('stat_date', '<=', $endDate);
        },'category','type'])
            ->where('id', $campaign)
            ->first();
        return view('campaign-stats', compact('campaign', 'startDate', 'endDate'));
    }

    public function zone(Request $request, Zone $zone)
    {
	    // $this->authorize('view', $zone);
	if($request->has('daterange')){
            $stuff = explode(' - ', $request->get('daterange'));
	    $startDate = date('Y-m-d', strtotime($stuff[0]));
	    $endDate = date('Y-m-d', strtotime($stuff[1]));
	}else{
            $startDate = Carbon::now()->toDateString();
	    $endDate = Carbon::now()->toDateString();
	}
            $stats = $zone->stats
              ->where('stat_date', '>=', $startDate)
              ->where('stat_date', '<=', $endDate);
        
        return view('zone-stats', compact('zone', 'stats', 'startDate', 'endDate'));
    }
    /**
     * @author Cary White
     * @returns View
     * @access public
     * returns stats view by site and range
     */
    public function getSiteStats($site_id, $range)
    {
        try {
            $user = Auth::getUser();
            $site = Site::where('id', $site_id)->first();
            if (!$user->is_admin) {
                if (!$site->user_id == $user->id) {
                    return false;
                }
            }
            $zone_count = Zone::where('site_id', $site_id)->count();

            switch ($range) {
                case 1:
                    $start_date = date('Y-m-d', strtotime('-1 week'));
                    $range_desc = "Past Week";
                    break;
                case 2:
                    $start_date = date('Y-m-d', strtotime('-30 days'));
                    $range_desc = "Past 30 Days";
                    break;
                case 3:
                    $start_date = date('Y-m-d', strtotime('first day of this month'));
                    $range_desc = "Month to Date";
                    break;
                case 4:
                    $start_date = date('Y-m-d', strtotime('first day of this year'));
                    $range_desc = "Year to Date";
                    break;

            }
            $query = "SELECT * 
                     FROM stats
                     WHERE site_id = $site_id
                     AND `stat_date` BETWEEN '$start_date' AND '".date('Y-m-d')."'";
            $result = DB::select($query);
            $browsers = Browser::all();
            $platforms = Platform::all();
            $operating_systems = OperatingSystem::all();
            $sitedata = array();
            $zones = array();
            $big = array();
            $imps = 0;
            $clicks = 0;
            if (sizeof($result)) {
                foreach ($result as $row) {
                    if (isset($sitedata[$row->stat_date][$row->country_id]['impressions'])) {
                        $sitedata[$row->stat_date][$row->country_id]['impressions'] += $row->impressions;
                    } else {
                        $sitedata[$row->stat_date][$row->country_id]['impressions'] = $row->impressions;
                    }
                    if (isset($sitedata[$row->stat_date][$row->country_id]['clicks'])) {
                        $sitedata[$row->stat_date][$row->country_id]['clicks'] += $row->clicks;
                    } else {
                        $sitedata[$row->stat_date][$row->country_id]['clicks'] = $row->clicks;
                    }
                    $clicks += $row->clicks;
                    $imps += $row->impressions;
                    if (isset($big['browsers'][$row->browser])) {
                        $big['browsers'][$row->browser] += $row->impressions;
                    } else {
                        $big['browsers'][$row->browser] = $row->impressions;
                    }
                    if (isset($big['platforms'][$row->platform])) {
                        $big['platforms'][$row->platform] += $row->impressions;
                    } else {
                        $big['platforms'][$row->platform] = $row->impressions;
                    }
                    if (isset($big['os'][$row->os])) {
                        $big['os'][$row->os] += $row->impressions;
                    } else {
                        $big['os'][$row->os] = $row->impressions;
                    }
                }
            }
            return view('stats', ['site' => $site, 'big' => $big, 'range' => $range_desc, 'zone_count' => $zone_count, 'browsers' => $browsers, 'platforms' => $platforms, 'operating_systems' => $operating_systems, 'sitedata' => $sitedata, 'zones' => $zones, 'imps' => $imps, 'clicks' => $clicks, 'startDate' => $start_date, 'endDate' => date('Y-m-d')]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
    /**
     * @author Cary White
     * @returns View
     * @access public
     * return data by zone id
     */
    public function getZoneStats($zone_id, $range)
    {
        try {
            $start_date = $this->getRange($range);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
    public function campaignStats(Request $request)
    {
	    $user = Auth::getUser();
            $campaign = Campaign::where('id', $request->id)->where('user_id', $user->id)->first();
	    if($campaign){
		    $campaign_name = $campaign['campaign_name'];
            }else{
		    return redirect('/campaigns');
	    }
         /* today's traffic by site */
	    $site_traffic = array();
	    DB::statement("SET sql_mode = '';");
        $sql = 'select sum(stats.impressions) as impressions,
                 sum(stats.clicks) as clicks,
                 stats.site_id,
		 sites.site_name,
                 campaigns.campaign_name
                 from trafficroots.stats
                 join trafficroots.sites
                 on stats.site_id = sites.id
                 join trafficroots.bids
                 on stats.bid_id = bids.id
                 join trafficroots.campaigns
                 on bids.campaign_id = campaigns.id
                 where stats.stat_date = curdate()
		 and campaigns.id = ?
                 and campaigns.user_id = ?
                 group by stats.site_id
                 order by impressions desc;';

        $traffic = DB::select($sql, array($request->id, $user->id));
        foreach($traffic as $row){
		$site_traffic[$row->site_id]['impressions'] = isset($site_traffic[$row->site_id]) ? $site_traffic[$row->site_id]['impressions'] + $row->impressions : $row->impressions;
                $site_traffic[$row->site_id]['clicks'] = isset($site_traffic[$row->site_id]['clicks']) ? $site_traffic[$row->site_id]['clicks'] + $row->clicks : $row->clicks;

		$site_traffic[$row->site_id]['site_name'] = $row->site_name;
		$campaign_name = $row->campaign_name;
	}
        $todays_traffic = 0;
        $todays_clicks = 0;
	foreach($site_traffic as $row){ 
		$todays_traffic += $row['impressions'];
		$todays_clicks += $row['clicks'];
	}
  

        $todays_ctr = $todays_traffic ? round($todays_clicks / $todays_traffic, 4) : 0.0000;

           $sql = 'select sum(stats.impressions) as impressions,
                  sum(stats.clicks) as clicks,
                  stats.country_id,
                  countries.country_short,
                  countries.country_name
                  from trafficroots.stats
                  join trafficroots.countries
                  on stats.country_id = countries.id
                  join trafficroots.bids
                  on stats.bid_id = bids.id
                  join trafficroots.campaigns
                  on bids.campaign_id = campaigns.id
                  where stats.stat_date = curdate()
		  and campaigns.id = ?
                  and campaigns.user_id = ?
                  group by stats.country_id
                  order by impressions desc;';
         $geo_traffic = DB::select($sql, array($request->id, $user->id));

         $sql = 'select sum(stats.impressions) as impressions,
                 sum(stats.clicks) as clicks,
                 stats.state_code,
                 states.state_name,
                 states.state_short
                 from trafficroots.stats
                 join trafficroots.states
                 on stats.state_code = states.id
                  join trafficroots.bids
                  on stats.bid_id = bids.id
                  join trafficroots.campaigns
                  on bids.campaign_id = campaigns.id
                  where stats.stat_date = curdate()
		  and campaigns.id = ?
                 and campaigns.user_id = ?
                 and stats.country_id = 840
                 group by stats.state_code
                 order by impressions desc
                 limit 20;';
          $state_traffic = DB::select($sql, array($request->id, $user->id));

          $sql = 'select sum(stats.impressions) as impressions,
                 sum(stats.clicks) as clicks,
                 stats.platform,
                 platforms.platform as description
                 from trafficroots.stats
                 join trafficroots.platforms
                 on stats.platform = platforms.id
                  join trafficroots.bids
                  on stats.bid_id = bids.id
                  join trafficroots.campaigns
                  on bids.campaign_id = campaigns.id
                  where stats.stat_date = curdate()
		  and campaigns.id = ?
                 and campaigns.user_id = ?
                 group by stats.platform
                 order by impressions desc;';
          $platforms = DB::select($sql, array($request->id, $user->id));

          $sql = 'select sum(stats.impressions) as impressions,
                 sum(stats.clicks) as clicks,
                 stats.browser,
                 browsers.browser as description
                 from trafficroots.stats
                 join trafficroots.browsers
                 on stats.browser = browsers.id
                  join trafficroots.bids
                  on stats.bid_id = bids.id
                  join trafficroots.campaigns
                  on bids.campaign_id = campaigns.id
                  where stats.stat_date = curdate()
		  and campaigns.id = ?
                  and campaigns.user_id = ?
                 group by stats.browser
                 order by impressions desc;';
          $browsers = DB::select($sql, array($request->id, $user->id));

          $sql = 'select sum(stats.impressions) as impressions,
                 sum(stats.clicks) as clicks,
                 stats.os,
                 operating_systems.os as description
                 from trafficroots.stats
                 join trafficroots.operating_systems
                 on stats.os = operating_systems.id
                  join trafficroots.bids
                  on stats.bid_id = bids.id
                  join trafficroots.campaigns
                  on bids.campaign_id = campaigns.id
                  where stats.stat_date = curdate()
		  and campaigns.id = ?
                  and campaigns.user_id = ?
                 group by stats.os
                 order by impressions desc;';
          $operating_systems = DB::select($sql, array($request->id, $user->id));

	return view('campaign_stats', array('site_traffic' => $site_traffic, 
		                            'campaign_id' => $request->id, 
					    'todays_traffic' => $todays_traffic, 
					    'todays_clicks' => $todays_clicks, 
					    'todays_ctr' => $todays_ctr,
				            'campaign_name' => $campaign_name,
                                            'geo_traffic' => $geo_traffic,
                                            'state_traffic' => $state_traffic,
                                            'platforms' => $platforms,
                                            'browsers' => $browsers,
					    'operating_systems' => $operating_systems,
				            'datestring' => date('l jS \of F Y h:i:s A')));
    }
    public function zoneStats(Request $request)
    {
	    $user = Auth::getUser();
            $zone = Zone::where('id', $request->zone)->where('pub_id', $user->id)->first();
	    if($zone){
		    $zone_name = $zone['description'];
            }else{
		    return redirect('/sites');
	    }
	if($request->has('daterange')){
            $stuff = explode(' - ', $request->get('daterange'));
	    $startDate = date('Y-m-d', strtotime($stuff[0]));
	    $endDate = date('Y-m-d', strtotime($stuff[1]));
	}else{
            $startDate = Carbon::now()->toDateString();
	    $endDate = Carbon::now()->toDateString();
	}
	    $sql = 'select sum(stats.impressions) as impressions,
		    sum(stats.clicks) as clicks
                    from trafficroots.stats
                    where stats.zone_id = ?
                    and stats.stat_date BETWEEN ? AND ?';
            $result = DB::select($sql, array($request->zone,$startDate, $endDate));
            $todays_traffic = intval($result[0]->impressions);
	    $todays_clicks = intval($result[0]->clicks);
            $todays_ctr = $todays_traffic ? round($todays_clicks / $todays_traffic, 4) : 0.0000;

	    $sql = 'select sum(stats.impressions) as impressions,
                  sum(stats.clicks) as clicks,
                  stats.country_id,
                  countries.country_short,
                  countries.country_name
                  from trafficroots.stats
                  join trafficroots.countries
                  on stats.country_id = countries.id
                  where stats.stat_date between ? and ?
                  and stats.zone_id = ?
                  group by stats.country_id
                  order by impressions desc;';
         $geo_traffic = DB::select($sql, array($startDate, $endDate, $request->zone));

         $sql = 'select sum(stats.impressions) as impressions,
                 sum(stats.clicks) as clicks,
                 stats.state_code,
                 states.state_name,
                 states.state_short
                 from trafficroots.stats
                 join trafficroots.states
                 on stats.state_code = states.id
                  where stats.stat_date between ? and ?
                 and stats.zone_id = ?
                 and stats.country_id = 840
                 group by stats.state_code
                 order by impressions desc
                 limit 20;';
          $state_traffic = DB::select($sql, array($startDate, $endDate, $request->zone));

          $sql = 'select sum(stats.impressions) as impressions,
                 sum(stats.clicks) as clicks,
                 stats.platform,
                 platforms.platform as description
                 from trafficroots.stats
                 join trafficroots.platforms
                 on stats.platform = platforms.id
                  where stats.stat_date between ? and ?
                 and stats.zone_id = ?
                 group by stats.platform
                 order by impressions desc;';
          $platforms = DB::select($sql, array($startDate, $endDate, $request->zone));

          $sql = 'select sum(stats.impressions) as impressions,
                 sum(stats.clicks) as clicks,
                 stats.browser,
                 browsers.browser as description
                 from trafficroots.stats
                 join trafficroots.browsers
                 on stats.browser = browsers.id
                  where stats.stat_date between ? and ?
                  and stats.zone_id = ?
                 group by stats.browser
                 order by impressions desc;';
          $browsers = DB::select($sql, array($startDate, $endDate, $request->zone));

          $sql = 'select sum(stats.impressions) as impressions,
                 sum(stats.clicks) as clicks,
                 stats.os,
                 operating_systems.os as description
                 from trafficroots.stats
                 join trafficroots.operating_systems
                 on stats.os = operating_systems.id
                  where stats.stat_date between ? and ?
                  and stats.zone_id = ?
                 group by stats.os
                 order by impressions desc;';
          $operating_systems = DB::select($sql, array($startDate, $endDate, $request->zone));

	return view('zone_stats', array( 
		                            'zone' => $zone_name, 
					    'todays_traffic' => $todays_traffic, 
					    'todays_clicks' => $todays_clicks, 
					    'todays_ctr' => $todays_ctr,
                                            'geo_traffic' => $geo_traffic,
                                            'state_traffic' => $state_traffic,
                                            'platforms' => $platforms,
                                            'browsers' => $browsers,
					    'operating_systems' => $operating_systems,
					    'startDate' => $startDate,
					    'endDate' => $endDate,
				            'datestring' => date('l jS \of F Y h:i:s A')));
    }

}
