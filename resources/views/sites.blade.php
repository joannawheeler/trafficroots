@extends('layouts.app')
@section('title','Sites')
@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/github.min.css">
    <link href="{{ URL::asset('css/plugins/footable/footable.core.css') }}" rel="stylesheet">
    <style type="text/css">
        .footable th:last-child .footable-sort-indicator {
            display: none;
        }
        .hide {
            display: none;
        }
    </style>
@endsection

@section('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
    <script src="{{ URL::asset('js/plugins/footable/footable.all.min.js') }}"></script>
    <script>hljs.initHighlightingOnLoad();</script>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Sites</h5>
                    <div class="pull-right">
                        <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addSite">Add Site</button>
                        <div class="modal inmodal" id="addSite" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content animated fadeIn">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <h4 class="modal-title">New site</h4>
                                    </div>
                                    <form name="site_form" id="site_form" action="{{ url('/sites') }}" method="POST">
                                        <div class="modal-body">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" placeholder="Enter your site name" class="form-control" name="site_name" required>
                                                <label class="error hide" for="site_name"></label>
                                            </div>
                                            <div class="form-group">
                                                <label>Url</label>
                                                <input type="text" placeholder="Enter your site url" class="form-control" name="site_url" required>
                                                <label class="error hide" for="site_url"></label>
                                            </div>
                                            <div class="form-group">
                                                <label>Category</label>
                                                <select class="form-control m-b" name="site_category" required>
                                                    <option value="">Choose Site Category</option>
                                                    @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                                    @endforeach
                                                </select>
                                                <label class="error hide" for="site_category"></label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div style="overflow-wrap: break-word;">
                    <input type="text" class="form-control input-sm m-b-xs" id="filter" placeholder="Search in table">

                    <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
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
                                    <a href="#" class="site-zones">
                                        <span class="label label-success">Zones</span>
                                    </a>
                                    <a href="{{ url("stats/site/$site->id") }}" class="site-stats">
                                        <span class="label label-info">Stats</span>
                                    </a>
                                    <a href="#" class="site-edit" data-toggle="modal" data-target="#editSite{{ $site->id }}">
                                        <span class="label">Edit</span>
                                    </a>
                                     <a href="#" class="site-pixel" data-toggle="modal" data-target="#sitePixel{{ $site->id }}">
                                        <span class="label label-success">Pixel</span>
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
        <div class="row zones hide" id="zones{{ $site->id }}">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{ $site->site_name }}</h5>
                        <div class="pull-right">
                            <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addZone{{ $site->id }}">Add Zone</button>
                            <div class="modal inmodal" id="addZone{{ $site->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content animated fadeIn">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span aria-hidden="true">&times;</span>
                                                <span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="modal-title">New Zone</h4>
                                        </div>
                                        <form name="zone_form" id="zone_form" action="{{ url("sites/$site->id/zones") }}" method="POST">
                                            <div class="modal-body">
                                                {{ csrf_field() }}
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" placeholder="Enter your zone name" value="{{ old('zone_name') }}" class="form-control" name="description" required>

                                                    <label class="error hide" for="zone_name"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    <select class="form-control m-b" value="{{ old('site_category') }}" name="location_type" required>
                                                        <option value="">Choose zone type</option>
                                                        @foreach($locationTypes as $locationType)
                                                            <option value="{{ $locationType->id }}">{{ $locationType->width . 'x' . $locationType->height . ' ' . $locationType->description }}</option>
                                                        @endforeach
                                                    </select>

                                                    <label class="error hide" for="site_category"></label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <input type="text" class="form-control input-sm m-b-xs" id="filter" placeholder="Search in table">

                        <table class="footable table table-stripped" id="zonesTable" data-page-size="8" data-filter=#filter>
                            <thead>
                                <tr>
                                    <tr>
                                        <th>Zone Name</th>
                                        <th>Category</th>
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
                                        <a href="/stats/zone/{{ $zone->id }}" class="zone-stats">
                                            <span class="label label-info">Stats</span>
                                        </a>
                                        <a href="#" class="zone-edit" data-toggle="modal" data-target="#editZone{{ $zone->id }}">
                                            <span class="label">Edit</span>
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
            <div class="modal inmodal" id="sitePixel{{ $site->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content animated fadeIn">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title">Site Analysis Pixel</h4>
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
            <div class="modal inmodal" id="editSite{{ $site->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content animated fadeIn">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title">Edit Site</h4>
                        </div>
                        <form name="site_form" id="site_form" action="{{ url("sites/$site->id") }}" method="POST"> 
                            {{ method_field('PATCH') }}
                            <div class="modal-body">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" placeholder="Enter your site name" value="{{ $site->site_name }}" class="form-control" name="site_name" required>

                                    <label class="error hide" for="site_name"></label>
                                </div>
                                <div class="form-group">
                                    <label>Url</label>
                                    <input type="text" placeholder="Enter your site url" value="{{ $site->site_url }}" class="form-control" name="site_url" required>

                                    <label class="error hide" for="site_url"></label>
                                </div>
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control m-b" value="{{ $site->site_category }}" name="site_category" required>
                                        @foreach($categories as $category)
                                        <option @if($category->id == $site->site_category) selected="selected" @endif value="{{ $category->id }}">{{ $category->category }}</option>
                                        @endforeach
                                    </select>

                                    <label class="error hide" for="site_category"></label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @foreach($site->zones as $zone)
            <div class="modal inmodal" id="editZone{{ $zone->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content animated fadeIn">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title">Edit Zone</h4>
                        </div>
                        <form name="site_form" id="site_form" action="{{ url("zones/$zone->id") }}" method="POST"> 
                            {{ method_field('PATCH') }}
                            <div class="modal-body">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" placeholder="Enter your zone name" value="{{ $zone->description }}" class="form-control" name="description" required>

                                    <label class="error hide" for="description"></label>
                                </div>
                                <div class="form-group">
                                    <label>Type</label>
                                    <div>{{ $locationTypes->where('id',$zone->location_type)->first()->description }}</div>
                                    <label class="error hide" for="site_category"></label>
                                </div>
                                <div class="form-group">
                                    <label>Size</label>
                                    <div>{{ $locationTypes->where('id',$zone->location_type)->first()->width . 'x' . $locationTypes->where('id',$zone->location_type)->first()->height }}</div>
                                    <label class="error hide" for="site_category"></label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach;
        </div>
        
    @endforeach
@endsection