@extends('layouts.app')

@section('title','- Library')

@section('content')
    @if(Session::has('success'))
        <div id="alert_div" class="alert alert-success">
            <h4>{{ Session::get('success') }}</h4>
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title">Library</div>
                <div class="ibox-content">
                    <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                        <li><a href="#media-tab" data-toggle="tab">Media</a></li>
                        <li><a href="#link-tab" data-toggle="tab">Links</a></li>
                        @if($allow_folders)
                        <li><a href="#folder-tab" data-toggle="tab">Folders</a></li>
                        @endif
                    </ul>
                    <div id="my-tab-content" class="tab-content">
                    <div class="tab-pane table-responsive active" id="media-tab">
                    <div class="ibox">
                        <div class="ibox-title" id="creative_heading">My Media <div class="pull-right">@include('media_upload')</div></div>
                        <div class="ibox-content table-responsive" id="media_div">
                                @if (count($media))
                                    <table class="table table-hover table-border table-striped table-condensed" name="media_table" id="media_table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Media Name</th>
                                            <th>Category</th>
                                            <th>Location Type</th>
                                            <th>Status</th>
                                            <th>Date Uploaded</th>
                                            <th>Preview</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($media as $file)
                                        <tr class="media_row" id="media_row_{{ $file->id }}">
                                            <td>{{ $file->media_name }} </td>
                                            <td> {{ $categories[$file->category] }} </td>
                                            <td> {{ $location_types[$file->location_type] }} </td>
                                            <td> {{ $status_types[$file->status] }} </td>
                                            <td> {{ Carbon\Carbon::parse($file->created_at)->toDayDateTimeString() }} </td>
                                            <td> <a href="#" class="tr-preview" data-toggle="popover" data-html="true" data-placement="left" data-trigger="hover" title="" data-content="<img src='https://publishers.trafficroots.com/{{ $file->file_location }}' width='120' height='120'>" id="view_media_{{ $file->id }}"><i class="fa fa-camera-retro" aria-hidden="true"></a></i> </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    </table>
                                @else
                                    <h3>No Media Defined</h3>
                                @endif                         
                        </div>

                    </div>                        
                    </div>
                    <div class="tab-pane table-responsive active" id="link-tab">
                    <div class="ibox">
                                <div class="ibox-title" id="links_heading">My Links<div class="pull-right">@include('link_upload')</div></div>
                                <div class="ibox-content table-responsive" id="links_div">
                                @if (count($links))
                                   <table class="table table-hover table-border table-striped table-condensed" name="links_table" id="links_table" width="100%">
                                    <thead>
                                    <tr><th>Link Name</th><th>Category</th><th>URL</th><th>Status</th><th>Date Created</th></tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($user->getLinks() as $link)
                                        <tr class="link_row" id="link_row_{{ $link->id }}">
                                            <td>{{ $link->link_name }} </td>
                                            <td> {{ $categories[$link->category] }} </td>
                                            <td> <a href="{{ $link->url }}" target="blank">{{substr($link->url,0,25)}}</a></td>
                                            <td> {{ $status_types[$link->status] }} </td>
                                            <td> {{ Carbon\Carbon::parse($link->created_at)->toDayDateTimeString() }} </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    </table>


                                @else
                                    <h3>No Links Defined</h3>
                                @endif
                                {{-- <br /><br /><a href="/links"><button class="btn-u" type="button" id="add_link">Add Links</button></a> --}}
                                </div>
                    </div>
        <!-- Modal -->
        <div id="myLinkModal" class="modal fade" role="dialog">
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


                       
                    </div> 
                    @if($allow_folders)
                    <div class="tab-pane table-responsive active" id="folder-tab">
                    <div class="ibox">
                                <div class="ibox-title" id="creative_heading">My Folders<a href="/folder" class="btn btn-xs btn-primary pull-right">Upload HTML5 Folder</a></div>
                                <div class="ibox-content table-responsive" id="folder_div">
                                @if (count($folders))
                                    <table class="table table-hover table-border table-striped table-condensed" name="folders_table" id="folders_table" width="100%">
                                    <thead>
                                    <tr><th>Folder Name</th><th>Category</th><th>Location Type</th><th>Status</th><th>Date Uploaded</th><th>Preview</th></tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($folders as $folder)
                                        <tr class="media_row" id="media_row_{{ $folder->id }}">
                                            <td>{{ $folder->folder_name }} </td>
                                            <td> {{ $categories[$folder->category] }} </td>
                                            <td> {{ $location_types[$folder->location_type] }} </td>
                                            <td> {{ $status_types[$folder->status] }} </td>
                                            <td> {{ Carbon\Carbon::parse($folder->created_at)->toDayDateTimeString() }} </td>
                                            <td> <a href="#" class="tr-iframe" data-toggle="modal" data-target="#myModal" id="view_folder_{{ $width[$folder->location_type] }}_{{ $height[$folder->location_type] }}_{{ $folder->file_location }}"><i class="fa fa-camera-retro" aria-hidden="true"></a></i></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    </table>

                                @else
                                    <h3>No Folders Defined</h3>
                                @endif
                                </div>
                    </div>

                    </div> 
                    @endif
                    </div>
                </div>    
            </div>
        </div>
    </div>
</div>    
@endsection
