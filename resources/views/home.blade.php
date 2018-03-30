@extends('layouts.app') 
@section('css')
@section('content')


@if($view_type == 1 || $view_type == 3)
@section('title', 'Publisher Dashboard') 
@else
@section('title', 'Advertiser Dashboard')
@endif
{{-- @if(Session::has('success'))
<div class="alert alert-success">
    <h2>{{ Session::get('success') }}</h2>
</div>
@endif  --}}
@if($view_type == 1 || $view_type == 3)
<div class="content">
    <div class="row">
        <div class="col-lg-12">
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
				<div class="col-sm-2 widget-boxs">
					<div class="ibox float-e-margins">
						<div class="ibox-title purple-bg">
							<span class="fa fa-eye"></span>
							<span>Impressions</span>
						</div>
						<div class="ibox-content">
						  <span class="totalStat">
							  {{ number_format($pub_data['impressions_this_month']) }}
							</span>
						</div>
					</div>
				</div>
				<div class="col-sm-2 widget-boxs">
					<div class="ibox float-e-margins">
						<div class="ibox-title yellow-bg">
							<span class="fa fa-location-arrow"></span>
							<span>Clicks</span>
						</div>
						<div class="ibox-content">
							<span class="totalStat">
								{{ number_format($pub_data['clicks_this_month']) }}
							</span>
						</div>
					</div>
				</div>
				<div class="col-sm-2 widget-boxs">
					<div class="ibox float-e-margins">
						<div class="ibox-title navy-bg">
							<span class="fa fa-money"></span>
							<span>Earnings</span>
						</div>
						<div class="ibox-content">
							<span class="totalStat">
								$ {{ round($pub_data['earned_this_month'],2) }}
							</span>
						</div>
					</div>
				</div>
				<div class="col-sm-2 widget-boxs">
					<div class="ibox float-e-margins">
						<div class="ibox-title blue-bg">
							<span class="fa fa-bar-chart-o"></span>
							<span>CPM</span>
						</div>
						<div class="ibox-content">
							<span class="totalStat">$ {{ round($pub_data['cpm_this_month'],2) }}</span>
						</div>
					</div>
				</div>
				<div class="col-sm-2 widget-boxs">
					<div class="ibox float-e-margins">
						<div class="ibox-title red-bg">
							<span class="fa fa-hand-o-up"></span>
							<span>CPC</span>
						</div>
						<div class="ibox-content">
							<span class="totalStat">{{ number_format($pub_data['clicks_this_month']) }}</span>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Daily Stats</h5>
							<div class="pull-right">
								<div class="btn-group">
									<button type="button" id="monthToDate" class="btn btn-xs btn-white active">Today</button>
									<button type="button" id="currentWeek" class="btn btn-xs btn-white">Week</button>
									<button type="button" id="previousMonth" class="btn btn-xs btn-white">Month</button>
								</div>
								<div ibox-tools></div>
							</div>
							<div class="ibox-content">
								<div class="row">
									<div class="col-lg-9">            
										<div class="flot-chart">
											<div class="flot-chart-content" id="flot-line-chart-multi"></div>
										</div>
									</div>
									<div class="col-lg-3" id="pub-stat-list">
									<ul class="stat-list">
										<li id="pub-impressions">
											<h2 class="no-margins"> {{ number_format($pub_data['impressions_this_month']) }} </h2>
											<small>Impressions</small>
											<div class="stat-percent"><span>
												{{ number_format($pub_data['impressions_today']) }} </span>%<i class="fa fa-level-up text-navy"></i></div>
											<div class="progress progress-mini">
												<div style="width: 48%;" class="progress-bar"></div>
											</div>
										</li>
										<li id="pub-earnings">
											<h2 class="no-margins ">$ {{ round($pub_data['earned_this_month'],2) }} </h2>
											<small>Earnings</small>
											<div class="stat-percent"><span>60</span>% <i class="fa fa-level-down text-navy"></i></div>
											<div class="progress progress-mini">
												<div style="width: 60%;" class="progress-bar"></div>
											</div>
										</li>
										<li id="pub-cpm">
											<h2 class="no-margins ">$ {{ round($pub_data['cpm_this_month'],2) }}</h2>
											<small>Cost Per Mili</small>
											<div class="stat-percent"><span>22</span>% <i class="fa fa-bolt text-navy"></i></div>
											<div class="progress progress-mini">
												<div style="width: 22%;" class="progress-bar"></div>
											</div>
										</li>
									</ul>
								</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins xs-ibox-title">
						<div class="panel panel-default">
							<div class="col-xs-12 col-md-6">
								<h4 class="p-title">Sites - {{ date('F') }}</h4>
							</div>
							<div class="col-xs-12 col-md-6 text-right" style="padding: 10px 25px;">
									<label>Update Status:</label>
									<button type="button" class="btn btn-success btn-sm">Approve</button>
									<button type="button" class="btn btn-danger btn-sm">Decline</button>
									<button type="button" class="btn btn-info btn-sm">Restore</button>
								</div>
							<div class="ibox-content">
								<div class="tableSearchOnly">
									<table class="tablesaw tablesaw-stack table-striped table-hover dataTableSearchOnly dateTableFilter" data-tablesaw-mode="stack">
									<thead>
										<tr>
											<th>Select</th>
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
											<td class="text-center">{{ $site->site_name }}</td>
											<td class="text-center"><b class=" tablesaw-cell-label">Site</b>{{ $site->site_name }}</td>
											<td class="text-center"><b class=" tablesaw-cell-label">Days Active</b>{{ $site->days_active }} </td>
											<td class="text-center"><b class=" tablesaw-cell-label">Impressions</b>{{ $site->impressions }}</td>
											<td class="text-center"><b class=" tablesaw-cell-label">Clicks</b>{{ $site->clicks }}</td>
											<td class="text-center"><b class=" tablesaw-cell-label">CPM</b>{{ $cpm = $site->impressions ? round($site->earned / ($site->impressions / 1000),2) : 0 }}</td>
											<td class="text-center"><b class=" tablesaw-cell-label">CPC</b>{{ $cpc = $site->clicks ? round($site->earned / $site->clicks,2): 0 }}</td>
											<td class="text-center"><b class=" tablesaw-cell-label">Earnings</b>{{ money_format('%(#10n',$site->earned) }}</td>
										</tr>
										@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('js')
