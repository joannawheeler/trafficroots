<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PublicController extends Controller
{

    public function aboutUs()
    {
        return view('about');
    }    //

    public function getLandingPage()
    {
        /* u.s. data */
        $sql = "SELECT SUM(impressions) as impressions, state 
                FROM site_analysis
                JOIN states ON site_analysis.state = states.state_name
                WHERE geo = 'US'
                AND legal = 1
                GROUP BY state
                ORDER BY impressions DESC
                LIMIT 20;";
         $result = DB::select($sql);
         $targeted_traffic = 0;
         foreach($result as $row){
             $targeted_traffic += $row->impressions;

         }
         $us_display = '<table id="us_table" class="table table-border table-hover table-stripe"><thead><tr><th>Chunk</th><th>State</th></tr></thead><tbody>';
         foreach($result as $row){
             $factor = round(($row->impressions / $targeted_traffic) * 100, 2);
             $us_display .= '<tr><td>'.$factor.' %</td><td>'.$row->state.'</td></tr>';
         }
         $us_display .= '</tbody></table>';

        /* global data */
        $sql = "SELECT SUM(impressions) as impressions, countries.country_name 
                FROM site_analysis
                JOIN countries ON site_analysis.geo = countries.country_short
                WHERE countries.targeted = 1
                GROUP BY country_name
                ORDER BY impressions DESC
                LIMIT 20;";
         $result = DB::select($sql);
         $targeted_traffic = 0;
         foreach($result as $row){
             $targeted_traffic += $row->impressions;

         }
         $geo_display = '<table id="geo_table" class="table table-border table-hover table-stripe"><thead><tr><th>Chunk</th><th>Country</th></tr></thead><tbody>';
         foreach($result as $row){
             $factor = round(($row->impressions / $targeted_traffic) * 100, 2);
             $geo_display .= '<tr><td>'.$factor.' %</td><td>'.$row->country_name.'</td></tr>';
         }
         $geo_display .= '</tbody></table>';

        return view('landing',['us_display' => $us_display, 'geo_display' => $geo_display]);
    }

}
