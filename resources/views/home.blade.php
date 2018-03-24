@extends('layouts.app') 
@section('content')
@if($view_type == 1 || $view_type == 3)
@section('title', '- Publisher Dashboard') 
@else
@section('title', '- Advertiser Dashboard')
@endif
{{-- @if(Session::has('success'))
<div class="alert alert-success">
    <h2>{{ Session::get('success') }}</h2>
</div>
@endif  --}}
@if($view_type == 1 || $view_type == 3)
<div class="row">
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">{{ Carbon\Carbon::now()->format('F jS') }}</span>
                <h5>Today</h5>
            </div>
            <div class="ibox-content">
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($pub_data['impressions_today']) }}</div>
                <small>Impressions</small><br />
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($pub_data['clicks_today']) }}</div>
                <small>Clicks</small><br />                
                <div class="stat-percent font-bold text-success pull-right">$ {{ round($pub_data['earned_today'],2) }}</div>
                <small>Earnings</small><br />
                <div class="stat-percent font-bold text-success">$ {{ round($pub_data['cpm_today'],2) }}</div>
                <small>CPM</small>                
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">{{ Carbon\Carbon::now()->format('F') }}</span>
                <h5>This Month</h5>
            </div>
            <div class="ibox-content">
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($pub_data['impressions_this_month']) }}</div>
                <small>Impressions</small><br />
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($pub_data['clicks_this_month']) }}</div>
                <small>Clicks</small><br />                
                <div class="stat-percent font-bold text-success pull-right">$ {{ round($pub_data['earned_this_month'],2) }}</div>
                <small>Earnings</small><br />
                <div class="stat-percent font-bold text-success pull-right">$ {{ round($pub_data['cpm_this_month'],2) }}</div>
                <small>CPM</small>  
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">{{ date('F', strtotime('last month')) }}</span>
                <h5>Last Month</h5>
            </div>
            <div class="ibox-content">
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($pub_data['impressions_last_month']) }}</div>
                <small>Impressions</small><br />
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($pub_data['clicks_last_month']) }}</div>
                <small>Clicks</small><br />                
                <div class="stat-percent font-bold text-success pull-right">$ {{ round($pub_data['earned_last_month'],2) }}</div>
                <small>Earnings</small><br />
                <div class="stat-percent font-bold text-success pull-right">$ {{ round($pub_data['cpm_last_month'],2) }}</div>
                <small>CPM</small>  
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">{{ date('Y') }}</span>
                <h5>This Year</h5>
            </div>
            <div class="ibox-content">
                <div class="stat-percent font-bold text-success">{{ number_format($pub_data['impressions_this_year']) }}</div>
                <small>Impressions</small><br />
                <div class="stat-percent font-bold text-success">{{ number_format($pub_data['clicks_this_year']) }}</div>
                <small>Clicks</small><br />                
                <div class="stat-percent font-bold text-success">$ {{ round($pub_data['earned_this_year'],2) }}</div>
                <small>Earnings</small><br />
                <div class="stat-percent font-bold text-success">$ {{ round($pub_data['cpm_this_year'],2) }}</div>
                <small>CPM</small>  
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Daily Stats</h5>
                <div ibox-tools></div>
            </div>
            <div class="ibox-content">
                            <div class="flot-chart">
                                <div class="flot-chart-content" id="flot-line-chart-multi"></div>
                            </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Sites - {{ date('F') }}</h5>
            </div>
            <div class="ibox-content">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Site</th>
                            <th>Days Active</th>
                            <th>Impressions</th>
                            <th>Clicks</th>
                            <th>CPM</th>
                            <th>CPC</th>
                            <th>Earnings</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($pub_data['sites'] as $site)
                        <tr>
                            <td>{{ $site->site_name }}</td>
                            <td>{{ $site->days_active }} </td>
                            <td>{{ $site->impressions }}</td>
                            <td>{{ $site->clicks }}</td>
                            <td>{{ $cpm = $site->impressions ? round($site->earned / ($site->impressions / 1000),2) : 0 }}</td>
                            <td>{{ $cpc = $site->clicks ? round($site->earned / $site->clicks,2): 0 }}</td>
                            <td>{{ money_format('%(#10n',$site->earned) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script> 
    $(function(){
	    var impressions = [
		    @foreach($pub_data['last_thirty_days'] as $key => $value)
		        [{{$value['timestamp']}},{{$value['impressions']}}],
		    @endforeach
	    ];
	    var clicks = [
		    @foreach($pub_data['last_thirty_days'] as $key => $value)
		        [{{$value['timestamp']}},{{$value['clicks']}}],
	            @endforeach
	    ];
    function doPlot(position) {
        $.plot($("#flot-line-chart-multi"), [{
            data: impressions,
            label: "Impressions"
        }, {
            data: clicks,
            label: "Clicks",
            yaxis: 1
        }], {
            xaxes: [{
                mode: 'time'
            }],
            yaxes: [{
                min: 0
            }, {
                // align if we are to the right
                alignTicksWithAxis: position == "right" ? 1 : null,
                position: position
            }],
            legend: {
                position: 'sw'
            },
            colors: ["blue","green"],
            grid: {
                color: "#999999",
                hoverable: true,
                clickable: true,
                tickColor: "#D4D4D4",
                borderWidth:0,
                hoverable: true //IMPORTANT! this is needed for tooltip to work,

            },
            tooltip: true,
            tooltipOpts: {
                content: "%s for %x were %y",
                xDateFormat: "%m-%d-%Y",

                onHover: function(flotItem, $tooltipEl) {
                    console.log(flotItem, $tooltipEl);
                }
            }

        });
    }

    doPlot("right");

    $("button").click(function() {
        doPlot($(this).text());
    });
    
    });    
</script>
   <script type="text/javascript">
       jQuery(document).ready(function ($) {
	       $('.nav-click').removeClass("active");
	       $('#nav_pub_dashboard').addClass("active");
	       $('#nav_pub').addClass("active");
	       $('#nav_pub_menu').removeClass("collapse");
       });
   </script>
@endif
@if($view_type == 2)
<div class="row">
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">{{ Carbon\Carbon::now()->format('F jS') }}</span>
                <h5>Today</h5>
            </div>
            <div class="ibox-content">
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($buyer_data['impressions_today']) }}</div>
                <small>Impressions</small><br />
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($buyer_data['clicks_today']) }}</div>
                <small>Clicks</small><br />                
                <div class="stat-percent font-bold text-success pull-right">{{ round($buyer_data['ctr_today'],2) }}</div>
                <small>CTR</small><br />
                <div class="stat-percent font-bold text-success pull-right">$ {{ $buyer_data['spent_today'] }}</div>
                <small>Spend</small><br />
                <div class="stat-percent font-bold text-success">$ {{ $buyer_data['cpm_today'] }}</div>
                <small>CPM</small><br />
                <div class="stat-percent font-bold text-success pull-right">$ {{ $buyer_data['cpc_today'] }}</div>
                <small>CPC</small><br />
                <div class="stat-percent font-bold text-success pull-right">$ {{ $buyer_data['current_balance'] }}</div>
                <small>Remaining Balance</small>                
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">{{ date('F jS',strtotime('yesterday')) }}</span>
                <h5>Yesterday</h5>
            </div>
            <div class="ibox-content">
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($buyer_data['impressions_yesterday']) }}</div>
                <small>Impressions</small><br />
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($buyer_data['clicks_yesterday']) }}</div>
                <small>Clicks</small><br />
                <div class="stat-percent font-bold text-success pull-right">{{ $buyer_data['ctr_yesterday'] }}</div>
                <small>CTR</small><br />                
                <div class="stat-percent font-bold text-success pull-right">$ {{ round($buyer_data['spent_yesterday'],2) }}</div>
                <small>Spend</small><br />
                <div class="stat-percent font-bold text-success pull-right">$ {{ $buyer_data['cpm_yesterday'] }}</div>
                <small>CPM</small><br />
                <div class="stat-percent font-bold text-success pull-right">$ {{ $buyer_data['cpc_yesterday'] }}</div>
                <small>CPC</small><br />
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">{{ date('F') }}</span>
                <h5>This Month</h5>
            </div>
            <div class="ibox-content">
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($buyer_data['impressions_this_month']) }}</div>
                <small>Impressions</small><br />
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($buyer_data['clicks_this_month']) }}</div>
                <small>Clicks</small><br />
                <div class="stat-percent font-bold text-success pull-right">{{ $buyer_data['ctr_this_month'] }}</div>
                <small>CTR</small><br />                
                <div class="stat-percent font-bold text-success pull-right">$ {{ round($buyer_data['spent_this_month'],2) }}</div>
                <small>Spend</small><br />
                <div class="stat-percent font-bold text-success pull-right">$ {{ $buyer_data['cpm_this_month'] }}</div>
                <small>CPM</small><br />
                <div class="stat-percent font-bold text-success pull-right">$ {{ $buyer_data['cpc_this_month'] }}</div>
                <small>CPC</small><br />
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">{{ date('F', strtotime('last month')) }}</span>
                <h5>Last Month</h5>
            </div>
            <div class="ibox-content">
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($buyer_data['impressions_last_month']) }}</div>
                <small>Impressions</small><br />
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($buyer_data['clicks_last_month']) }}</div>
                <small>Clicks</small><br />
                <div class="stat-percent font-bold text-success pull-right">{{ $buyer_data['ctr_last_month'] }}</div>
                <small>CTR</small><br />                
                <div class="stat-percent font-bold text-success pull-right">$ {{ round($buyer_data['spent_last_month'],2) }}</div>
                <small>Spend</small><br />
                <div class="stat-percent font-bold text-success pull-right">$ {{ $buyer_data['cpm_last_month'] }}</div>
                <small>CPM</small><br />
                <div class="stat-percent font-bold text-success pull-right">$ {{ $buyer_data['cpc_last_month'] }}</div>
                <small>CPC</small><br />
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Daily Stats</h5>
                <div ibox-tools></div>
            </div>
            <div class="ibox-content">
                            <div class="flot-chart">
                                <div class="flot-chart-content" id="flot-line-chart-multi"></div>
                            </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5 id="table_this_month" class="thismonth">Campaigns - {{ date('F') }}</h5>
                <h5 id="table_this_month" class="lastmonth" style="display:none">Campaigns - {{ date('F',strtotime('last month')) }}</h5>
                <a href="javascript:void" onclick="return showThisMonth();" class="lastmonth"><span class="label label-info pull-right lastmonth" style="display:none">Show This Month</span></a>
                <a href="javascript:void" onclick="return showLastMonth();" class="thismonth"><span class="label label-info pull-right thismonth">Show Last Month</button></a>
            </div>
            <div class="ibox-content">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Campaign</th>
                            <th>Days Active</th>
                            <th>Impressions</th>
                            <th>Clicks</th>
                            <th>Spend</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($buyer_data['campaigns']['thismonth'] as $key => $campaign)
                        <tr class='thismonth'>
                            <td>{{ $key }}</td>
                            <td>{{ $campaign['days_active'] }} </td>
                            <td>{{ $campaign['impressions'] }}</td>
                            <td>{{ $campaign['clicks'] }}</td>
                            <td>{{ money_format('%(#10n',$campaign['spend']) }}</td>
                        </tr>
                    @endforeach
                    @foreach($buyer_data['campaigns']['lastmonth'] as $key => $campaign)
                        <tr class='lastmonth' style="display:none">
                            <td>{{ $key }}</td>
                            <td>{{ $campaign['days_active'] }} </td>
                            <td>{{ $campaign['impressions'] }}</td>
                            <td>{{ $campaign['clicks'] }}</td>
                            <td>{{ money_format('%(#10n',$campaign['spend']) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    function showThisMonth(){
        $(".lastmonth").hide();
        $(".thismonth").show();
        return false;
    }
    function showLastMonth(){
        $(".thismonth").hide();
        $(".lastmonth").show();
        return false;
    }
    $(function(){
	    var impressions = [
		    @foreach($buyer_data['last_thirty_days'] as $key => $value)
		        [{{$value['timestamp']}},{{$value['impressions']}}],
		    @endforeach
	    ];
	    var clicks = [
		    @foreach($buyer_data['last_thirty_days'] as $key => $value)
		        [{{$value['timestamp']}},{{$value['clicks']}}],
	            @endforeach
	    ];
    function doPlot(position) {
        $.plot($("#flot-line-chart-multi"), [{
            data: impressions,
            label: "Impressions"
        }, {
            data: clicks,
            label: "Clicks",
            yaxis: 1
        }], {
            xaxes: [{
                mode: 'time'
            }],
            yaxes: [{
                min: 0
            }, {
                // align if we are to the right
                alignTicksWithAxis: position == "right" ? 1 : null,
                position: position
            }],
            legend: {
                position: 'sw'
            },
            colors: ["blue","green"],
            grid: {
                color: "#999999",
                hoverable: true,
                clickable: true,
                tickColor: "#D4D4D4",
                borderWidth:0,
                hoverable: true //IMPORTANT! this is needed for tooltip to work,

            },
            tooltip: true,
            tooltipOpts: {
                content: "%s for %x were %y",
                xDateFormat: "%m-%d-%Y",

                onHover: function(flotItem, $tooltipEl) {
                    console.log(flotItem, $tooltipEl);
                }
            }

        });
    }

    doPlot("right");

    $("button").click(function() {
        doPlot($(this).text());
    });
    
    });
</script>
   <script type="text/javascript">
       jQuery(document).ready(function ($) {
	       $('.nav-click').removeClass("active");
	       $('#nav_buyer_dashboard').addClass("active");
	       $('#nav_buyer').addClass("active");
	       $('#nav_buyer_menu').removeClass("collapse");
	       @if(session('status'))
		       toastr.success('{{session('status')}}');
	       @endif
       });
   </script>
@endif
@endsection
