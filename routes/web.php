<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/pixel/{handle?}', 'PixelController@getIndex');
Route::get('/analysis/{handle}', 'SiteController@analyzeSite'); 
Auth::routes();
Route::get('/about', 'PublicController@aboutUs');
Route::get('/home', 'HomeController@index');
Route::get('/sites', 'SiteController@index');
Route::post('/sites', 'SiteController@postSite');
Route::get('/zones', 'ZoneController@index');
Route::post('/zones', 'ZoneController@postZone');
Route::get('/getzones/{site_id}', 'ZoneController@getZones');
Route::get('/addzone/{site_id}', 'ZoneController@addZone');
Route::post('/addzone/{site_id}', 'ZoneController@postZone');
Route::get('/stats/zone/{zone_id}/{range}', 'StatsController@getZoneStats');
Route::get('/stats/site/{site_id}/{range}', 'StatsController@getSiteStats');
Route::get('/tickets', 'TicketController@index');
Route::post('/tickets', 'TicketController@store');
Route::get('/service/{handle}/{keywords?}', 'AdserverController@getIndex');
