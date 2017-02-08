<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Site;
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
     * Show the application dashboard.
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
        return view('home',['user' => $user, 'sites' => $sites]);
    }
    public function aboutUs()
    {
        return view('about');
    }
}
