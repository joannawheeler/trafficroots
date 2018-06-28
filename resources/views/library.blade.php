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
			<!--
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

-->
			<div class="row">
				<div class="col-xs-12">
					<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                        <li><a id="media_tab" href="#media-tab" data-toggle="tab">Media</a></li>
                        <li><a href="#link-tab" data-toggle="tab">Links</a></li>
                        <!-- @if($allow_folders)
                        <li><a href="#folder-tab" data-toggle="tab">Folders</a></li>
                        @endif -->
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
												<th>Date</th>
												<th>Name</th>
												<th>Category</th>
												<th>Location Type</th>
												<th>Status</th>
												<th>Options</th>
												<th>Preview</th>
											</tr>
										</thead>
										<tbody>
										@foreach ($media as $file)
											<tr class="media_row" id="media_row_{{ $file->id }}">
												<td class="text-center"><b class=" tablesaw-cell-label">Date</b> {{ Carbon\Carbon::parse($file->created_at)->format('m/d/Y') }} </td>
												<td class="text-center"><b class=" tablesaw-cell-label">Name</b> {{ $file->media_name }} </td>
												<td class="text-center"><b class=" tablesaw-cell-label">Category</b> {{ $categories[$file->category] }} </td>
												<td class="text-center get_location_type_id"><b class=" tablesaw-cell-label">Location Type</b> {{ $location_types[$file->location_type] }} </td>
												<td class="text-center"><b class=" tablesaw-cell-label">Status</b><span class="currentStatus label"> {{ $status_types[$file->status] }} </span></td>
												<td class="text-center"><b class=" tablesaw-cell-label">Options</b>
													<a href="#"
													   class="media-edit"
													   data-toggle="modal"
													   data-target="#editMedia{{ $file->id }}">
														<button class="btn btn-xs btn-success alert-success">
														<span class="btn-label">
															<i class="fa fa-edit"></i>
														</span> Edit</button>
													</a>
												</td>
												<td class="text-center"><b class=" tablesaw-cell-label">Preview</b> <a href="#" class="tr-preview" data-toggle="popover" data-html="true" data-placement="left" data-trigger="hover" title="" data-content="<img src='https://publishers.trafficroots.com/{{ $file->file_location }}' width='100%' height='auto'>" id="view_media_{{ $file->id }}"><i class="fa fa-camera" aria-hidden="true"></i></a> </td>
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
													<th>Name</th>
													<th>Category</th>
													<th>URL</th>
													<th>Status</th>
													<th>Date Created</th>
													<th>Options</th>
												</tr>
											</thead>
											<tbody>
											@foreach ($links as $link)
												<tr class="link_row" id="link_row_{{ $link->id }}">
													<td class="text-center"><b class=" tablesaw-cell-label">Name</b> {{ $link->link_name }} </td>
													<td class="text-center"><b class=" tablesaw-cell-label">Category</b> {{ $categories[$link->category] }} </td>
													<td class="text-center"><b class=" tablesaw-cell-label">URL</b> <a href="{{ $link->url }}" target="blank">{{substr($link->url,0,25)}}</a></td>
													<td class="text-center"><b class=" tablesaw-cell-label">Status</b><span class="currentStatus label"> {{ $status_types[$link->status] }} </span></td>
													<td class="text-center"><b class=" tablesaw-cell-label">Date Created</b> {{ Carbon\Carbon::parse($link->created_at)->toDayDateTimeString() }} </td>
													<td class="text-center"><b class=" tablesaw-cell-label">Options</b>
														<a href="#"
														   class="link-edit"
														   data-toggle="modal"
														   data-target="#editLink{{ $link->id }}">
															<button class="btn btn-xs btn-success alert-success">
															<span class="btn-label">
																<i class="fa fa-edit"></i>
															</span> Edit</button>
														</a>
													</td>
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
								<div class="ibox-title" id="creative_heading">My Folders
									<a href="/folder" class="btn btn-xs btn-primary pull-right"><i class="fa fa-plus-square-o"></i>&nbsp;Upload HTML5 Folder</a>
								</div>
								<div class="ibox-content table-responsive" id="folder_div">
									@if (count($folders))
									<table class="table table-hover table-border table-striped table-condensed" name="folders_table" id="folders_table" width="100%">
										<thead>
											<tr><th>Folder Name</th>
												<th>Category</th>
												<th>Location Type</th>
												<th>Status</th>
												<th>Date Uploaded</th>
												<th>Preview</th>
											</tr>
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


