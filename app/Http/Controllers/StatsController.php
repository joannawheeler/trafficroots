<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Auth;
use DB;
use App\Site;
use App\Stat;
use App\Zone;
use App\Browser;
use App\Platform;
use App\OperatingSystem;
use Carbon\Carbon;

class StatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getIndex()
    {
    }
    public function site(Site $site)
    {
        $this->authorize('view', $site);
        $startDate = Carbon::now()->firstOfMonth()->toDateString();
        $endDate = Carbon::now()->endOfMonth()->toDateString();
        $stats = $site->stats
          ->where('stat_date', '>=', $startDate)
          ->where('stat_date', '<=', $endDate);

        return view('site-stats', compact('site', 'stats'));
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
    public function pub($startDate = null, $endDate = null)
    {
        $user = Auth::getUser();
        $stats = Stat::whereIn('site_id', $user->sites->pluck('id'));
        $startDate = Carbon::now()->firstOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $stats = $stats
            ->where('stat_date', '>=', $startDate->toDateString())
            ->where('stat_date', '<=', $endDate->toDateString())
            ->get();
        
        return view('pub-stats', compact('stats', 'startDate', 'endDate'));
    }
    public function zone(Zone $zone)
    {
        // $this->authorize('view', $zone);
        $startDate = Carbon::now()->firstOfMonth()->toDateString();
        $endDate = Carbon::now()->endOfMonth()->toDateString();
        $stats = $zone->stats
          ->where('stat_date', '>=', $startDate)
          ->where('stat_date', '<=', $endDate);

        return view('zone-stats', compact('zone', 'stats'));
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
            return view('stats', ['site' => $site, 'big' => $big, 'range' => $range_desc, 'zone_count' => $zone_count, 'browsers' => $browsers, 'platforms' => $platforms, 'operating_systems' => $operating_systems, 'sitedata' => $sitedata, 'zones' => $zones, 'imps' => $imps, 'clicks' => $clicks]);
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
}
