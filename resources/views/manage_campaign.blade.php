@extends('layouts.app')
@section('title', '- Campaigns')
@section('css')
<link rel="stylesheet"
      href="{{ URL::asset('css/plugins/select2/select2.min.css') }}">
<link rel="stylesheet"
      href="{{ URL::asset('css/plugins/chosen/chosen.css') }}">
@endsection

@section('js')
<script src="{{ URL::asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
@endsection

@section('content')
    @if(Session::has('success'))
        <div class="alert alert-success">
            <h2>{{ Session::get('success') }}</h2>
        </div>
    @endif
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="ibox">
                <div class="ibox-title"><i class="fa fa-sitemap"></i>&nbsp;Campaign Management
                <div class="pull-right">
                <a href="/campaigns"><span class="label label-success"><i class="fa fa-bolt"></i>&nbsp;Return To Menu</span></a>
                </div>
                </div>
                <div class="ibox-content">
                    <div class="ibox">
                        <div class="ibox-title">Campaign {{ $campaign->id }}</div>
                        <div class="ibox-content" id="bid_status_div"></div>
                        <div class="ibox-content table-responsive">
                            <table class="table table-hover table-border table-striped table-condensed" name="campaigns_table" id="campaigns_table" width="100%">
                            <thead>
                            <tr><th>Campaign Name</th><th>Type</th><th>Category</th><th>Status</th><th>Location Type</th><th>Date Created</th><th>Bid</th><th>Daily Budget</th><th>Option</th></tr>
                            </thead>
                            <tbody>
                                <tr class="camp_row" id="camp_row_{{ $campaign->id }}">
                                    <td>{{ $campaign->campaign_name }} </td>
                                    <td> {{ $campaign_types[$campaign->campaign_type] }} </td>
                                    <td> {{ $categories[$campaign->campaign_category] }} </td>
                                    <td> {{ $status_types[$campaign->status] }} </td>
                                    <td>{{ $location_types[$campaign->location_type] }}</td>
                                    <td> {{ $campaign->created_at }} </td>
                                    <td>
                                        <form name="bid_form" id="bid_form" role="form" class="form-horizontal" action="/update_bid" method="POST">
                                        {{ csrf_field() }}
                                        <input type="number" id="bid" name="bid" value="{{ $campaign->bid }}" size="5">
                                        <input type="hidden" id="camp_id" name="camp_id" value="{{ $campaign->id }}">
                                        </form>
                                    </td>
                                    <td>
                                        <form name="budget_form" id="budget_form" role="form" class="form-horizontal" action="/update_budget" method="POST">
                                        {{ csrf_field() }}
                                        <input type="number" id="daily_budget" name="daily_budget" value="{{ $campaign->daily_budget }}" size="5">
                                        <input type="hidden" id="camp_id" name="camp_id" value="{{ $campaign->id }}">
                                        </form>
                                    </td>
				    <td>
                                    <a href="#" data-toggle="tooltip" title="View Campaign Stats" class="camp-stats" id="camp_stats_{{ $campaign->id }}"><i class="fa fa-bar-chart" aria-hidden="true"></i></a>
