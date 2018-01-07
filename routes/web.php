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
// OAuth Routes
Route::get('auth/{driver}', ['as' => 'socialAuth', 'uses' => 'Auth\SocialController@redirectToProvider']);
Route::get('auth/{driver}/callback', ['as' => 'socialAuthCallback', 'uses' => 'Auth\SocialController@handleProviderCallback']);

$landing = function() {
    Route::get('/', 'PublicController@getLandingPage');
    Route::post('/buyer_subscribe', 'PublicController@subscribeUser');
    Route::post('/pub_subscribe', 'PublicController@subscribeUser');
};
Route::group(['domain' => 'www.trafficroots.com'], $landing);
Route::group(['domain' => 'trafficroots.com'], $landing);

Route::get('/', function () {
    return redirect('/home');
});
Route::get('/pub_type', 'HomeController@pubType');
Route::get('/buyer_type', 'HomeController@buyerType');
Route::get('/both_type', 'HomeController@bothType');
Route::post('/subscribe', 'PublicController@subscribeUser');
//Route::get('/fblogin/{facebook}/{user_id}/{name}/{email}', 'FacebookController@login');
//Route::get('/glogin/{google}/{name}/{email}', 'GoogleController@login');
Route::get('/landing', 'PublicController@getLandingPage');
Route::get('/pixel/{handle?}', 'PixelController@getIndex');
Route::get('/analysis/{handle}', 'SiteController@analyzeSite'); 
Auth::routes();
Route::get('/charge', 'ChargeController@index');
Route::get('/about', 'PublicController@aboutUs');
Route::get('/home', 'HomeController@index');
Route::get('/advertiser', 'HomeController@advertiser');
Route::get('/campaigns', 'CampaignController@campaigns');
Route::get('/buyers/{tab?}', 'HomeController@buyers');
Route::get('/sites', 'SiteController@index');
Route::post('/sites', 'SiteController@store');
Route::patch('/sites/{site}', 'SiteController@edit');
Route::patch('/zones/{zone}', 'ZoneController@edit');
Route::get('/stats/site/{site}', 'StatsController@site');
Route::get('/stats/zone/{zone}', 'StatsController@zone');
Route::post('sites/{site}/zones', 'ZoneController@store');
Route::get('/stats/pub', 'StatsController@pub');
Route::post('/stats/pub', 'StatsController@filtered');
Route::get('/stats/campaign/{campaign}', 'StatsController@campaign');
Route::post('/stats/campaign', 'StatsController@campaign');
Route::get('/getzones/{site_id}', 'ZoneController@getZones');
Route::post('/getzones', 'ZoneController@postGetZones');
Route::get('/addzone/{site_id}', 'ZoneController@addZone');
Route::post('/addzone/{site_id}', 'ZoneController@postZone');
Route::get('/stats/zone/{zone_id}/{range}', 'StatsController@getZoneStats');
// Route::get('/stats/site/{site_id}/{range}', 'StatsController@getSiteStats');
Route::get('/tickets', 'TicketController@index');
Route::post('/tickets', 'TicketController@store');
Route::get('/service/{handle}/{keywords?}', 'AdserverController@getIndex');
Route::get('/click/{querystr}', 'AdserverController@clickedMe');
Route::get('/profile', 'HomeController@myProfile');
Route::get('/confirm/{handle}', 'ConfirmController@confirm');
Route::get('/campaign', 'CampaignController@createCampaign');
Route::get('/campaign/start/{id}', 'CampaignController@startCampaign');
Route::get('/campaign/pause/{id}', 'CampaignController@pauseCampaign');
Route::post('/campaign', 'CampaignController@postCampaign');
Route::get('/media', 'CampaignController@createMedia');
Route::post('/media', 'CampaignController@postMedia');
Route::get('/links', 'CampaignController@createLink');
Route::post('/links', 'CampaignController@postLink');
Route::get('manage_campaign/{id}', 'CampaignController@editCampaign');
Route::get('/creatives/{id}', 'CampaignController@createCreative');
Route::post('/creatives', 'CampaignController@postCreative');
Route::post('/update_targets', 'CampaignController@updateTargets');
Route::post('/update_bid', 'CampaignController@updateBid');
Route::post('/update_budget', 'CampaignController@updateBudget');
Route::get('/folder', 'CampaignController@createFolder');
Route::post('/folder', 'CampaignController@postFolder');
Route::get('/whoami', 'HomeController@whoAmI');
Route::get('/activate_bid/{id}', 'SiteController@activateBid');
Route::get('/decline_bid/{id}', 'SiteController@declineBid');
Route::get('/preview/{id}', 'SiteController@previewBid');
Route::get('/library', 'CampaignController@getLibrary');
Route::get('/faq_advertiser', 'HomeController@advertiserFaq');
Route::get('/faq_publisher', 'HomeController@publisherFaq');
/* paypal routes */
Route::get('/paywithpaypal', array('as' => 'addmoney.paywithpaypal','uses' => 'AddMoneyController@payWithPaypal',));
Route::post('paypal', array('as' => 'addmoney.paypal','uses' => 'AddMoneyController@postPaymentWithpaypal',));
Route::get('paypal', array('as' => 'payment.status','uses' => 'AddMoneyController@getPaymentStatus',));

/* velocity routes */
Route::get('/addfunds', array('as' => 'addmoney.paybycceftjs', 'uses' => 'CreditAchController@getIndex',));
Route::post('/deposit', array('as' => 'addmoney.deposit', 'uses' => 'CreditAchController@depositFunds',));
//Route::get('/addfunds', array('as' => 'addmoney.paybycceft', 'uses' => 'CreditAchController@getIndex',));
//Route::post('/addfunds', array('as' => 'addmoney.postcceft', 'uses' => 'CreditAchController@postMoney',));
