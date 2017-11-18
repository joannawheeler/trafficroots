<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Site;
use App\Bank;
use App\User;
use App\Faq;
use App\LocationType;
use App\Category;
use App\StatusType;
use App\Folders;
use DB;
use Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        setlocale(LC_MONETARY, 'en_US.utf8');
    }
    public function advertiser()
    {
        return view('advertiser.dashboard', array('title' => 'Advertisers'));
    }
    public function advertiserFaq()
    {
        $faqs = Faq::where('faq_type', 1)->get();
        return view('faq_advertiser', array('faqs' => $faqs, 'title' => 'Advertiser FAQ'));
    }
    public function publisherFaq()
    {
        return view('faq_publisher', array('title' => 'Publisher FAQ'));
    }
    public function whoAmI()
    {
        $categories = Category::all();
        return view('whoami',array('categories' => $categories, 'title' => 'Info'));
    }
    public function pubType()
    {
        $user = Auth::getUser();
        User::where('id', $user->id)->update(array('user_type' => 1));
        return redirect('sites');
    }
    public function buyerType()
    {
        $user = Auth::getUser();
        User::where('id', $user->id)->update(array('user_type' => 2));
        return redirect('media');
    }
    /**
     * Show the advertiser`s dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function buyers()
    {
       $status_types = array();
       $status = StatusType::all();
       $status_types[] = 'Pending';
       foreach($status as $s){
           $status_types[$s->id] = $s->description;
       }
       $campaign_types = array();
       $campaign_types[1] = 'CPM';
       $campaign_types[2] = 'CPC';
       $location_types = LocationType::all();
       $categories = Category::all();
       $location = array();
       $width = array();
       $height = array();
       foreach($location_types as $type){
           $location[$type['id']] = $type['description'] . ' - ' . $type['width'] .'x'. $type['height'];
           $width[$type['id']] = $type['width'] + 50;
           $height[$type['id']] = $type['height'] + 50;
       }
       $category = array();
       foreach($categories as $cat){
           $category[$cat['id']] = $cat['category'];
       }
       $user = Auth::user();
       $res = DB::select('select * from campaigns where user_id = '.$user->id);
       $media = DB::select('select * from media where user_id = '.$user->id);
       $folders = DB::select('select * from folders where user_id = '.$user->id);
       $links = DB::select('select * from links where user_id = '.$user->id);
       $bank = DB::select('SELECT * FROM bank WHERE user_id = '.$user->id.' ORDER BY id DESC LIMIT 1;');
       if(!sizeof($bank)){
           $data = array();
           $data['user_id'] = $user->id;
           $data['transaction_amount'] = 0.00;
           $data['running_balance'] = 0.00;
           $newbank = new Bank();
           $newbank->fill($data);
           $newbank->save();
           $bank = DB::select('SELECT * FROM bank WHERE user_id = '.$user->id.' ORDER BY id DESC LIMIT 1;');
       }
        return view('buyers', [
            'user' => $user,
            'bank' => $bank,
            'campaigns' => $res,
            'media' => $media,
            'links' => $links,
            'location_types' => $location,
            'categories' => $category,
            'campaign_types' => $campaign_types,
            'folders' => $folders,
            'width' => $width,
            'height' => $height,
            'status_types' => $status_types,
            'title' => 'Advertisers'
        ]);
    }
    public function getPubInfo($id) {
        DB::statement("SET sql_mode = '';");
        $data = array();
        $sql = "SELECT 
SUM(publisher_bookings.revenue) * commission_tiers.publisher_factor AS earned,
SUM(publisher_bookings.impressions) as impressions,
SUM(publisher_bookings.clicks) as clicks,
commission_tiers.publisher_factor
FROM publisher_bookings
JOIN commission_tiers
ON publisher_bookings.commission_tier = commission_tiers.id
WHERE publisher_bookings.booking_date = CURDATE()
AND publisher_bookings.pub_id = $id
GROUP BY commission_tiers.publisher_factor;";
        $result = DB::select($sql);
        $data['earned_today'] = sizeof($result) ? $result[0]->earned : 0.00;
        $data['impressions_today'] = sizeof($result) ? $result[0]->impressions : 0;
        $data['clicks_today'] = sizeof($result) ? $result[0]->clicks : 0;
        $data['cpm_today'] = $data['impressions_today'] ? ($data['earned_today'] / ($data['impressions_today'] / 1000)) : 0.00;        

        $sql = "SELECT 
SUM(publisher_bookings.revenue) * commission_tiers.publisher_factor AS earned,
SUM(publisher_bookings.impressions) as impressions,
SUM(publisher_bookings.clicks) as clicks,
commission_tiers.publisher_factor
FROM publisher_bookings
JOIN commission_tiers
ON publisher_bookings.commission_tier = commission_tiers.id
WHERE publisher_bookings.booking_date >= '".date('Y-m-d', strtotime('first day of this month'))."'
AND publisher_bookings.pub_id = $id
GROUP BY commission_tiers.publisher_factor;";
        $data['earned_this_month'] = 0.00;
        $data['impressions_this_month'] = 0;
        $data['clicks_this_month'] = 0;
        foreach(DB::select($sql) as $row){
            $data['earned_this_month'] += is_null($row->earned) ? 0.00 : $row->earned;
            $data['impressions_this_month'] += is_null($row->impressions) ? 0 : $row->impressions;
            $data['clicks_this_month'] += is_null($row->clicks) ? 0 : $row->clicks;
        } 
        $data['cpm_this_month'] = $data['impressions_this_month'] ? ($data['earned_this_month'] / ($data['impressions_this_month'] / 1000)) : 0.00;
$sql = "SELECT 
SUM(publisher_bookings.revenue) * commission_tiers.publisher_factor AS earned,
SUM(publisher_bookings.impressions) as impressions,
SUM(publisher_bookings.clicks) as clicks,
commission_tiers.publisher_factor
FROM publisher_bookings
JOIN commission_tiers
ON publisher_bookings.commission_tier = commission_tiers.id
WHERE publisher_bookings.booking_date BETWEEN '".date('Y-m-d', strtotime('first day of last month'))."'
AND '".date('Y-m-d', strtotime('last day of last month'))."'
AND publisher_bookings.pub_id = $id
GROUP BY commission_tiers.publisher_factor;";
        $data['earned_last_month'] = 0.00;
        $data['impressions_last_month'] = 0;
        $data['clicks_last_month'] = 0;
        foreach(DB::select($sql) as $row){
            $data['earned_last_month'] += is_null($row->earned) ? 0.00 : $row->earned;
            $data['impressions_last_month'] += is_null($row->impressions) ? 0 : $row->impressions;
            $data['clicks_last_month'] += is_null($row->clicks) ? 0 : $row->clicks;            
        }
        $data['cpm_last_month'] = $data['impressions_last_month'] ? ($data['earned_last_month'] / ($data['impressions_last_month'] / 1000)) : 0.00;
$sql2 = "SELECT 
SUM(publisher_bookings.revenue) * commission_tiers.publisher_factor AS earned,
SUM(publisher_bookings.impressions) as impressions,
SUM(publisher_bookings.clicks) as clicks,
commission_tiers.publisher_factor
FROM publisher_bookings
JOIN commission_tiers
ON publisher_bookings.commission_tier = commission_tiers.id
WHERE publisher_bookings.booking_date >= '".date('Y')."-01-01'
AND publisher_bookings.pub_id = $id
GROUP BY commission_tiers.publisher_factor;";
        $data['earned_this_year'] = 0.00;
        $data['impressions_this_year'] = 0;
        $data['clicks_this_year'] = 0;
        foreach(DB::select($sql2) as $row2){
            $data['earned_this_year'] += is_null($row2->earned) ? 0.00 : $row2->earned;
            $data['impressions_this_year'] += is_null($row2->impressions) ? 0 : $row2->impressions;
            $data['clicks_this_year'] += is_null($row2->clicks) ? 0 : $row2->clicks;            
        }
        $data['cpm_this_year'] = $data['impressions_this_year'] ? ($data['earned_this_year'] / ($data['impressions_this_year'] / 1000)) : 0.00;

        $data['last_thirty_days'] = array();        
for($i = 30; $i >= 0; $i--){
    $mydate = date('Y-m-d', strtotime("-$i days"));

$sql = "SELECT 
SUM(publisher_bookings.revenue) * commission_tiers.publisher_factor AS earned,
SUM(publisher_bookings.impressions) as impressions,
SUM(publisher_bookings.clicks) as clicks,
commission_tiers.publisher_factor
FROM publisher_bookings
JOIN commission_tiers
ON publisher_bookings.commission_tier = commission_tiers.id
WHERE publisher_bookings.booking_date = '$mydate'
AND publisher_bookings.pub_id = $id
GROUP BY commission_tiers.publisher_factor, publisher_bookings.booking_date
ORDER BY publisher_bookings.booking_date;";
        //Log::info($sql);
        $data['last_thirty_days'][date('m/d/Y',strtotime($mydate))] = array('timestamp' => strtotime($mydate) * 1000, 'impressions' => 0, 'clicks' => 0, 'earnings' => 0);
        foreach(DB::select($sql) as $row){
            $earnings = $row->earned;
            $impressions = $row->impressions;
            $clicks = $row->clicks;
            $data['last_thirty_days'][date('m/d/Y',strtotime($mydate))] = array('timestamp' => strtotime($mydate) * 1000, 'impressions' => $impressions, 'clicks' => $clicks, 'earnings' => $earnings);
        } 
}
        $data['sites'] = array();
$sql = "SELECT
SUM(publisher_bookings.revenue) * commission_tiers.publisher_factor AS earned,
SUM(publisher_bookings.impressions) as impressions,
SUM(publisher_bookings.clicks) as clicks,
sites.site_name,
COUNT(publisher_bookings.booking_date) as days_active
FROM publisher_bookings
JOIN commission_tiers
ON publisher_bookings.commission_tier = commission_tiers.id
JOIN sites
ON publisher_bookings.site_id = sites.id
WHERE publisher_bookings.booking_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
AND publisher_bookings.pub_id = $id;";
        foreach(DB::select($sql) as $row){
            $data['sites'][] = $row;
        }
        Log::info(print_r($data,true));
        return $data;
    }

    /**
     * Show the publisher`s dashboard.
     * @author Cary White
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $input = $request->all();
       $user = Auth::user();
       if(!$user->user_type){
           return view('whoami');
       }
        $sql = 'SELECT sites.*, categories.category 
                FROM sites 
                JOIN categories 
                ON sites.site_category = categories.id
                WHERE sites.user_id = '.$user->id;
        $sites = DB::select($sql);
        $view_type = isset($input['type']) ? intval($input['type']) : 0;
        if(!$view_type) $view_type = $user->user_type;
        if($view_type == 1 || $view_type == 3){ 
            $pub_data = $this->getPubInfo($user->id);
            return view('home', ['user' => $user, 'title' => 'Publishers',
                            'sites' => $sites, 'pub_data' => $pub_data, 'view_type' => $view_type]);
        }
        if($view_type == 2){
            $buyer_data = $this->getBuyerInfo($user);
            return view('home', ['user' => $user, 'title' => 'Advertisers', 'buyer_data' => $buyer_data, 'view_type' => $view_type]);
        }
    }

    /**
     * Get buyer data
     * @author Cary White
     * @return array
     * @access public
     */
    public function getBuyerInfo($user)
    {
        DB::statement("SET sql_mode = '';");
        $data = array();
        /* balance */ 
        $sql = "SELECT running_balance AS balance FROM bank WHERE user_id = ? ORDER BY id DESC LIMIT 1";
        $data['current_balance'] = sizeof($bank = DB::select($sql, array($user->id))) ? $bank[0]->balance : 0.00; 
        /* today */
        $sql = "SELECT SUM(stats.impressions) AS impressions, SUM(stats.clicks) AS clicks, stats.stat_date
                FROM stats
                JOIN bids ON stats.bid_id = bids.id
                JOIN users ON users.id = bids.buyer_id
                WHERE users.id = ?
                AND stats.stat_date = CURDATE();";
        $result = DB::select($sql, array($user->id));
        $data['impressions_today'] = sizeof($result) ? $result[0]->impressions : 0;
        $data['clicks_today'] = sizeof($result) ? $result[0]->clicks : 0;
        $data['ctr_today'] = (float) $data['clicks_today'] ? round($data['clicks_today'] / $data['impressions_today'], 4) : 0.0000;
        $sql = "SELECT SUM(transaction_amount) AS spend FROM bank WHERE user_id = ? AND created_at = CURDATE() AND transaction_amount < 0";
        $result = DB::select($sql, array($user->id));
        $data['spent_today'] = sizeof($result) ? $result[0]->spend * -1 : 0;

        $data['cpm_today'] = (float) $data['impressions_today'] ? round($data['spent_today'] / ($data['impressions_today'] / 1000), 4) : 0.00;
        $data['cpc_today'] = (float) $data['clicks_today'] ? round($data['spent_today'] / $data['clicks_today'], 4) : 0.00;

        $sql = "SELECT DISTINCT(campaigns.id)
                FROM stats
                JOIN bids ON stats.bid_id = bids.id
                JOIN campaigns ON bids.campaign_id = campaigns.id
                WHERE campaigns.user_id = ?
                AND stats.stat_date = CURDATE();";
        $result = DB::select($sql, array($user->id));
        $data['active_campaigns_yesterday'] = sizeof($result);


        /* yesterday */
        $sql = "SELECT SUM(stats.impressions) AS impressions, SUM(stats.clicks) AS clicks, stats.stat_date
                FROM stats
                JOIN bids ON stats.bid_id = bids.id
                JOIN users ON users.id = bids.buyer_id
                WHERE users.id = ?
                AND stats.stat_date = DATE_SUB(CURDATE(), INTERVAL 1 DAY);";
        $result = DB::select($sql, array($user->id));
        $data['impressions_yesterday'] = sizeof($result) ? $result[0]->impressions : 0;
        $data['clicks_yesterday'] = sizeof($result) ? $result[0]->clicks : 0;
        $data['ctr_yesterday'] = (float) $data['clicks_yesterday'] ? round($data['clicks_yesterday'] / $data['impressions_yesterday'], 4) : 0.0000;
        $sql = "SELECT SUM(transaction_amount) AS spend FROM bank WHERE user_id = ? AND created_at = DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND transaction_amount < 0";
        $result = DB::select($sql, array($user->id));
        $data['spent_yesterday'] = sizeof($result) ? $result[0]->spend * -1 : 0;
        
        $data['cpm_yesterday'] = (float) $data['impressions_yesterday'] ? round($data['spent_yesterday'] / ($data['impressions_yesterday'] / 1000), 4) : 0.00;
        $data['cpc_yesterday'] = (float) $data['clicks_yesterday'] ? round($data['spent_yesterday'] / $data['clicks_yesterday'], 4) : 0.00;

        $sql = "SELECT DISTINCT(campaigns.id)
                FROM stats
                JOIN bids ON stats.bid_id = bids.id
                JOIN campaigns ON bids.campaign_id = campaigns.id
                WHERE campaigns.user_id = ?
                AND stats.stat_date = DATE_SUB(CURDATE(), INTERVAL 1 DAY);";
        $result = DB::select($sql, array($user->id));
        $data['active_campaigns_yesterday'] = sizeof($result);

        /* this month */
        $sql = "SELECT SUM(stats.impressions) AS impressions, SUM(stats.clicks) AS clicks, stats.stat_date
                FROM stats
                JOIN bids ON stats.bid_id = bids.id
                JOIN users ON users.id = bids.buyer_id
                WHERE users.id = ?
                AND stats.stat_date >= '".date('Y-m-d', strtotime('first day of this month'))."';";
        $result = DB::select($sql, array($user->id));
        $data['impressions_this_month'] = sizeof($result) ? $result[0]->impressions : 0;
        $data['clicks_this_month'] = sizeof($result) ? $result[0]->clicks : 0;
        $data['ctr_this_month'] = (float) $data['clicks_this_month'] ? round($data['clicks_this_month'] / $data['impressions_this_month'], 4) : 0.0000;

        $sql = "SELECT SUM(transaction_amount) AS spend FROM bank WHERE user_id = ? AND created_at >= '".date('Y-m-d', strtotime('first day of this month'))."' AND transaction_amount < 0";
        $result = DB::select($sql, array($user->id));
        $data['spent_this_month'] = sizeof($result) ? $result[0]->spend * -1: 0;

        $data['cpm_this_month'] = (float) $data['impressions_this_month'] ? round($data['spent_this_month'] / ($data['impressions_this_month'] / 1000), 4) : 0.00;
        $data['cpc_this_month'] = (float) $data['clicks_this_month'] ? round($data['spent_this_month'] / $data['clicks_this_month'], 4) : 0.00;

        $sql = "SELECT DISTINCT(campaigns.id)
                FROM stats
                JOIN bids ON stats.bid_id = bids.id
                JOIN campaigns ON bids.campaign_id = campaigns.id
                WHERE campaigns.user_id = ?
                AND stats.stat_date >= '".date('Y-m-d', strtotime('first day of this month'))."'";
        $result = DB::select($sql, array($user->id));
        $data['active_campaigns_this_month'] = sizeof($result);

        /* last month */
        $sql = "SELECT SUM(stats.impressions) AS impressions, SUM(stats.clicks) AS clicks, stats.stat_date
                FROM stats
                JOIN bids ON stats.bid_id = bids.id
                JOIN users ON users.id = bids.buyer_id
                WHERE users.id = ?
                AND stats.stat_date >= '".date('Y-m-d', strtotime('first day of last month'))."'
                AND stats.stat_date < '".date('Y-m-d', strtotime('first day of this month'))."';";
        $result = DB::select($sql, array($user->id));
        $data['impressions_last_month'] = sizeof($result) ? $result[0]->impressions : 0;
        $data['clicks_last_month'] = sizeof($result) ? $result[0]->clicks : 0;
        $data['ctr_last_month'] = (float) $data['clicks_last_month'] ? round($data['clicks_last_month'] / $data['impressions_last_month'], 4) : 0.0000;

        $sql = "SELECT SUM(transaction_amount) AS spend FROM bank WHERE user_id = ? 
                AND bank.created_at >= '".date('Y-m-d', strtotime('first day of last month'))."'
                AND bank.created_at < '".date('Y-m-d', strtotime('first day of this month'))."' AND transaction_amount < 0";
        $result = DB::select($sql, array($user->id));
        $data['spent_last_month'] = sizeof($result) ? $result[0]->spend * -1 : 0;

        $data['cpm_last_month'] = (float) $data['impressions_last_month'] ? round($data['spent_last_month'] / ($data['impressions_last_month'] / 1000), 4) : 0.00;
        $data['cpc_last_month'] = (float) $data['clicks_last_month'] ? round($data['spent_last_month'] / $data['clicks_last_month'], 4) : 0.00;

        $sql = "SELECT DISTINCT(campaigns.id)
                FROM stats
                JOIN bids ON stats.bid_id = bids.id
                JOIN campaigns ON bids.campaign_id = campaigns.id
                WHERE campaigns.user_id = ?
                AND stats.stat_date >= '".date('Y-m-d', strtotime('first day of last month'))."'
                AND stats.stat_date < '".date('Y-m-d', strtotime('first day of this month'))."';";
        $result = DB::select($sql, array($user->id));
        $data['active_campaigns_last_month'] = sizeof($result);

        /* last thirty days */
        $data['last_thirty_days'] = array();
        for($i = 60; $i >= 0; $i--){
            $mydate = date('Y-m-d', strtotime("-$i days"));
            
            $sql = "SELECT SUM(stats.impressions) AS impressions, SUM(stats.clicks) AS clicks, stats.stat_date 
                FROM stats
                JOIN bids ON stats.bid_id = bids.id
                JOIN users ON users.id = bids.buyer_id
                WHERE users.id = ?
                AND stats.stat_date = ?;";
               $data['last_thirty_days'][date('m/d/Y',strtotime($mydate))] = array('impressions' => 0, 'clicks' => 0, 'spend' => 0);
            foreach(DB::select($sql, array($user->id, $mydate)) as $row){
                $sql = "SELECT SUM(transaction_amount) AS spend FROM bank WHERE user_id = ? AND created_at LIKE '$mydate%' AND transaction_amount < 0";
                $spend = sizeof($daily = DB::select($sql, array($user->id))) ? $daily[0]->spend * -1 : 0.00;
                $impressions = intval($row->impressions);
                $clicks = intval($row->clicks);
                $data['last_thirty_days'][date('m/d/Y',strtotime($mydate))] = array('timestamp' => strtotime($mydate) * 1000, 'impressions' => $impressions, 'clicks' => $clicks, 'spend' => $spend);
            }
        }
        /* campaigns - this month */
        $data['campaigns']['thismonth'] = array();
        $data['campaigns']['lastmonth'] = array();
        $sql = "SELECT campaigns.campaign_name, campaigns.campaign_type, campaigns.bid, SUM(stats.impressions) AS impressions, SUM(stats.clicks) AS clicks, COUNT(DISTINCT(stats.stat_date)) AS days_active 
                FROM stats
                JOIN bids ON stats.bid_id = bids.id
                JOIN campaigns ON bids.campaign_id = campaigns.id
                JOIN users ON users.id = bids.buyer_id
                WHERE users.id = ?
                AND stats.stat_date >= ?
                GROUP BY campaign_name, bid;";
        foreach(DB::select($sql,array($user->id,date('Y-m-d',strtotime('first day of this month')))) as $camp){
            $data['campaigns']['thismonth'][$camp->campaign_name]['impressions'] = isset($data['campaigns']['thismonth'][$camp->campaign_name]['impressions']) ? $data['campaigns']['thismonth'][$camp->campaign_name]['impressions'] + $camp->impressions : $camp->impressions;
            $data['campaigns']['thismonth'][$camp->campaign_name]['clicks'] = isset($data['campaigns']['thismonth'][$camp->campaign_name]['clicks']) ? $data['campaigns']['thismonth'][$camp->campaign_name]['clicks'] + $camp->clicks : $camp->clicks;
            $data['campaigns']['thismonth'][$camp->campaign_name]['days_active'] = isset($data['campaigns']['thismonth'][$camp->campaign_name]['days_active']) ? $data['campaigns']['thismonth'][$camp->campaign_name]['days_active'] + $camp->days_active : $camp->days_active;
            $spent = 0;
            if($camp->campaign_type == 1){
                $spent = ($camp->impressions / 1000) * $camp->bid;
            }
            if($camp->campaign_type == 2){
                $spent = $camp->clicks * $camp->bid;
            }
            $data['campaigns']['thismonth'][$camp->campaign_name]['spend'] = isset($data['campaigns']['thismonth'][$camp->campaign_name]['spend']) ? $data['campaigns']['thismonth'][$camp->campaign_name]['spend'] + $spent : $spent;
        }

        /* campaigns - last month */
        $sql = "SELECT campaigns.campaign_name, campaigns.campaign_type, campaigns.bid, SUM(stats.impressions) AS impressions, SUM(stats.clicks) AS clicks, COUNT(DISTINCT(stats.stat_date)) AS days_active
                FROM stats
                JOIN bids ON stats.bid_id = bids.id
                JOIN campaigns ON bids.campaign_id = campaigns.id
                JOIN users ON users.id = bids.buyer_id
                WHERE users.id = ?
                AND stats.stat_date BETWEEN ? AND ?
                GROUP BY campaign_name, bid;";
        foreach(DB::select($sql,array($user->id,date('Y-m-d',strtotime('first day of last month')),date('Y-m-d',strtotime('first day of this month')))) as $camp){
            $data['campaigns']['lastmonth'][$camp->campaign_name]['impressions'] = isset($data['campaigns']['lastmonth'][$camp->campaign_name]['impressions']) ? $data['campaigns']['lastmonth'][$camp->campaign_name]['impressions'] + $camp->impressions : $camp->impressions;
            $data['campaigns']['lastmonth'][$camp->campaign_name]['clicks'] = isset($data['campaigns']['lastmonth'][$camp->campaign_name]['clicks']) ? $data['campaigns']['lastmonth'][$camp->campaign_name]['clicks'] + $camp->clicks : $camp->clicks;
            $data['campaigns']['lastmonth'][$camp->campaign_name]['days_active'] = isset($data['campaigns']['lastmonth'][$camp->campaign_name]['days_active']) ? $data['campaigns']['lastmonth'][$camp->campaign_name]['days_active'] + $camp->days_active : $camp->days_active;
            $spent = 0;
            if($camp->campaign_type == 1){
                $spent = ($camp->impressions / 1000) * $camp->bid;
            }
            if($camp->campaign_type == 2){
                $spent = $camp->clicks * $camp->bid;
            }
            $data['campaigns']['lastmonth'][$camp->campaign_name]['spend'] = isset($data['campaigns']['lastmonth'][$camp->campaign_name]['spend']) ? $data['campaigns']['lastmonth'][$camp->campaign_name]['spend'] + $spent : $spent;
        }
        return $data;
    }  
    public function aboutUs()
    {
        return view('about', array('title' => 'About Us'));
    }
    public function readZip($filename)
    {
        try{
        $info = '<p>Contents:</p>';
        $zip = zip_open($filename);
        if (is_resource($zip))
        {
          while ($zip_entry = zip_read($zip))
          {
              $name = zip_entry_name($zip_entry);
              if(strpos($name, '__MACOSX') === false){
                  $info .= "<p>" . zip_entry_name($zip_entry) . "</p>";
              }
              /*
              if (zip_entry_open($zip, $zip_entry))
              {
                  $info .= "File Contents:<br/>";
                  $contents = zip_entry_read($zip_entry);
                  $info .=  "$contents<br />";
                  zip_entry_close($zip_entry);
              }
              */
          }

            zip_close($zip);
        }
        return $info;
        }catch(Exception $e){
            return '';
        }
    }
    public function myProfile()
    {
        $user = Auth::getUser();
        return view('profile', ['user' => $user, 'title' => 'User Profile']);
    }
}