@foreach ($media as $file)
<div class="modal inmodal"
     id="editMedia{{ $file->id }}"
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
                <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Image</h4>
            </div>
            <form name="media_form"
                  id="media_form"
                  class="form-horizontal"
                  enctype="multipart/form-data"
                  role="form"
				  method="POST"
                  onsubmit="return submitMediaForm();"
                  action="{{ url('/update_media') }}"> {{ method_field('PATCH') }}
                    <div class="modal-body">
                        {{ csrf_field() }}   
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text"
                               placeholder="Enter your image name"
                               value="{{ $file->media_name }}"
                               class="form-control"
                               name="media_name"
                               required>
                        <label class="error hide"
                               for="media_name"></label>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        @if($_SERVER['REQUEST_URI'] == '/campaign') 
                            <div class="display: inline-block">To a select a different Category please go back to Step 1</div>
                        @endif
                        <select class="form-control m-b" id="image_category_id"
                                name="image_category"
                                required>
                            <option value="">Choose Image Category</option>
                            @foreach(App\Category::all() as $category)
                            <option value="{{ $category->id }}" {{ $file->category == $category->id ? 'selected="selected"' : '' }}>{{ $category->category }}</option>
                            @endforeach
                        </select>
                        <label class="error hide"
                               for="image_category"></label>
                    </div>

                    <div class="form-group">
                        <label>Location Type</label>
                        @if($_SERVER['REQUEST_URI'] == '/campaign') 
                            <div class="display: inline-block">To a select a different Location Type please go back to Step 1 </div>
                        @endif
                        <select class="form-control m-b"
                                id="location_type_id"
                                value=""
                                name="image_size"
                                required>
                            <option value="">Choose Image Size</option>
                            @foreach(App\LocationType::all() as $locationType)
                            <option value="{{ $locationType->id }}" {{ $file->location_type == $locationType->id ? 'selected="selected"' : '' }}>{{ $locationType->width . 'x' . $locationType->height . ' ' . $locationType->description }}</option>
                            @endforeach
                        </select>

                        <label class="error hide"
                               for="image_size"></label>
                    </div>
                    <div class="form-group">
                        <label class="btn btn-success btn-block"
                               for="image_file">
                            <i class="fa fa-upload"></i>&nbsp;&nbsp;
                            <span class="bold">Upload</span>
                        </label>
                        <br>
                        <input type="file"
                               name="file"
                               id="image_file"
                               accept="image/*"
                               style="z-index: -1; position: relative;"
                               disabled
                               />
                        <p id="upload_path">{{ $file->file_location }}</p>
                        <p id="image_size"></p>
                        <p id="image_dimensions"></p>
                        <label class="error mt-10"
                               style="display: none;"
                               for="image_file">
                            <i class="text-danger fa fa-exclamation-triangle"></i>&nbsp;&nbsp;
                            <span class="text-danger"></span>
                        </label>
                        <label class="success mt-10"
                               style="display: none;"
                               for="image_file">
                            <p>
                                <i class="text-success fa fa-check"></i>&nbsp;&nbsp;
                                <span class="text-primary"></span>
                            </p>
                            <div class="ibox-content w-160">
                                <img src=""
                                     alt="preview"
                                     width="120"
                                     height="120">
                            </div>
                        </label>
                    </div>
                    <div>      
                        <div class="well">
                            <ul>
                                <li>Media uploaded must be image files.</li>
                                <li>The uploaded image needs to fit the exact dimensions of the location type.</li>
                                <li>To avoid duplication, we offer a Media Library feature.</li>
                                <li>Upload and Categorize your images here and they will be available across all your campaigns.</li>
                                <li>On this page you are creating a new Media item by naming it and selecting a Location Type and Category.</li>
                             </ul>
                        </div>
                    </div>
                </div>                
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-white"
                            data-dismiss="modal">Cancel</button>
                    <button type="submit"
                            name="submit"
                            id="btnSubmit"
                            class="btn btn-primary">Submit</button>
        </div>
                        <input type="hidden"
                               name="return_url"
                               id="return_url"
                        @if( $_SERVER['REQUEST_URI'] == '/campaign')
                               value="campaign">
                        @else
                               value="library">
                        @endif
            </form>
        </div>
    </div>
