@extends('layouts.app')
@section('title', 'Manage Campaign')
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

<div class="content">
	<div class="row">	
		<div class="col-xs-12">
			<div class="panel panel-default">
				<a href="/campaigns" class="btn btn-primary btn-xs pull-right m-t m-r">
					<span class="fa fa-arrow-circle-left"></span>&nbsp;Back to Campaigns</a>
				<h4 class="p-title">Campaign {{ $campaign->id }}</h4>
				
				<div class="ibox-content" id="bid_status_div"></div>
				<br>
				<div class="ibox-content">
					<h2 class="text-success"><strong>Campaign Information</strong></h2>
					<table class="table tablesaw tablesaw-stack" name="campaigns_table" id="campaigns_table" data-tablesaw-mode="stack">
						<thead>
                            <tr>
								<th>Campaign Name</th>
								<th>Type</th>
								<th>Category</th>
								<th>Status</th>
								<th>Location Type</th>
								<th>Date Created</th>
								<th>Bid</th>
								<th>Daily Budget</th>
								<th>Option</th>
							</tr>
						</thead>
						<tbody>
							<tr class="camp_row" id="camp_row_{{ $campaign->id }}">
								<td class="text-center"><b class=" tablesaw-cell-label">Campaign Name</b> {{ $campaign->campaign_name }} </td>
								<td class="text-center"><b class=" tablesaw-cell-label">Type</b> {{ $campaign_types[$campaign->campaign_type] }} </td>
								<td class="text-center"><b class=" tablesaw-cell-label">Category</b> {{ $categories[$campaign->campaign_category] }} </td>
								<td class="text-center"><b class=" tablesaw-cell-label">Status</b> {{ $status_types[$campaign->status] }} </td>
								<td class="text-center"><b class=" tablesaw-cell-label">Location Type</b> {{ $location_types[$campaign->location_type] }}</td>
								<td class="text-center"><b class=" tablesaw-cell-label">Date Created</b> {{ $campaign->created_at }} </td>
								<td class="text-center"><b class=" tablesaw-cell-label">Bid</b>
									<form name="bid_form" id="bid_form" role="form" class="form-horizontal" action="/update_bid" method="POST">
									{{ csrf_field() }}
									<input type="number" id="bid" name="bid" value="{{ $campaign->bid }}" size="5">
									<input type="hidden" id="camp_id" name="camp_id" value="{{ $campaign->id }}">
									</form>
								</td>
								<td class="text-center"><b class=" tablesaw-cell-label">Daily Budget</b>
									<form name="budget_form" id="budget_form" role="form" class="form-horizontal" action="/update_budget" method="POST">
									{{ csrf_field() }}
									<input type="number" id="daily_budget" name="daily_budget" value="{{ $campaign->daily_budget }}" size="5">
									<input type="hidden" id="camp_id" name="camp_id" value="{{ $campaign->id }}">
									</form>
								</td>
				    			<td class="text-center"><b class=" tablesaw-cell-label">Option</b>
                                    <a href={{ url("stats/campaign/$campaign->id") }}" data-toggle="tooltip" title="View Campaign Stats" class="camp-stats" id="camp_stats_{{ $campaign->id }}"><i class="fa fa-bar-chart" aria-hidden="true"></i></a>
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
					<br>
					<form name="target_form" id="target_form" role="form" class="form-horizontal" target="#" method="POST">
                        	{{ csrf_field() }}
                       		<input type="hidden" id="campaign_id" name="campaign_id" value="{{ $campaign->id }}">
							<h2 class="text-success"><strong>Campaign Targeting Options</strong></h2>
							<div class="col-xs-12 form-group">
								 <label>Site Targeting</label>
								 <select id="themes[]" name="themes[]" class="chosen-select form-control state-control" data-placeholder="Choose a theme..." multiple>
								 {!! $themes !!}
								 </select>
							</div>
							<div class="col-xs-12 form-group">
								 <label>State Targeting</label>
								 <select id="states[]" name="states[]" class="chosen-select form-control state-control" data-placeholder="Choose a state..." multiple>
								 {!! $states !!}
								 </select>
							</div>
							<div class="col-xs-12 form-group">
								 <label>County Targeting</label>
								 <select id="counties" name="counties[]" class="form-control county-control" multiple>
								 {!! $counties !!}
								 </select>
							</div>
							<div class="col-xs-12 form-group">
								<label>Platform Targeting</label>
								<select name="platform_targets[]" id="platform_targets[]" class="form-control" data-placeholder="Choose platforms..." multiple>
									{!! $platforms !!}
									</select>
							</div>
							<div class="col-xs-12 form-group">
								 <label>OS Targeting</label>
								 <select id="operating_systems[]" name="operating_systems[]" class="form-control" data-placeholder="Choose operating systems..." multiple>
								 {!! $os_targets !!}
								 </select>
							</div>
							<div class="col-xs-12 form-group">
								 <label>Browser Targeting</label>
								 <select id="browser_targets[]" name="browser_targets[]" class="form-control" data-placeholder="Choose browsers..." multiple>
								 {!! $browser_targets !!}
								 </select>
							</div>
							<div class="col-xs-12 form-group">
								<label>Keyword Targeting</label><small>Use commas to separate</small>
								<input name="keyword_targets" id="keyword_targets" class="form-control" type="text" value="{!! $keywords !!}">
							</div>
						</form>
					<div class="clearfix"></div>
					<br>
					<div class="col-xs-12 no-padding">
						<button type="button" class="btn btn-primary btn-xs pull-right" id="add_creative" href="/creatives/{{ $campaign->id }}">Add Creative</button>
						<h2 class="text-success" id="creative_heading"><strong>Creatives</strong></h2>
					</div>
					<div class="col-xs-12 table-responsive" id="creative_div">
					@if (count($creatives))
						<table class="table tablesaw tablesaw-stack" name="creative_table" id="creative_table" data-tablesaw-mode="stack">
							<thead>
								<tr>
									<th>Description</th>
									<th>Media</th>
									<th>Link</th>
									<th>Status</th>
									<th>Date Created</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($creatives as $file)
								<tr class="creative_row" id="creative_row_{{ $file->id }}">
									<td class="text-center"><b class=" tablesaw-cell-label">Description</b>{{ $file->description }} </td>
									<td class="text-center"><b class=" tablesaw-cell-label">Media</b> {{ $file->media_id }} </td>
									<td class="text-center"><b class=" tablesaw-cell-label">Link</b> {{ $file->link_id }} </td>
									<td class="text-center"><b class=" tablesaw-cell-label">Status</b> {{ $status_types[$file->status] }} </td>
									<td class="text-center"><b class=" tablesaw-cell-label">Date Created</b> {{ $file->created_at }} </td>
								</tr>
								@endforeach
							</tbody>
						</table>
					@else
						<h3>No Creatives Defined</h3>
					@endif
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
