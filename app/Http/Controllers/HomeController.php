<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Site;
use App\Bank;
use App\User;
use App\LocationType;
use App\Category;
use App\StatusType;
use App\Folders;
use DB;

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
        return view('buyers', ['user' => $user,
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
                            'status_types' => $status_types]);
    }
    /**
     * Show the publisher`s dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $user = Auth::user();

        $sql = 'SELECT sites.*, categories.category 
                FROM sites 
                JOIN categories 
                ON sites.site_category = categories.id
                WHERE sites.user_id = '.$user->id;
        $sites = DB::select($sql); 
        return view('home', ['user' => $user,
                            'sites' => $sites]);
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
