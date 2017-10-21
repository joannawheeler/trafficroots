@extends('layouts.app')
@section('title', '- Welcome!')
@section('content')
    @if(Session::has('success'))
        <div id="alert_div" class="alert alert-success">
            <h4>{{ Session::get('success') }}</h4>
        </div>
    @endif
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title">Buyer`s Dashboard</div>

                <div class="ibox-content">
                            <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                                <li class="active"><a href="#campaign-tab" data-toggle="tab">Campaigns</a></li>
                                <li><a href="#media-tab" data-toggle="tab">Media</a></li>
                                <li><a href="#link-tab" data-toggle="tab">Links</a></li>
                                <li><a href="#folder-tab" data-toggle="tab">Folders</a></li>
                                <li><a href="#account-tab" data-toggle="tab">Account</a></li>
                                <li><a href="#support-tab" data-toggle="tab">Support</a></li>
                            </ul>
                            <div id="my-tab-content" class="tab-content">
                            <div class="tab-pane table-responsive active" id="campaign-tab">
                    <div class="ibox">
                        <div class="ibox-title">My Campaigns</div>
                        <div class="ibox-content table-responsive">
                        @if (count($campaigns))
                            <table class="table table-hover table-border table-striped table-condensed" name="campaigns_table" id="campaigns_table" width="100%">
                            <thead>
                            <tr><th>Campaign Name</th><th>Type</th><th>Category</th><th>Status</th><th>Location Type</th><th>Date Created</th><th>Stats</th></tr>
                            </thead>
                            <tbody>
                            @foreach ($campaigns as $campaign)
                                <tr class="camp_row" id="camp_row_{{ $campaign->id }}">
                                    <td>{{ $campaign->campaign_name }} </td>
                                    <td> {{ $campaign_types[$campaign->campaign_type] }} </td>
                                    <td> {{ $categories[$campaign->campaign_category] }} </td>
                                    <td> {{ $status_types[$campaign->status] }} </td>
                                    <td>{{ $location_types[$campaign->location_type] }}</td>
                                    <td> {{ $campaign->created_at }} </td>
                                    <td><a href="#" class="camp-stats" id="camp_stats_{{ $campaign->id }}"><i class="fa fa-bar-chart" aria-hidden="true"></a></i></td>
                                </tr>
                   
                            @endforeach
                   
                            </tbody>
                            </table>
                        @else
                            <h3>No Campaigns Defined</h3> 
 
                        @endif
                        <br /><br /><a href="/campaign"><button class="btn-u" type="button" id="add_site">Add A Campaign</button></a>
                        </div>
                    </div>
                    </div>
                    <div class="tab-pane table-responsive active" id="media-tab">
                    <div class="ibox">
                        <div class="ibox-title" id="creative_heading">My Media</div>
                        <div class="ibox-content table-responsive" id="media_div">
                        @if (count($media))
                            <table class="table table-hover table-border table-striped table-condensed" name="media_table" id="media_table" width="100%">
                            <thead>
                            <tr><th>Media Name</th><th>Category</th><th>Location Type</th><th>Status</th><th>Date Uploaded</th><th>Preview</th></tr>
                            </thead>
                            <tbody>
                            @foreach ($media as $file)
                                <tr class="media_row" id="media_row_{{ $file->id }}">
                                    <td>{{ $file->media_name }} </td>
                                    <td> {{ $categories[$file->category] }} </td>
                                    <td> {{ $location_types[$file->location_type] }} </td>
                                    <td> {{ $status_types[$file->status] }} </td>
                                    <td> {{ $file->created_at }} </td>
                                    <td> <a href="#" class="tr-preview" data-toggle="popover" data-html="true" data-placement="left" data-trigger="hover" title="" data-content="<img src='{{ $file->file_location }}'>" id="view_media_{{ $file->id }}"><i class="fa fa-camera-retro" aria-hidden="true"></a></i> </td>
                                </tr>
                            @endforeach
                            </tbody>
                            </table>

                        @else
                            <h3>No Media Defined</h3>
                        @endif
                        <br /><br /><a href="/media"><button class="btn-u" type="button" id="add_media">Upload Image File</button></a>
                        </div>
                    </div>
                    </div>
                    <div class="tab-pane table-responsive active" id="folder-tab">
                    <div class="ibox">
                        <div class="ibox-title" id="creative_heading">My Folders</div>
                        <div class="ibox-content table-responsive" id="folder_div">
                        @if (count($folders))
                            <table class="table table-hover table-border table-striped table-condensed" name="folders_table" id="folders_table" width="100%">
                            <thead>
                            <tr><th>Folder Name</th><th>Category</th><th>Location Type</th><th>Status</th><th>Date Uploaded</th><th>Preview</th></tr>
                            </thead>
                            <tbody>
                            @foreach ($folders as $file)
                                <tr class="media_row" id="media_row_{{ $file->id }}">
                                    <td>{{ $file->folder_name }} </td>
                                    <td> {{ $categories[$file->category] }} </td>
                                    <td> {{ $location_types[$file->location_type] }} </td>
                                    <td> {{ $status_types[$file->status] }} </td>
                                    <td> {{ $file->created_at }} </td>
                                    <td> <a href="#" class="tr-iframe" data-toggle="modal" data-target="#myModal" id="view_folder_{{ $width[$file->location_type] }}_{{ $height[$file->location_type] }}_{{ $file->file_location }}"><i class="fa fa-camera-retro" aria-hidden="true"></a></i></td>
                                </tr>
                            @endforeach
                            </tbody>
                            </table>

                        @else
                            <h3>No Folders Defined</h3>
                        @endif
                        <br /><br /><a href="/folder"><button class="btn-u" type="button" id="add_folder">Upload HTML5 Folder</button></a>
                        </div>
                    </div>
                    </div>
                    <div class="tab-pane table-responsive active" id="link-tab">
                    <div class="ibox">
                        <div class="ibox-title" id="links_heading">My Links</div>
                        <div class="ibox-content table-responsive" id="links_div">
                        @if (count($links))
                           <table class="table table-hover table-border table-striped table-condensed" name="links_table" id="links_table" width="100%">
                            <thead>
                            <tr><th>Link Name</th><th>Category</th><th>URL</th><th>Status</th><th>Date Created</th></tr>
                            </thead>
                            <tbody>
                            @foreach ($links as $link)
                                <tr class="link_row" id="link_row_{{ $link->id }}">
                                    <td>{{ $link->link_name }} </td>
                                    <td> {{ $categories[$link->category] }} </td>
                                    <td> {{ $link->url }} </td>
                                    <td> {{ $status_types[$link->status] }} </td>
                                    <td> {{ $link->created_at }} </td>
                                </tr>
                            @endforeach
                            </tbody>
                            </table>


                        @else
                            <h3>No Links Defined</h3>
                        @endif
                        <br /><br /><a href="/links"><button class="btn-u" type="button" id="add_link">Add Links</button></a>
                        </div>
                    </div>
                    </div>
                    <div class="tab-pane table-responsive" id="account-tab">
                    <div class="ibox">
                        <div class="ibox-title" id="links_heading">My Account</div>
                        <div class="ibox-content table-responsive" id="account_div">
                              <h2> Account content </h2>
                        </div>
                    </div>
                    </div>
                    <div class="tab-pane table-responsive" id="support-tab">
                    <div class="ibox">
                        <div class="ibox-title" id="links_heading">Support Tickets</div>
                        <div class="ibox-content table-responsive" id="support_div">
                              <h2> Support content </h2>
                        </div>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="mytitle">Preview</h4>
      </div>
      <div class="modal-body" id="mybody">
       <p>Content</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $.noConflict();
        $('.camp_row').click(function(){
            var str =  $(this).attr('id');
            var res = str.split("_");
            var url = '/manage_campaign/' + res[2];
            window.location.assign(url);
        });
        $('.camp-stats').click(function(){
            var str =  $(this).attr('id');
            var res = str.split("_");
            var url = '/stats/site/' + res[2] + '/1';
            window.location.assign(url);
        }); 
        $('.camp_row').hover(function() {
            $(this).css('cursor','pointer');
        });
        $('[data-toggle="popover"]').popover({
            html: true,
        });
        $('.tr-iframe').click(function(){
            var str =  $(this).attr('id');
            var res = str.split("_");
            var url = 'https://buyers.trafficroots.com' + res[4];
            $('#mybody').html('<iframe width="100%" height="100%" frameborder="0" src="' + url + '"></iframe>');
            $('#mybody').height(res[3]);
            $('#mybody').width(res[2]);
        });
        if($('#alert_div'))
        {
            $('#alert_div').fadeOut(1600, function(){

             });
        }
    });

</script>
@endsection
