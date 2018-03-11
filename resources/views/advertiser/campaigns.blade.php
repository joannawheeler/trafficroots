@extends('layouts.app')
@section('title','- Campaigns')
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
    </style>
@endsection

@section('js')
    <script src="{{ URL::asset('js/plugins/footable/footable.all.min.js') }}"></script>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Campaigns</h5>
                    <a href="{{ URL::to('campaign') }}" class="btn btn-xs alert-success pull-right"><i class="fa fa-plus-square-o"></i>&nbsp;New Campaign</a>
                </div>
                <div class="ibox-content">
                    <div style="overflow-wrap: break-word;">
                    <input type="text" class="form-control input-sm m-b-xs" id="filter" placeholder="Search in table">

                    <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                        <thead>
                            <tr>
                                <tr>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Impressions</th>
                                    <th>Clicks</th>
                                    <th>Bid</th>
                                    <th>eCPM</th>
                                    <th>Cost</th>
                                    <th>Status</th>
                                    <th>Links</th>
                                </tr>
                        </thead>
                        <tbody>
                            @foreach ($campaigns as $campaign)
                            <tr>
                                <td>{{ $campaign->campaign_name }} </td>
                                <td>{{ $campaign->category->category }}</td>
                                <td>{{ $campaign->stats->sum('impressions') }}</td>
                                <td>{{ $campaign->stats->sum('clicks') }}</td>
                                <td>
                                    ${{ $campaign->bid }} <span class="badge"> {{ $campaign->type->campaign_type }}</span>
                                </td>
                                <td>$@if($campaign->stats->sum('impressions')){{ 
                                    number_format(
                                            $campaign->stats->reduce(function($cost, $stat) { 
                                                return $cost + (($stat->impressions / 1000) * $stat->cpm); 
                                            }) * 1000 / $campaign->stats->sum('impressions'), 2
                                        ) 
                                    }}@else()0
                                    @endif
                                    
                                </td>
                                <td>${{ number_format(
                                            $campaign->stats->reduce(function($cost, $stat) { 
                                                return $cost + (($stat->impressions / 1000) * $stat->cpm); 
                                            }), 2
                                        ) }}</td>
                                <td>{{ $campaign->status_type->description }} </td>
                                <td>
                                    <a href="{{ url("stats/campaign/$campaign->id") }}" class="campaign-stats btn btn-xs alert-info"><i class="fa fa-line-chart"></i>&nbsp;Stats
                                    </a>
                                    <a href="{{ URL::to("/manage_campaign/$campaign->id") }}" class="btn btn-xs alert-success"><i class="fa fa-edit"></i>&nbsp;Edit
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <ul class="pagination pull-right"></ul>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>
   <script type="text/javascript">
       jQuery(document).ready(function ($) {
	       $('.nav-click').removeClass("active");
	       $('#nav_buyer_campaigns').addClass("active");
	       $('#nav_buyer').addClass("active");
	       $('#nav_buyer_menu').removeClass("collapse");
       });
   </script>
@endsection