<script language="javascript" type="text/javascript" src="{{ URL::asset('js/plugins/flot/excanvas.min.js') }}"></script>
<script>
$( document ).ready(function() {
	
	$('.dataTableSearchOnly').DataTable({
		"oLanguage": {
		  "sSearch": "Search Table"
		}, pageLength: 25,
		responsive: true
	});	
	
	
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
            label: "Impressions",
			color: "#1ab394",
			bars: {
				show: true,
				align: "center",
				barWidth: 24 * 60 * 60 * 600,
				lineWidth:0
			}
			
        }, {
            data: clicks,
            label: "Clicks",
            yaxis: 1, 
			color: "#1C84C6",
			lines: {
				lineWidth:1,
					show: true,
					fill: true,
				fillColor: {
					colors: [{
						opacity: 0.2
					}, {
						opacity: 0.4
					}]
				}
			},
			splines: {
				show: false,
				tension: 0.6,
				lineWidth: 1,
				fill: 0.1
			}
        }], {
            xaxes: [{
                mode: 'time'
            }],
            yaxes: [{
                min: 0,
				position: "left",
				color: "#d5d5d5",
				axisLabelUseCanvas: true,
				axisLabelFontSizePixels: 12,
				axisLabelFontFamily: 'Arial'				
            }, {
                // align if we are to the right
                alignTicksWithAxis: position == "right" ? 1 : null,
                position: position,
				
				//position: "right",
				clolor: "#d5d5d5",
				axisLabelUseCanvas: true,
				axisLabelFontSizePixels: 12,
				axisLabelFontFamily: ' Arial',
				axisLabelPadding: 67
				
            }],
            legend: {
                //position: 'sw',
				
				noColumns: 1,
				labelBoxBorderColor: "#000000",
				position: "nw"
            },
            colors: ["#1ab394","#1C84C6"],
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
    
    }) 
	
	$("#monthToDate").click(function(){ 
		$("#previousMonth").removeClass("active");
		$("#currentWeek").removeClass("active");
		$("#monthToDate").addClass("active");
		
		$("#pub-impressions h2").text({{ number_format($pub_data['impressions_this_month']) }});
		$("#pub-impressions .stat-percent span").text(
			{{ number_format($pub_data['impressions_this_month']) }} );
		$("#pub-impressions .progress-bar").css("width", "35%");
		$("#pub-earnings h2").text( "$" + {{ round($pub_data['earned_this_month'],2) }});
		$("#pub-earnings .stat-percent span").text(
			{{ ($pub_data['earned_this_month']) }} );
		$("#pub-earnings .progress-bar").css("width", "25%");
		
		$("#pub-cpm h2").text("$" + {{ round($pub_data['cpm_this_month'],2) }});
		$("#pub-cpm .stat-percent span").text(
			{{ number_format($pub_data['cpm_this_month']) }} );
		$("#pub-cpm .progress-bar").css("width", "11%");
	});
	
	$("#currentWeek").click(function(){ 
		$("#previousMonth").removeClass("active");
		$("#currentWeek").addClass("active");
		$("#monthToDate").removeClass("active");
		
		$("#pub-impressions h2").text({{ number_format($pub_data['impressions_this_month']) }});
		$("#pub-impressions .stat-percent span").text(
			{{ number_format($pub_data['impressions_this_month']) }} );
		$("#pub-impressions .progress-bar").css("width", "35%");
		$("#pub-earnings h2").text( "$" + {{ round($pub_data['earned_this_month'],2) }});
		$("#pub-earnings .stat-percent span").text(
			{{ ($pub_data['earned_this_month']) }} );
		$("#pub-earnings .progress-bar").css("width", "25%");
		
		$("#pub-cpm h2").text("$" + {{ round($pub_data['cpm_this_month'],2) }});
		$("#pub-cpm .stat-percent span").text(
			{{ number_format($pub_data['cpm_this_month']) }} );
		$("#pub-cpm .progress-bar").css("width", "11%");
	});
	
	$("#previousMonth").click(function(){ 
		$("#previousMonth").addClass("active");
		$("#currentWeek").removeClass("active");
		$("#monthToDate").removeClass("active");
		
		$("#pub-impressions h2").text({{ number_format($pub_data['impressions_last_month']) }});
		$("#pub-impressions .stat-percent span").text(
			{{ ($pub_data['impressions_last_month']) }} );
		$("#pub-impressions .progress-bar").css("width", "15%");
	
		$("#pub-earnings h2").text("$" + {{ round($pub_data['earned_last_month'],2) }});
		$("#pub-earnings .stat-percent span").text(
			{{ ($pub_data['impressions_today']) }} );
		$("#pub-earnings .progress-bar").css("width", "36%");
	
		$("#pub-cpm h2").text("$" + {{ round($pub_data['cpm_last_month'],2) }});
		$("#pub-cpm .stat-percent span").text(
			{{ ($pub_data['cpm_last_month']) }} );
		$("#pub-cpm .progress-bar").css("width", "75%");
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

<!-- start advertisement -->

@if($view_type == 2)
<div class="content">
    <div class="row">
        <div class="col-lg-12">
			<div class="row">
				<div class="col-xs-12">
					<h1>Test</h1>
					<div id="placeholder"></div>
				</div>
			</div>
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
							<small>Costs</small><br />
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
							<small>Costs</small><br />
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
							<small>Costs</small><br />
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
							<small>Costs</small><br />
							<div class="stat-percent font-bold text-success pull-right">$ {{ $buyer_data['cpm_last_month'] }}</div>
							<small>CPM</small><br />
							<div class="stat-percent font-bold text-success pull-right">$ {{ $buyer_data['cpc_last_month'] }}</div>
							<small>CPC</small><br />
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-2 widget-boxs">
					<div class="ibox float-e-margins">
						<div class="ibox-title purple-bg">
							<span class="fa fa-eye"></span>
							<span>Impressions</span>
						</div>
						<div class="ibox-content">
							<span class="totalStat">
							  {{ number_format($buyer_data['impressions_today']) }}
							</span>
						</div>
					</div>
				</div>
				<div class="col-sm-2 widget-boxs">
					<div class="ibox float-e-margins">
						<div class="ibox-title yellow-bg">
							<span class="fa fa-location-arrow"></span>
							<span>Clicks</span>
						</div>
						<div class="ibox-content">
							<span class="totalStat">
								{{ number_format($buyer_data['clicks_today']) }}
							</span>
						</div>
					</div>
				</div>
				<div class="col-sm-2 widget-boxs">
					<div class="ibox float-e-margins">
						<div class="ibox-title navy-bg">
							<span class="fa fa-money"></span>
							<span>Costs</span>
						</div>
						<div class="ibox-content">
							<span class="totalStat">
								$ {{ $buyer_data['spent_today'] }}
							</span>
						</div>
					</div>
				</div>
				<div class="col-sm-2 widget-boxs">
					<div class="ibox float-e-margins">
						<div class="ibox-title blue-bg">
							<span class="fa fa-bar-chart-o"></span>
							<span>CPM</span>
						</div>
						<div class="ibox-content">
							<span class="totalStat">$ {{ $buyer_data['cpm_today'] }}</span>
						</div>
					</div>
				</div>
				<div class="col-sm-2 widget-boxs">
					<div class="ibox float-e-margins">
						<div class="ibox-title red-bg">
							<span class="fa fa-hand-o-up"></span>
							<span>CPC</span>
						</div>
						<div class="ibox-content">
							<span class="totalStat">$ {{ $buyer_data['cpc_today'] }}</span>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Daily Stats</h5>
							<div class="pull-right">
								<div class="btn-group">
									<button type="button" class="btn btn-xs btn-white btn-today active">Today</button>
									<button type="button" class="btn btn-xs btn-white btn-week">Week</button>
									<button type="button" class="btn btn-xs btn-white btn-month">Month</button>
								</div>
							<div ibox-tools></div>
						</div>
						<div class="ibox-content">
							<div class="row">
									<div class="col-lg-9">
										<div class="flot-chart">
											<div class="flot-chart-content" id="flot-line-chart-multi"></div>
										</div>
									</div>

								<div class="col-lg-3">
									<ul class="stat-list">
										<li>
											<h2 class="no-margins"> {{ number_format($buyer_data['impressions_today']) }} </h2>
											<small>Impressions</small>
											<div class="stat-percent"> {{ number_format($buyer_data['impressions_today']) }}%<i class="fa fa-level-up text-navy"></i></div>
											<div class="progress progress-mini">
												<div style="width: 48%;" class="progress-bar"></div>
											</div>
										</li>
										<li>
											<h2 class="no-margins "> $ {{ $buyer_data['cpc_today'] }} </h2>
											<small>Cost Per Click</small>
											<div class="stat-percent">60% <i class="fa fa-level-down text-navy"></i></div>
											<div class="progress progress-mini">
												<div style="width: 60%;" class="progress-bar"></div>
											</div>
										</li>
										<li>
											<h2 class="no-margins ">{{ round($buyer_data['ctr_today'],2) }}</h2>
											<small>Click Through Rate</small>
											<div class="stat-percent">22% <i class="fa fa-bolt text-navy"></i></div>
											<div class="progress progress-mini">
												<div style="width: 22%;" class="progress-bar"></div>
											</div>
										</li>
									</ul>
								</div>
							</div>

						</div>
					</div>
				</div>
				</div>
			</div>

			<div class="row">
					<div class="col-md-5">
						<div class="panel panel-default">
							<h5 class="p-title">Campaigns</h5>
							<div class="ibox-content">
								<h4>Dates:</h4>
								<div id="date_filter">
									<input class="date_range_filter date" type="hidden" id="datepicker_from" />
									<input class="date_range_filter date" type="hidden" id="datepicker_to" />
								</div>
								<div class="row">
									<div class="col-xs-12">
										<input type="text" class="form-control dateRangeFilter">
										<span class="glyphicon glyphicon-calendar fa fa-calendar dateRangeIcon"></span>
									</div>
									<div class="col-xs-12 col-md-6">
										<br>
										<button type="submit" class="btn btn-primary btn-block" id="filterSubmit">Submit</button>

									</div>
									<div class="col-xs-12 col-md-6">
										<br>
										<button type="submit" class="btn btn-danger btn-block" id="resetFilter">Reset Filter</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="panel panel-default">
							<a href="javascript:void" onclick="return showThisMonth();" class="lastmonth"><span class="label label-info pull-right lastmonth m-t m-r" style="display:none">Show This Month</span></a>
							<a href="javascript:void" onclick="return showLastMonth();" class="thismonth"><span class="label label-info pull-right thismonth m-t m-r">Show Last Month</button></a>
							<h4 id="table_this_month" class="thismonth p-title">Campaigns - {{ date('F') }}</h4>
							<h4 id="table_this_month" class="lastmonth p-title" style="display:none">Campaigns - {{ date('F',strtotime('last month')) }}</h4>
							<div class="ibox-content">
								<div class="tableSearchOnly">
									<table class="tablesaw tablesaw-stack table-striped table-hover dataTableSearchOnly dateTableFilter" data-tablesaw-mode="stack">
									<thead>
										<tr>
											<th>Campaign</th>
											<th>Days Active</th>
											<th>Impressions</th>
											<th>Clicks</th>
											<th>Costs</th>
										</tr>
									</thead>
									<tbody>
									@foreach($buyer_data['campaigns']['thismonth'] as $key => $campaign)
										<tr class='thismonth'>
											<td>{{ $key }}</td>
											<td>{{ $campaign['days_active'] }} </td>
											<td>{{ $campaign['impressions'] }}</td>
											<td>{{ $campaign['clicks'] }}</td>
											<td>{{ money_format('%(#10n',$campaign['costs']) }}</td>
										</tr>
									@endforeach
									@foreach($buyer_data['campaigns']['lastmonth'] as $key => $campaign)
										<tr class='lastmonth' style="display:none">
											<td>{{ $key }}</td>
											<td>{{ $campaign['days_active'] }} </td>
											<td>{{ $campaign['impressions'] }}</td>
											<td>{{ $campaign['clicks'] }}</td>
											<td>{{ money_format('%(#10n',$campaign['costs']) }}</td>
										</tr>
									@endforeach
									</tbody>
								</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('js')
<script language="javascript" type="text/javascript" src="{{ URL::asset('js/plugins/float/excanvas.min.js') }}"></script>
<script>
$( document ).ready(function() {
	
	$('.dataTableSearchOnly').DataTable({
		"oLanguage": {
		  "sSearch": "Search Table"
		}, pageLength: 25,
		responsive: true
	});	
	
	$(".btn-today").click(function(){ 
		$(".btn-week").removeClass("active");
		$(".btn-month").removeClass("active");
		$(".btn-today").addClass("active");
	});
	
	$(".btn-week").click(function(){ 
		$(".btn-today").removeClass("active");
		$(".btn-month").removeClass("active");
		$(".btn-week").addClass("active");
	});
	
	$(".btn-month").click(function(){ 
		$(".btn-week").removeClass("active");
		$(".btn-today").removeClass("active");
		$(".btn-month").addClass("active");
	});
});
	
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
            colors: ["#1C84C6","#1ab394"],
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