</div>
@endforeach

@foreach ($links as $link)
<div class="modal inmodal"
     id="editLink{{ $link->id }}"
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
                <h4 class="modal-title"><i class="fa fa-edit"></i> Edit URL</h4>
            </div>
            <form name="link_form"
                  id="link_form"
                  class="form-horizontal"
                  role="form"
          method="POST"
          onsubmit="return submitLinkForm();"
                  action="{{ url('/links') }}"> {{ method_field('PATCH') }}
                    <div class="modal-body">
                        {{ csrf_field() }}  
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text"
                               placeholder="Link name"
							   value = "{{ $link->link_name }}"
                               class="form-control"
                               name="link_name"
                               required>

                        <label class="error hide"
                               for="link_name"></label>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control m-b" id="link_category_id"
                                name="link_category"
                                required>
                            <option value="">Choose category</option>
                            @foreach(App\Category::all() as $category)
                            <option value="{{ $category->id }}"  {{ $link->category == $category->id ? 'selected="selected"' : '' }}>{{ $category->category }}</option>
                            @endforeach
                        </select>
                        <label class="error hide"
                               for="link_category"></label>
                    </div>

                    <div class="form-group">
                        <label>URL</label>
                        <input type="url"
                               placeholder="Must be a valid URL, with http:// or https://"
							   value = "{{ $link->url }}"
                               class="form-control"
                               name="url"
                               required>
                        <input type="hidden" 
                               name="return_url"
                               id="return_url"
            @if( $_SERVER['REQUEST_URI'] == '/campaign')
                               value="campaign">
                        @else
                               value="library">
                    @endif
                        <label class="error hide"
                               for="url"></label>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-white"
                            data-dismiss="modal">Cancel</button>
                    <button type="submit"
                            name="submit"
                            class="btn btn-primary">Submit</button>
                </div>
        </form>
        </div>
    </div>
</div>
@endforeach
<script type="text/javascript">
jQuery(document).ready(function ($) {
	$('.nav-click').removeClass("active");
	$('#nav_buyer_library').addClass("active");
	$('#nav_buyer').addClass("active");
	$('#nav_buyer_menu').removeClass("collapse");

	setStatus();
	$('#media_tab').click();

	$('.dataTableSearchOnly').DataTable({
		"oLanguage": {
		  "sSearch": "Search Table"
		}, pageLength: 10,
		responsive: true
	});
});

$("a.tr-preview").click(function(event){
    event.preventDefault();
});

function setStatus() {
	var currentStatus = Array.from($(".currentStatus"));
	currentStatus.forEach(function(element) {
		if (element.innerText == "Active") {
		  element.classList.add("label-primary");
		} else if (element.innerText == "Declined") {
		  element.classList.add("label-danger");
		} else if (element.innerText == "Disabled") {
		  element.classList.add("label-default");
		} else {
		  element.classList.add("label-warning");
		};
	});
};
	
function submitMediaForm(){
	// Get form
	var form = $('#media_form')[0];

	// Create an FormData object
	var data = new FormData(form);

	// If you want to add an extra field for the FormData
	//data.append("CustomField", "This is some extra data, testing");
	// disabled the submit button
	$("#btnSubmit").prop("disabled", true);

	$.ajax({
		type: "POST",
		enctype: 'multipart/form-data',
		url: "/media",
		data: data,
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log("SUCCESS : ", data);
			$("#btnSubmit").prop("disabled", false);
			$("#addMedia").modal('hide');
			toastr.success('Upload Complete!');

			if(window.location.href.indexOf("/library") > -1) {
				window.location.href = "/library";
			} else {
				reloadMedia();
			}
		},
		error: function (e) {
			toastr.error(e.responseText);
			console.log("ERROR : ", e);
			$("#btnSubmit").prop("disabled", false);

		}
   });
		return false;
}	
	
</script>
@endsection
