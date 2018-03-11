<?php
use App\Site;
?>
@extends('layouts.app')

@section('title','- Sites')

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
@if(sizeof($pending))
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h5>Pending Campaigns</h5></div>
            <div class="ibox-content">
                <div class="row"><div class="col-lg-3">Site</div><div class="col-lg-3">Campaign</div><div class="col-lg-3">Advertiser</div><div class="col-lg-3">Options</div></div>
                @foreach ($pending as $pend)
                <div class="row">
                    <div class="col-lg-3">
                       {{ $pend->site_name }}
                    </div>
                    <div class="col-lg-3">
                       {{ $pend->campaign_name }}
                    </div>
                    <div class="col-lg-3">
                       {{ $pend->name }}
                    </div>
                    <div class="col-lg-3">
                                <button class="btn btn-xs alert-success activate-bid" id="activate_bid_{{ $pend->id }}"><i class="fa fa-check-square-o"></i> Activate</button>&nbsp;<a href="/preview/{{ $pend->id }}" target="_blank"><button class="btn btn-xs alert-info"><i class="fa fa-camera-retro"></i> Preview</button></a>&nbsp;<button class="btn btn-xs alert-danger decline-bid" id="decline_bid_{{ $pend->id }}"><i class="fa fa-times-circle-o"></i> Decline</button>
                    </div>
                </div>
                
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Sites</h5>
                <div class="pull-right">
                    <button type="button"
                            class="btn btn-xs alert-success"
                            data-toggle="modal"
                            data-target="#addSite"><i class="fa fa-plus-square-o"></i> Add Site</button>
                    <div class="modal inmodal"
                         id="addSite"
                         tabindex="-1"
                         role="dialog"
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content animated fadeIn">
                                <div class="modal-header">
                                    <button type="button"
                                            class="close"
                                            data-dismiss="modal">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                    </button>
                                    <h4 class="modal-title"><i class="fa fa-plus-square-o"></i> New site</h4>
                                </div>
                                <form name="site_form"
                                      id="site_form"
                                      action="{{ url('/sites') }}"
                                      method="POST">
                                    <div class="modal-body">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text"
                                                   placeholder="Enter your site name"
                                                   class="form-control"
                                                   name="site_name"
                                                   required>
                                            <label class="error hide"
                                                   for="site_name"></label>
                                        </div>
                                        <div class="form-group">
                                            <label>Url</label>
                                            <input type="text"
                                                   placeholder="Enter your site url"
                                                   class="form-control"
                                                   name="site_url"
                                                   required>
                                            <label class="error hide"
                                                   for="site_url"></label>
                                        </div>
                                        <div class="form-group">
                                            <label>Site Category</label>
                                            <select class="form-control m-b chosen-select"
						    name="site_category"
                                                    placeholder="Choose this Site's Category"
						    required>
                                                <option value="">Choose this Site's Category</option>
                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                                                @endforeach
                                            </select>
                                            <label class="error hide"
                                                   for="site_category"></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="allowed_category[]">Advertising Categories Allowed</label>
                                            <select class="form-control m-b chosen-select"
                                                    name="allowed_category[]"
						    id="allowed_category[]"
                                                    placeholder="Select Categories Allowed on this Site"
                                                    multiple
                                                    required>
                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                                                @endforeach
                                            </select>
                                            <label class="error hide"
                                                   for="allowed_category[]"></label>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox"
                                                       class="i-check"
                                                       name="zone_create">
                                                <i></i> Automatically create standard Zones for me
                                            </label>
                                            <label class="error hide"
                                                   for="zone_create"></label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button"
                                                class="btn btn-white"
                                                data-dismiss="modal">Cancel</button>
                                        <button type="submit"
                                                class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox-content">
                <div style="overflow-wrap: break-word;">
                    <input type="text"
                           class="form-control input-sm m-b-xs"
                           id="filter"
                           placeholder="Search in table">

                    <table class="footable table table-stripped"
                           data-page-size="8"
                           data-filter=#filter>
                        <thead>
                            <tr>
                                <tr>
                                    <th>Site Name</th>
                                    <th>Site Url</th>
                                    <th>Site Category</th>
                                    <th>Links</th>
                                </tr>
                        </thead>
                        <tbody>
                            @foreach ($sites as $site)
                            <tr>
                                <td>{{ $site->site_name }} </td>
                                <td>{{ $site->site_url }}</td>
                                <td>{{ $categories->where('id',$site->site_category)->first()->category }}</td>
                                <td data-site_id="{{ $site->id }}">
                                    <a href="#"
                                       class="site-zones">
                                        <button class="btn btn-xs alert-info"><i class="fa fa-newspaper-o"></i> Zones</button>
                                    </a>
                                    <a href="{{ url("stats/site/".$site->id) }}" class="site-stats">
                                        <button class="btn btn-xs alert-warning"><i class="fa fa-line-chart"></i> Stats</button>
                                    </a>
                                    <a href="#"
                                       class="site-edit"
                                       data-toggle="modal"
                                       data-target="#editSite{{ $site->id }}">
                                        <button class="btn btn-xs alert-success"><i class="fa fa-edit"></i> Edit</button>
                                    </a>
                                    <a href="#"
                                       class="site-pixel"
                                       data-toggle="modal"
                                       data-target="#sitePixel{{ $site->id }}">
                                        <button class="btn btn-xs alert-info"><i class="fa fa-file-code-o"></i> Pixel</button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
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
@foreach($sites as $site)
    <div class="row zones hide"
         id="zones{{ $site->id }}">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{ $site->site_name }}</h5>
                    <div class="pull-right">
                        <button type="button"
                                class="btn btn-xs btn-primary"
                                data-toggle="modal"
                                data-target="#addZone{{ $site->id }}">Add Zone</button>
                        <div class="modal inmodal"
                             id="addZone{{ $site->id }}"
                             tabindex="-1"
                             role="dialog"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content animated fadeIn">
                                    <div class="modal-header">
                                        <button type="button"
                                                class="close"
                                                data-dismiss="modal">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <h4 class="modal-title"><i class="fa fa-plus-square-o"></i> New Zone</h4>
                                    </div>
                                    <form name="zone_form"
                                          id="zone_form"
                                          action="{{ url("sites/$site->id/zones") }}" method="POST">
                                        <div class="modal-body">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text"
                                                       placeholder="Enter your zone name"
                                                       value="{{ old('zone_name') }}"
                                                       class="form-control"
                                                       name="description"
                                                       required>

                                                <label class="error hide"
                                                       for="zone_name"></label>
                                            </div>
                                            <div class="form-group">
                                                <label>Type</label>
                                                <select class="form-control m-b chosen-select"
                                                        value="{{ old('location_type') }}"
                                                        name="location_type"
                                                        required>
                                                    <option value="">Choose zone type</option>
                                                    @foreach($locationTypes as $locationType)
                                                    <option value="{{ $locationType->id }}">{{ $locationType->width . 'x' . $locationType->height . ' ' . $locationType->description }}</option>
                                                    @endforeach
                                                </select>

                                                <label class="error hide"
                                                       for="site_category"></label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"
                                                    class="btn btn-white"
                                                    data-dismiss="modal">Cancel</button>
                                            <button type="submit"
                                                    class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <input type="text"
                           class="form-control input-sm m-b-xs"
                           id="filter"
                           placeholder="Search in table">

                    <table class="footable table table-stripped"
                           id="zonesTable"
                           data-page-size="8"
                           data-filter=#filter>
                        <thead>
                            <tr>
                                <tr>
                                    <th>Zone Name</th>
                                    <th>Location Type</th>
                                    <th>Size</th>
                                    <th>Links</th>
                                </tr>
                        </thead>
                        <tbody>
                            @foreach ($site->zones as $zone)
                            <tr>
                                <td>{{ $zone->description }} </td>
                                <td>{{ $locationTypes->where('id',$zone->location_type)->first()->description }} </td>
                                <td>{{ $locationTypes->where('id',$zone->location_type)->first()->width . 'x' . $locationTypes->where('id',$zone->location_type)->first()->height }} </td>
                                <td data-zone_id="{{ $zone->id }}">
                                    <a href="/stats/zone/{{ $zone->id }}"
                                       class="zone-stats">
                                        <button class="btn btn-xs alert-info"><i class="fa fa-line-chart"></i> Stats</button>
                                    </a>
                                    <a href="#"
                                       class="zone-edit"
                                       data-toggle="modal"
                                       data-target="#editZone{{ $zone->id }}">
                                        <button class="btn btn-xs alert-success"><i class="fa fa-edit"></i> Edit</button>
                                    </a>
                                    <a href="#"
                                       class="zone-code"
                                       data-toggle="modal"
                                       data-target="#zoneCode{{ $zone->id }}">
                                        <button class="btn btn-xs alert-info"><i class="fa fa-file-code-o"></i> Code</span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <ul class="pagination pull-right"></ul>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal inmodal"
         id="sitePixel{{ $site->id }}"
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
                    <h4 class="modal-title"><i class="fa fa-file-code-o"></i> Site Analysis Pixel</h4>
                </div>
                <div class="modal-body">
                    <h3>Your Traffic Roots Analysis Pixel</h3>
                    <div style="overflow-wrap: break-word;">
                        <pre><code class="html">{{ htmlspecialchars('<img alt="Traffic Roots Pixel" src="'.env('APP_URL', 'http://localhost').'/pixel/'.$site->site_handle.'" style="display:none;">') }}
                        </code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal inmodal"
         id="editSite{{ $site->id }}"
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
                    <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Site</h4>
                </div>
                <form name="site_form"
                      id="site_form"
                      action="{{ url("sites/$site->id") }}" method="POST"> {{ method_field('PATCH') }}
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text"
                                   placeholder="Enter your site name"
                                   value="{{ $site->site_name }}"
                                   class="form-control"
                                   name="site_name"
                                   required>

                            <label class="error hide"
                                   for="site_name"></label>
                        </div>
                        <div class="form-group">
                            <label>Url</label>
                            <input type="text"
                                   placeholder="Enter your site url"
                                   value="{{ $site->site_url }}"
                                   class="form-control"
                                   name="site_url"
                                   required>

                            <label class="error hide"
                                   for="site_url"></label>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control m-b chosen-select"
                                    value="{{ $site->site_category }}"
                                    name="site_category"
                                    required>
                                @foreach($categories as $category)
                                <option @if($category->id == $site->site_category) selected="selected" @endif value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                            </select>

                            <label class="error hide"
                                   for="site_category"></label>
			</div>

                                        <div class="form-group">
                                            <label for="allowed_category[]">Advertising Categories Allowed</label>
                                            <select class="form-control m-b chosen-select"
                                                    name="allowed_category[]"
						    id="allowed_category[]"
                                                    placeholder="Select Categories Allowed on this Site"
                                                    multiple
                                                    required>
                                                @foreach($categories as $category)
                                                <option @if(Site::join('site_category', 'sites.id', '=', 'site_category.site_id')->where('sites.id', $site->id)->where('site_category.category', $category->id)->count() > 0) selected="selected" @endif value="{{ $category->id }}">{{ $category->category }}</option>
                                                @endforeach
                                            </select>
                                            <label class="error hide"
                                                   for="allowed_category[]"></label>
                                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-white"
                                data-dismiss="modal">Cancel</button>
                        <button type="submit"
                                class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @foreach($site->zones as $zone)
        <?php 
            $width = $locationTypes->where('id',$zone->location_type)->first()->width; 
            $height = $locationTypes->where('id',$zone->location_type)->first()->height;
        ?>
        <div class="modal inmodal"
             id="editZone{{ $zone->id }}"
             tabindex="-1"
             role="dialog"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated fadeIn">
                    <div class="modal-header">
                        <button type="button"
                                class="close"
                                data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
			<h4 class="modal-title"><i class="fa fa-edit"></i> Edit Zone</h4>
                    </div>
                    <form name="site_form"
                          id="site_form"
                          action="{{ url("zones/$zone->id") }}" method="POST"> {{ method_field('PATCH') }}
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text"
                                       placeholder="Enter your zone name"
                                       value="{{ $zone->description }}"
                                       class="form-control"
                                       name="description"
                                       required>

                                <label class="error hide"
                                       for="description"></label>
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <div>{{ $locationTypes->where('id',$zone->location_type)->first()->description }}</div>
                                <label class="error hide"
                                       for="site_category"></label>
                            </div>
                            <div class="form-group">
                                <label>Size</label>
                                <div>{{ $locationTypes->where('id',$zone->location_type)->first()->width . 'x' . $locationTypes->where('id',$zone->location_type)->first()->height }}</div>
                                <label class="error hide"
                                       for="site_category"></label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                    class="btn btn-white"
                                    data-dismiss="modal">Cancel</button>
                            <button type="submit"
                                    class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal inmodal"
             id="zoneCode{{ $zone->id }}"
             tabindex="-1"
             role="dialog"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated fadeIn">
                    <div class="modal-header">
                        <button type="button"
                                class="close"
                                data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title"><i class="fa fa-file-code-o"></i> Zone Invocation Code</h4>
                    </div>
                    <div class="modal-body">
                        <h3>Place this code in your site's layout:</h3>
                        <div style="overflow-wrap: break-word;">
                            <pre><code class="html">{{ htmlspecialchars('<div class="tr_'.$zone->handle.'" data-width="'.$width.'" data-height="'.$height.'"><script>var tr_handle = "'.$zone->handle.'";</script><script src="//service.trafficroots.com/js/service.js"></script></div>') }}
                            </code></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endforeach
<script type="text/javascript">
        $('.activate-bid').click(function() {
            if(confirm('Activate this campaign?')){
                var str =  $(this).attr('id');
                var res = str.split("_");
                var url = '/activate_bid/' + res[2];
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
        $('.decline-bid').click(function() {
            if(confirm('Decline this campaign?')){
                var str =  $(this).attr('id');
                var res = str.split("_");
                var url = '/decline_bid/' + res[2];
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
    
        $("select").chosen({
                search_contains : true, // kwd can be anywhere
                max_shown_results : 5, // show only 5 suggestions at a time
                width: "95%",
                no_results_text: "Oops, nothing found!"
            } );

</script>
   <script type="text/javascript">
       jQuery(document).ready(function ($) {
	       $('.nav-click').removeClass("active");
	       $('#nav_pub_sites').addClass("active");
	       $('#nav_pub').addClass("active");
	       $('#nav_pub_menu').removeClass("collapse");
       });
   </script>

@endsection
