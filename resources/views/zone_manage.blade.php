<?php
use App\Site;
use App\Zone;
use App\AdCreative;
?>
@extends('layouts.app')

@section('title','Zone Management')
@section('css')
<link rel="stylesheet"
      href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/github.min.css">
<link href="{{ URL::asset('css/plugins/footable/footable.core.css') }}"
      rel="stylesheet">
<link href="{{ URL::asset('css/plugins/iCheck/custom.css') }}"
      rel="stylesheet">
<style type="text/css">
.footable th:last-child .footable-sort-indicator {
    display: none;
}
</style>
<link rel="stylesheet"
      href="{{ URL::asset('css/plugins/select2/select2.min.css') }}">
<link rel="stylesheet"
      href="{{ URL::asset('css/plugins/chosen/chosen.css') }}">
@endsection

@section('js')
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
<script src="{{ URL::asset('js/plugins/footable/footable.all.min.js') }}"></script>
<script>
hljs.initHighlightingOnLoad();
</script>
<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>Manage Zone {{$zone->handle}}</h2></div>
            <div class="ibox-content">
            <table class="footable table table-striped">           
	    <thead><tr><th>Ad</th><th>Weight</th><th>Creatives</th><th>Options</th></tr></thead>
            <tbody>
	    @foreach($ads as $ad)
            @if($ad->buyer_id)
            <tr><td>{{$ad->description}}</td><td>{{$ad->weight}}</td><td>Creatives</td><td>&nbsp;</td></tr>
            @else
            <tr><td>{{$ad->description}}</td><td>{{$ad->weight}}</td><td>TrafficRoots RTB</td><td>&nbsp;</td></tr>
            @endif
            @endforeach
            </tbody>
	    </table>
            <div class="ibox-content">
	    <div class="pull-right">
				    <a href="#"
                                       class="new-ad"
                                       data-toggle="modal"
                                       data-target="#newAd">
                                        <button class="btn btn-xs alert-info"><i class="fa fa-file-code-o"></i> Create Custom Ad</button>
                                    </a>
            </div>
            </div>
            </div>
        </div>
         <div class="ibox">
            <div class="ibox-title"><h2>Knowledge Base</h2></div>
            <div class="ibox-content">
            <ul>
                <li>The "Default" Ad is the TrafficRoots RTB System.</li>
                <li>Each newly created Zone starts with 100% weight on the Default Ad.</li>
		<li>You can create your own <a href ="javascript:void;" title="A `Custom Ad` is a Publisher controlled, targeted campaign, configured to take some or all of the traffic weight on a given zone">Custom Ads</a>, directing traffic where you wish.</li>
                <li>Each Custom Ad can have One or Multiple <a href="javascript:void;" title="A `Creative` is a combination of a Media banner/image and a destination Link">Creatives</a></li>
		<li>You are responsible for the content of your Custom Ads.</li>
                <li>Weight of the Default Ad can be reduced to 0, but it cannot be removed.</li>
                <li>Once a Custom Ad has traffic, it can only be soft-deleted.</li>
            </ul>
            </div>
	</div>
   </div>
</div>

    <div class="modal inmodal"
         id="newAd"
         tabindex="-1"
         role="dialog"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button"
                            class="btn close"
                            data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title"><i class="fa fa-file-code-o"></i> Create a new Custom Ad</h4>
                </div>
                <div class="modal-body">
                    <h3>Required Data</h3>
                    <div style="ibox-content">
			<form name="custom_ad_form" id="custom_ad_form" action="/custom_ad" method="POST">
                        <div class="form-group">
                        <label for="description">Name / Description</label>
			<input class="form-control" type="text" maxlength="64" id="description" name="description" value="" required>
                        </div>
                        <div class="form-group">
                        <label for="weight">Ad Weight</label>
			<input class="form-control" type="number" id="weight" name="weight" value="0" required>
                        </div>
                        <div class="form-group">
                        <label for="country_id">Geo Targeting</label>
			<select class="form-control chosen chosen-multi" id="country_id" name="country_id[]">
                        {!! $countries !!}
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="state_id">State Targeting</label>
			<select class="form-control chosen chosen-multi" id="state_id" name="state_id[]" multiple><option value="0" selected>All States</option>
                        
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="county_id">County Targeting</label>
			<select class="form-control chosen chosen-multi" id="county_id" name="county_id[]" multiple><option value="0" selected>All Counties</option>
                        
			</select>
                        </div>
                        <div class="form-group">
                        <label for="device_id">Device Targeting</label>
			<select class="form-control chosen chosen-multi" id="device_id" name="device_id[]" multiple>
                        {!! $devices !!}
                        </select>
                        </div>

                        </div>

			{{ csrf_field() }}
                        <div class="form-group">
			<input class="form-control" type="submit" id="submit_custom_ad"  value="Submit">
                        </div>
                      
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>




   <script type="text/javascript">
       jQuery(document).ready(function ($) {
	   $('.nav-click').removeClass("active");
	   $('#nav_pub_sites').addClass("active");
	   $('#nav_pub').addClass("active");
	   $('#nav_pub_menu').removeClass("collapse");

       });
   </script>
@endsection
