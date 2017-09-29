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
        return view('advertiser.dashboard');
    }
    public function advertiserFaq()
    {
        $faqs = Faq::where('faq_type', 1)->get();
        return view('faq_advertiser', array('faqs' => $faqs));
    }
    public function publisherFaq()
    {
        return view('faq_publisher');
    }
    public function whoAmI()
    {
        $categories = Category::all();
        return view('whoami',array('categories' => $categories));
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
            'status_types' => $status_types
        ]);
    }
    public function getPubInfo($id) {
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
$sql = "SELECT 
SUM(publisher_bookings.revenue) * commission_tiers.publisher_factor AS earned,
SUM(publisher_bookings.impressions) as impressions,
SUM(publisher_bookings.clicks) as clicks,
commission_tiers.publisher_factor
FROM publisher_bookings
JOIN commission_tiers
ON publisher_bookings.commission_tier = commission_tiers.id
WHERE publisher_bookings.booking_date >= '".date('Y-m-d', strtotime('first day of this year'))."'
AND publisher_bookings.pub_id = $id
GROUP BY commission_tiers.publisher_factor;";
        $data['earned_this_year'] = 0.00;
        $data['impressions_this_year'] = 0;
        $data['clicks_this_year'] = 0;
        foreach(DB::select($sql) as $row){
            $data['earned_this_year'] += is_null($row->earned) ? 0.00 : $row->earned;
            $data['impressions_this_year'] += is_null($row->impressions) ? 0 : $row->impressions;
            $data['clicks_this_year'] += is_null($row->clicks) ? 0 : $row->clicks;            
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
        $data['last_thirty_days'][date('m/d/Y',strtotime($mydate))] = array('impressions' => 0, 'clicks' => 0, 'earnings' => 0);
        foreach(DB::select($sql) as $row){
            $earnings = $row->earned;
            $impressions = $row->impressions;
            $clicks = $row->clicks;
            $data['last_thirty_days'][date('m/d/Y',strtotime($mydate))] = array('impressions' => $impressions, 'clicks' => $clicks, 'earnings' => $earnings);
        } 
}
        $data['sites'] = array();
$sql = "SELECT
SUM(publisher_bookings.revenue) * commission_tiers.publisher_factor AS earned,
SUM(publisher_bookings.impressions) as impressions,
SUM(publisher_bookings.clicks) as clicks,
commission_tiers.publisher_factor,
sites.site_name,
COUNT(*) as days
FROM publisher_bookings
JOIN commission_tiers
ON publisher_bookings.commission_tier = commission_tiers.id
JOIN sites
ON publisher_bookings.site_id = sites.id
WHERE publisher_bookings.booking_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
AND publisher_bookings.pub_id = $id
GROUP BY commission_tiers.publisher_factor, publisher_bookings.site_id;";
        foreach(DB::select($sql) as $row){
            $data['sites'][] = $row;
        }
        return $data;
    }    /**
     * Show the publisher`s dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $pub_data = $this->getPubInfo($user->id);
        return view('home', ['user' => $user,
                            'sites' => $sites, 'pub_data' => $pub_data]);
    }
    public function aboutUs()
    {
        return view('about');
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
        return view('profile', ['user' => $user]);
    }
}