@if( $campaign->status == 3)
&nbsp;<a href="#" data-toggle="tooltip" title="Start this Campaign" class="camp-start" id="camp_start_{{ $campaign->id }}"><i class="fa fa-play" aria-hidden="true"></i></a>
@endif
@if( $campaign->status == 1)
&nbsp;<a href="#" data-toggle="tooltip" title="Pause this Campaign" class="camp-stop" id="camp_stop_{{ $campaign->id }}"><i class="fa fa-pause" aria-hidden="true"></i></a>
@endif
                                    </td>
                                </tr>
                   
                   
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="ibox">
                        <form name="target_form" id="target_form" role="form" class="form-horizontal" target="#" method="POST">
                         {{ csrf_field() }}                    
                       <input type="hidden" id="campaign_id" name="campaign_id" value="{{ $campaign->id }}"> 
                       <div class="ibox-title"><i class="fa fa-crosshairs"></i>&nbsp;Campaign Targeting Options</div>
                        <div class="ibox-content">
                            <div class="ibox-content">
                             <p>State Targeting</p>
                             <select id="states[]" name="states[]" class="chosen-select form-control state-control" data-placeholder="Choose a state..." multiple>
                             {!! $states !!}
                             </select>
                            </div>
                            <div class="ibox-content">
                             <p>County Targeting</p>
                             <select id="counties" name="counties[]" class="form-control county-control" multiple>
                             {!! $counties !!}
                             </select>
                            </div>
			    <div class="ibox-content">
                            <p>Platform Targeting</p>
                                <select name="platform_targets[]" id="platform_targets[]" class="form-control" data-placeholder="Choose platforms..." multiple>
                                {!! $platforms !!}
                                </select>
                            </div>
                            <div class="ibox-content">
                             <p>OS Targeting</p>
                             <select id="operating_systems[]" name="operating_systems[]" class="form-control" data-placeholder="Choose operating systems..." multiple>
                             {!! $os_targets !!}
                             </select>
                            </div>
                            <div class="ibox-content">
                             <p>Browser Targeting</p>
                             <select id="browser_targets[]" name="browser_targets[]" class="form-control" data-placeholder="Choose browsers..." multiple>
                             {!! $browser_targets !!}
                             </select>
                            </div>
                            <div class="ibox-content">
                             <p>Keyword Targeting</p><small>Use commas to separate</small>
                             <input name="keyword_targets" id="keyword_targets" class="form-control" type="text" value="{!! $keywords !!}">
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="ibox">
                        <div class="ibox-title" id="creative_heading">Creatives</div>
                        <div class="ibox-content table-responsive" id="creative_div">
                        @if (count($creatives))
                            <table class="table table-hover table-border table-striped table-condensed" name="creative_table" id="creative_table" width="100%">
                            <thead>
                            <tr><th>Description</th><th>Media</th><th>Link</th><th>Folder</th><th>Status</th><th>Date Created</th></tr>
                            </thead>
                            <tbody>
                            @foreach ($creatives as $file)
                                <tr class="creative_row" id="creative_row_{{ $file->id }}">
                                    <td>{{ $file->description }} </td>
                                    <td> {{ $file->media_id }} </td>
                                    <td> {{ $file->link_id }} </td>
                                    <td> {{ $file->folder_id }} </td>
                                    <td> {{ $status_types[$file->status] }} </td>
                                    <td> {{ $file->created_at }} </td>
                                </tr>
                            @endforeach
                            </tbody>
                            </table>

                        @else
                            <h3>No Creatives Defined</h3>
                        @endif
                        <br /><br /><a href="/creatives/{{ $campaign->id }}"><button class="btn-u" type="button" id="add_creative">Add Creative</button></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function ($) {
	$('[data-toggle="tooltip"]').tooltip();
        $(".form-control").change(function () {
            var url = "{{ url('/update_targets') }}";
            var mydata = $("#target_form").serialize();
            $.post(url, mydata)
                .done(function (response) {
                    toastr.success(response);
                })
                .fail(function (response) {
                    toastr.error(response);
                });
        });
	$(".state-control").change(function () {
	    $('#counties').html('');
            var url = "{{ url('/update_counties') }}";
            var mydata = $("#target_form").serialize();
            $.post(url, mydata)
		.done(function (response) {
	            alert(response);
                    $('#counties').html(response);
                })
                .fail(function (response) {
                    toastr.error(response);
                });
        });
	$("#bid").change(function () {
            var url = "{{ url('/update_bid') }}";
            var mydata = $("#bid_form").serialize();
            $.post(url, mydata)
                .done(function (response) {
			toastr.success(response.result);
			if(response.bid_class == 'success') toastr.info(response.bid_range, "Bid Status");
                        if(response.bid_class == 'info') toastr.info(response.bid_range, "Bid Status");
                        if(response.bid_class == 'warning') toastr.warning(response.bid_range, "Bid Status");
                        if(response.bid_class == 'danger') toastr.error(response.bid_range, "Bid Status");
                        
                })
                .fail(function (response) {
                    toastr.error(response.result);
                });
	});
        $("#daily_budget").change(function () {
	    var url = "{{ url('/update_budget') }}";
	    var mydata = $("#budget_form").serialize();
	    $.post(url, mydata)
		.done(function (response) {
                    toastr.success(response);
                })
                .fail(function (response) {
		    toastr.error(response);
                });
        });		    
        $('.camp-start').click(function() {
            if(confirm('Activate this campaign?')){
                var str =  $(this).attr('id');
                var res = str.split("_");
                var url = '/campaign/start/' + res[2];
                $.get(url)
                    .done(function (response) {
                        toastr.success(response, function(){
                          setTimeout(function(){ window.location.reload(); }, 3000);   
                        });
                    })
                    .fail(function (response) {
                        toastr.error(response);
                    });
            }else{
                return false;
            }
            
        });
        $('.camp-stop').click(function() {
            if(confirm('Pause this campaign?')){
                var str =  $(this).attr('id');
                var res = str.split("_");
                var url = '/campaign/pause/' + res[2];
                $.get(url)
                    .done(function (response) {
                        toastr.success(response, function(){
                          setTimeout(function(){ window.location.reload(); }, 3000);
                        });
                    })
                    .fail(function (response) {
                        toastr.error(response);
                    });
            }else{
                return false;
            }

        });
    });
</script>
   <script type="text/javascript">
       jQuery(document).ready(function ($) {
	       $('.nav-click').removeClass("active");
	       $('#nav_buyer_campaigns').addClass("active");
	       $('#nav_buyer').addClass("active");
	       $('#nav_buyer_menu').removeClass("collapse");
	       toastr.options = {
	         "closeButton": true,
	         "debug": false,
                 "progressBar": true,
		 "preventDuplicates": false,
		 "positionClass": "toast-top-right",
		 "onclick": null,
		 "showDuration": "400",
		 "hideDuration": "1000",
		 "timeOut": "10000",
		 "extendedTimeOut": "1000",
		 "showEasing": "swing",
		 "hideEasing": "linear",
		 "showMethod": "fadeIn",
		 "hideMethod": "fadeOut"
	       }
	       @if($bid_class == 'success')
               toastr.info("{{ $bid_range }}", "Bid Status");
	       @endif
	       @if($bid_class == 'info')
               toastr.info("{{ $bid_range }}", "Bid Status");
	       @endif
	       @if($bid_class == 'warning')
               toastr.warning("{{ $bid_range }}", "Bid Status");
	       @endif
	       @if($bid_class == 'danger')
               toastr.error("{{ $bid_range }}", "Bid Status");
	       @endif
       });
   </script>
@endsection
