@extends('layouts.app')
@section('title','Campaigns')
@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/github.min.css">
    <link href="{{ URL::asset('css/plugins/footable/footable.core.css') }}" rel="stylesheet">
    <style type="text/css">
        .footable th:last-child .footable-sort-indicator {
            display: none;
            pointer-events: none;
        }
        .hide {
            display: none;
        }
        .badge {
            font-size: 8px;
        }

		div.tableSearchOnly {
			padding-top: 55px;
			
		}
		.content .ibox .ibox-content {
			overflow: visible;
		}

    </style>
@endsection

@section('js')
    <script src="{{ URL::asset('js/plugins/footable/footable.all.min.js') }}"></script>
@endsection
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<h4 class="p-title">Filter</h4>
						<div class="ibox-content">
							<div class="row">
								<div class="col-xs-12 col-md-5">
<!--
							<form name="stats_form"
								  id="stats_form"
								  action="{{ url('/stats/pub') }}"
								  method="POST">
								{{ csrf_field() }}
-->
									<form name="campaign_form"
								  method="POST">
								<label>Dates</label>
								<div class="row">
									<div class="col-xs-12 form-group">
										<input hidden="true"
											   type="text"
											   name="daterange" />
										<div id="reportrange"
											 class="form-control">
											<i class="fa fa-calendar" style="float: right;"></i>
											<span></span>
										</div>
									<label class="error hide"
										   for="dates"></label>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<button type="submit" class="btn btn-primary btn-block">Submit</button>
										</div>
									</div>

									<div class="col-xs-12 col-md-6">
										<div class="form-group">
											<button type="submit" class="btn btn-danger 	btn-block" id="resetFilter">Reset Filter</button>
										</div>
									</div>
								</div>
							</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Campaigns</h5>
					<div class="pull-right">
                    	<a href="{{ URL::to('campaign') }}" class="btn btn-xs btn-primary"><i class="fa fa-plus-square-o"></i>&nbsp;&nbsp; New Campaign</a>
					</div>
                </div>
				
                <div class="ibox-content" >	
					<div class="tableSearchOnly"> 					
						<table class="tablesaw tablesaw-stack table-striped table-hover dataTableSearchOnly dateTableFilter" data-tablesaw-mode="stack">
						<thead> 
								<tr>
									<th>Name</th>
									<th>Category</th>
									<th>Impressions <span class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title=" Number of times Advertising Material is served to a person visiting the Publisher’s Website"></span></th>
									<th>Clicks</th>
									<th>Bid <span class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Amount that an advertiser is willing to pay for a click or a thousand impressions."></span></th>
									<th>Type</th>
									<th>eCPM <span class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Used to calculate the effectiveness of an advertising campaign, independently of the actual pricing model. (CPC, CPM, CPA…)."></span></th>
									<th>Cost</th>
									<th>Status</th>
									<th>Links</th>
								</tr>
                        </thead>
                        <tbody>
                            @foreach ($campaigns as $campaign)
                            <tr>
                                <td class="text-center"><b class=" tablesaw-cell-label">Name</b> {{ $campaign->campaign_name }} </td>
                                <td class="text-center"><b class=" tablesaw-cell-label">Impressions</b>{{ $campaign->category->category }}</td>
                                <td class="text-center"><b class=" tablesaw-cell-label">Impressions</b> {{ $campaign->stats->sum('impressions') }}</td>
                                <td class="text-center"><b class=" tablesaw-cell-label">Clicks</b> {{ $campaign->stats->sum('clicks') }}</td>
                                <td class="text-center"><b class=" tablesaw-cell-label">Bid</b>
                                    ${{ $campaign->bid }}
                                </td>
								<td class="text-center"><b class=" tablesaw-cell-label">Type</b>
                                    <span class="badge label">{{ $campaign->type->campaign_type }}</span>
                                </td>
                                <td class="text-center"><b class=" tablesaw-cell-label">eCPM</b> $ @if($campaign->stats->sum('impressions')){{ 
                                    number_format(
                                            $campaign->stats->reduce(function($cost, $stat) { 
                                                return $cost + (($stat->impressions / 1000) * $stat->cpm); 
                                            }) * 1000 / $campaign->stats->sum('impressions'), 2
                                        ) 
                                    }}@else()0
                                    @endif
                                    
                                </td>
                                <td class="text-center"><b class=" tablesaw-cell-label">Cost</b> ${{ number_format(
                                            $campaign->stats->reduce(function($cost, $stat) { 
                                                return $cost + (($stat->impressions / 1000) * $stat->cpm); 
                                            }), 2
                                        ) }}</td>
                                <td class="text-center"><b class=" tablesaw-cell-label">Status</b> <span class="currentStatus label">{{ $campaign->status_type->description }}</span></td>
                                <td class="text-center"><b class=" tablesaw-cell-label">Links</b>
                                    <a href="{{ url("stats/campaign/$campaign->id") }}">
										<button class="campaign-stats btn btn-xs btn-warning alert-info">
											<span class="btn-label">
												<i class="fa fa-line-chart"></i>
											</span>&nbsp; Stats
										</button>
                                    </a>
                                    <a href="{{ URL::to("/manage_campaign/$campaign->id") }}">
										<button class="btn btn-xs btn-success alert-success">
											<span class="btn-label">
												<i class="fa fa-edit"></i>
											</span> Edit</button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

					<!-- <style>
						.tooltip {
							position: relative;
							display: inline-block;
							border-bottom: 1px dotted black;
						}

						.tooltip .tooltiptext {
							visibility: hidden;
							width: 120px;
							background-color: #666;
							color: #fff;
							text-align: center;
							border-radius: 6px;
							padding: 5px 0;
							position: absolute;
							z-index: 1;
							bottom: 125%;
							left: 50%;
							margin-left: -60px;
							opacity: 50;
							transition: opacity .3s;
						}

						.tooltip .tooltiptext::after {
							content: "";
							position: absolute;
							top: 100%;
							left: 50%;
							margin-left: -5px;
							border-width: 5px;
							border-style: solid;
							border-color: #555 transparent transparent transparent;
						}

						.tooltip:hover .tooltiptext {
							visibility: visible;
							opacity: 1;
						}
					</style> -->

                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('js/plugins/flot/jquery.flot.js') }}"></script>
<script src="{{ URL::asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
   
   <script type="text/javascript">
   $(document).ready(function(){
	   $('[data-toggle="tooltip"]').tooltip();
	});
	   	$('.dataTableSearchOnly').DataTable({
			"oLanguage": {
			  "sSearch": "Search Table"
			}, pageLength: 10,
			responsive: true
		});	
	   
	   	var currentStatus = $(".currentStatus").text();
		if (currentStatus == "Active"){
			$(".currentStatus").addClass('label-primary');
		} else if (currentStatus == "Declined"){
			$(".currentStatus").addClass('label-danger');
		} else {
			$(".currentStatus").addClass('label-warning');
		}
	   
		var bidType = $(".badge").text();
		if (bidType == "CPM"){
			$(".badge").addClass('label-success');
		} else {
			$(".badge").addClass('label-danger');
		}
	   
       jQuery(document).ready(function ($) {
	       $('.nav-click').removeClass("active");
	       $('#nav_buyer_campaigns').addClass("active");
	       $('#nav_buyer').addClass("active");
	       $('#nav_buyer_menu').removeClass("collapse");
       });
   </script>
@endsection
