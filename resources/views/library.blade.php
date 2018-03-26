@extends('layouts.app')

@section('title','Library')
@section('css')
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">
@endsection

@section('js')

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

    <div class="row">
        <div class="col-xs-12">
			<div class="row">
				<div class="col-xs-12">
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
									<form name="library_form"
										  method="POST">
										<label>Dates</label>
										<div class="row">
											<div class="col-xs-12 form-group">
												<input hidden="true"
													   type="text"
													   name="daterange" />
												<div id="reportrange"
													 class="form-control">
													<i class="fa fa-calendar"></i>
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
			<div class="row">
				<div class="col-xs-12">
					<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                        <li><a id="media_tab" href="#media-tab" data-toggle="tab">Media</a></li>
                        <li><a href="#link-tab" data-toggle="tab">Links</a></li>
                        @if($allow_folders)
                        <li><a href="#folder-tab" data-toggle="tab">Folders</a></li>
                        @endif
                    </ul>
                    <div id="my-tab-content" class="tab-content">
                    <div class="tab-pane table-responsive active" id="media-tab">
						<div class="panel panel-body">
							<div class="btnNewEntry">
								<br>
								<div class="pull-right">@include('media_upload')</div>
								<br>
							</div>
							<div class="tableSearchOnly" id="media_div">
								@if (count($media))
								<table class="tablesaw tablesaw-stack table-striped table-hover dataTableSearchOnly dateTableFilter" data-tablesaw-mode="stack" name="media_table" id="media_table">
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
											<td class="text-center"><b class=" tablesaw-cell-label">Media Name</b> {{ $file->media_name }} </td>
											<td class="text-center"><b class=" tablesaw-cell-label">Category</b> {{ $categories[$file->category] }} </td>
											<td class="text-center"><b class=" tablesaw-cell-label">Location Type</b> {{ $location_types[$file->location_type] }} </td>
											<td class="text-center"><b class=" tablesaw-cell-label">Status</b> {{ $status_types[$file->status] }} </td>
											<td class="text-center"><b class=" tablesaw-cell-label">Date Uploaded</b> {{ Carbon\Carbon::parse($file->created_at)->toDayDateTimeString() }} </td>
											<td class="text-center"><b class=" tablesaw-cell-label">Preview</b> <a href="#" class="tr-preview" data-toggle="popover" data-html="true" data-placement="left" data-trigger="hover" title="" data-content="<img src='https://publishers.trafficroots.com/{{ $file->file_location }}' width='120' height='120'>" id="view_media_{{ $file->id }}"><i class="fa fa-camera" aria-hidden="true"></a></i> </td>
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
						<div class="panel panel-body" id="links_heading">
							<div class="btnNewEntry">
								<br>
								<div class="pull-right">@include('link_upload')</div>
								<br>
							</div>
							<div class="tableSearchOnly" id="links_div">
									@if (count($links))
									<table class="tablesaw tablesaw-stack table-striped table-hover dataTableSearchOnly dateTableFilter" data-tablesaw-mode="stack" name="links_table" id="links_table">
									   <thead>
											<tr>
												<th>Link Name</th>
												<th>Category</th>
												<th>URL</th>
												<th>Status</th>
												<th>Date Created</th>
											</tr>
										</thead>
										<tbody>
										@foreach ($links as $link)
											<tr class="link_row" id="link_row_{{ $link->id }}">
												<td class="text-center"><b class=" tablesaw-cell-label">Link Name</b> {{ $link->link_name }} </td>
												<td class="text-center"><b class=" tablesaw-cell-label">Category</b> {{ $categories[$link->category] }} </td>
												<td class="text-center"><b class=" tablesaw-cell-label">URL</b> <a href="{{ $link->url }}" target="blank">{{substr($link->url,0,25)}}</a></td>
												<td class="text-center"><b class=" tablesaw-cell-label">Status</b> {{ $status_types[$link->status] }} </td>
												<td class="text-center"><b class=" tablesaw-cell-label">Date Created</b> {{ Carbon\Carbon::parse($link->created_at)->toDayDateTimeString() }} </td>
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
                                <div class="ibox-title" id="creative_heading">My Folders<a href="/folder" class="btn btn-xs btn-primary pull-right"><i class="fa fa-plus-square-o"></i>&nbsp;Upload HTML5 Folder</a></div>
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
                                            <td> <a href="#" class="tr-iframe" data-toggle="modal" data-target="#myModal" id="view_folder_{{ $width[$folder->location_type] }}_{{ $height[$folder->location_type] }}_{{ $folder->file_location }}"><i class="fa fa-camera" aria-hidden="true"></a></i></td>
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

<script type="text/javascript">
	$('.dataTableSearchOnly').DataTable({
		"oLanguage": {
		  "sSearch": "Search Table"
		}, pageLength: 10,
		responsive: true
	});	
	
    jQuery(document).ready(function ($) {
   	    $('#media_tab').click();
    });
</script>
   <script type="text/javascript">
       jQuery(document).ready(function ($) {
	       $('.nav-click').removeClass("active");
	       $('#nav_buyer_library').addClass("active");
	       $('#nav_buyer').addClass("active");
	       $('#nav_buyer_menu').removeClass("collapse");
       });
   </script>
@endsection
