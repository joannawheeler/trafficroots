@extends('layouts.app')

@section('content')
    @if(Session::has('success'))
        <div class="alert alert-success">
            <h2>{{ Session::get('success') }}</h2>
        </div>
    @endif
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Campaign Management</div>

                <div class="panel-body">
                    <div class="panel panel-default">
                        <div class="panel-heading">Campaign {{ $campaign->id }}</div>
                        <div class="panel-body table-responsive">
                            <table class="table table-hover table-border table-striped table-condensed" name="campaigns_table" id="campaigns_table" width="100%">
                            <thead>
                            <tr><th>Campaign Name</th><th>Type</th><th>Category</th><th>Status</th><th>Location Type</th><th>Date Created</th><th>Option</th></tr>
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
                                    <a href="#" data-toggle="tooltip" title="View Campaign Stats" class="camp-stats" id="camp_stats_{{ $campaign->id }}"><i class="fa fa-bar-chart" aria-hidden="true"></i></a>&nbsp;<a href="#" data-toggle="tooltip" title="Start this Campaign" class="camp-start" id="camp_start_{{ $campaign->id }}"><i class="fa fa-play" aria-hidden="true"></i></a>&nbsp;<a href="#" data-toggle="tooltip" title="Pause this Campaign" class="camp-stop" id="camp_stop_{{ $campaign->id }}"><i class="fa fa-pause" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                   
                   
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <form name="target_form" id="target_form" role="form" class="form-horizontal" target="#" method="POST">
                         {{ csrf_field() }}                    
                       <input type="hidden" id="campaign_id" name="campaign_id" value="{{ $campaign->id }}"> 
                       <div class="panel-heading">Campaign Targeting Options</div>
                        <div class="panel-body">
                            <div class="panel-body" id="status_div"></div>
                            <div class="panel-body">
                             <p>State Targeting</p>
                             <select id="states[]" name="states[]" class="form-control" multiple>
                             {!! $states !!}
                             </select>
                            </div>
                            <div class="panel-body">
                            <p>Platform Targeting</p>
                                <select name="platform_targets[]" id="platform_targets[]" class="form-control" multiple>
                                {!! $platforms !!}
                                </select>
                            </div>
                            <div class="panel-body">
                             <p>OS Targeting</p>
                             <select id="operating_systems[]" name="operating_systems[]" class="form-control" multiple>
                             {!! $os_targets !!}
                             </select>
                            </div>
                            <div class="panel-body">
                             <p>Browser Targeting</p>
                             <select id="browser_targets[]" name="browser_targets[]" class="form-control" multiple>
                             {!! $browser_targets !!}
                             </select>
                            </div>
                            <div class="panel-body">
                             <p>Keyword Targeting</p><small>Use commas to separate</small>
                             <input name="keyword_targets" id="keyword_targets" class="form-control" type="text" value="{!! $keywords !!}">
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" id="creative_heading">Creatives</div>
                        <div class="panel-body table-responsive" id="creative_div">
                        @if (count($creatives))
                            <table class="table table-hover table-border table-striped table-condensed" name="creative_table" id="creative_table" width="100%">
                            <thead>
                            <tr><th>Description</th><th>Weight</th><th>Media</th><th>Link</th><th>Folder</th><th>Status</th><th>Date Created</th></tr>
                            </thead>
                            <tbody>
                            @foreach ($creatives as $file)
                                <tr class="creative_row" id="creative_row_{{ $file->id }}">
                                    <td>{{ $file->description }} </td>
                                    <td> {{ $file->weight }} </td>
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
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        $(".form-control").change(function(){
            var url = "{{ url('/update_targets') }}";
            var mydata = $("#target_form").serialize();
            $.post(url,mydata, function(data){
                $("#status_div").show(function(){
                    $("#status_div").html(data,function(){
                    });
                    $("#status_div").fadeOut("slow",function(){ });
                });
            });            
        });
    });

</script>
@endsection
