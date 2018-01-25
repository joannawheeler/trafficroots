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
<style>
.wizard .content {
    min-height: 100px;
}
.wizard .content > .body {
    width: 100%;
    height: auto;
    padding: 15px;
    position: relative;
}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title">Create a Campaign</div>

                <div class="ibox-content">

                <form name="campaign_form" id="campaign_form" class="form-horizontal" role="form" method="POST" action="{{ url('/campaign') }}">
                {{ csrf_field() }}
                <div id="wizard">
                    <h1>Campaign Details</h1>
		    <div class="steps-content">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="campaign_name" class="col-md-4 control-label">Campaign Name</label>

                            <div class="col-md-6">
                                <input id="campaign_name" type="text" class="form-control" name="campaign_name" value="{{ old('campaign_name') }}" required autofocus>
                                @if ($errors->has('campaign_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('campaign_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>                

                        <div class="form-group{{ $errors->has('campaign_type') ? ' has-error' : '' }}">
                            <label for="campaign_type" class="col-md-4 control-label">Campaign Type</label>

                            <div class="col-md-6">
                                <select id="campaign_type" class="form-control" name="campaign_type" required>
                                <option value="">Choose</option>
                                @foreach($campaign_types as $type)
                                    <option value="{{ $type->id }}">{{$type->campaign_type}}</option>

                                @endforeach
                                </select>

                                @if ($errors->has('campaign_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('campaign_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('campaign_category') ? ' has-error' : '' }}">
                            <label for="campaign_category" class="col-md-4 control-label">Campaign Category</label>

                            <div class="col-md-6">
                                <select id="campaign_category" class="form-control reload" name="campaign_category" required>
                                <option value="">Choose</option>
                                @foreach($categories as $type)
                                    <option value="{{ $type->id }}">{{$type->category}}</option>

                                @endforeach
                                </select>
                          
                                @if ($errors->has('campaign_category'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('campaign_category') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('location_type') ? ' has-error' : '' }}">
                            <label for="location_type" class="col-md-4 control-label">Location Type</label>

                            <div class="col-md-6">
                                <select id="location_type" class="form-control reload" name="location_type" required>
                                <option value="">Choose</option>
                                @foreach($location_types as $type)
                                    <option value="{{ $type->id }}">{{$type->description}} - {{$type->width}}x{{$type->height}}</option>

                                @endforeach
                                </select>


                                @if ($errors->has('location_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('location_type') }}</strong>
                                    </span>
                                @endif
                            </div>
			</div>
                        <div class="form-group{{ $errors->has('impression_capping') ? ' has-error' : '' }}">
                            <label for="frequency_capping" class="col-md-4 control-label">Frequency Capping</label>

                            <div class="col-md-6">
                                <select id="frequency_capping" class="form-control" name="frequency_capping">
                                <option value="0">Disabled</option>
                                <option value="1">1 Impression Per 24 Hours</option>
                                <option value="2">2 Impressions Per 24 Hours</option>
                                <option value="3">3 Impressions Per 24 Hours</option>
                                <option value="4">4 Impressions Per 24 Hours</option>
                                <option value="5">5 Impressions Per 24 Hours</option>
                                </select>


                                @if ($errors->has('impression_capping'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('impression_capping') }}</strong>
                                    </span>
                                @endif
                            </div>
			</div>
                    </div>

                    <h1>Advanced Targeting</h1>
		    <div class="step-content">
                            <div class="col-md-12">
                            <h6>Country / Geo Targeting</h6>
                            <select id="countries" name="countries[]" class="chosen-select form-control" multiple>
                            {!! $countries !!} 
                            </select>
                            </div>
                            <div class="col-md-6">
                             <h6>State Targeting</h6>
                             <select id="states" name="states[]" class="chosen-select form-control" multiple>
                             {!! $states !!}
                             </select>
                            </div>
                            <div class="col-md-6">
                            <h6>Platform Targeting</h6>
                                <select name="platform_targets[]" id="platform_targets" class="chosen-select form-control" multiple>
                                {!! $platforms !!}
                                </select>
                            </div>
                            <div class="col-md-6"><br />
                             <h6>OS Targeting</h6>
                             <select id="operating_systems" name="operating_systems[]" class="chosen-select form-control"  multiple>
                             {!! $os_targets !!}
                             </select>
                            </div>
                            <div class="col-md-6"><br />
                             <h6>Browser Targeting</h6>
                             <select id="browser_targets" name="browser_targets[]" class="chosen-select form-control"  multiple>
                             {!! $browser_targets !!}
                             </select>
                            </div>
			    <div class="col-md-12"><br />  
                             <h6>Keyword Targeting</h6><small>Use commas to separate</small>
                             <input name="keyword_targets" id="keyword_targets" class="form-control" type="text" value="">
                            </div>

                    </div>
                    <h1>Creatives</h1>
                    <div class="step-content">
                        <h4>Add A Creative</h4>
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-3 control-label">Description</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" name="description" value="">

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>  
                        @if ($user->allow_folders)              
                        <div class="form-group{{ $errors->has('media') ? ' has-error' : '' }}">
                            <label for="folder_id" class="col-md-3 control-label">Folder</label>

                            <div class="col-md-6">
                                <select id="folder_id" class="form-control" name="folder_id">
                                <option value="">Choose</option>

                                </select>

                                @if ($errors->has('folder_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('folder_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif
                        <div class="form-group{{ $errors->has('media_id') ? ' has-error' : '' }}">
                            <label for="media_id" class="col-md-3 control-label">Media</label>

                            <div class="col-md-6">
                                <select id="media_id" class="form-control" name="media_id">
                                <option value="">Choose</option>

                                </select>
                          
                                @if ($errors->has('media_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('media_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('link_id') ? ' has-error' : '' }}">
                            <label for="link_id" class="col-md-3 control-label">Link</label>

                            <div class="col-md-6">
                                <select id="link_id" class="form-control" name="link_id">
                                <option value="">Choose</option>
                                </select>

                                @if ($errors->has('link_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('link_id') }}</strong>
                                    </span>
                                @endif
                            </div>
			</div>
                        <div class="text-center" style="padding:4px;"><button class="btn btn-primary" onclick="return addCreative();"><i class="fa fa-plus-square-o"></i>&nbsp;Add Creative</button><br /></div>			
                        <div class="ibox-content" id="creatives">
			   <h4>Creatives:</h4> 
                        </div> 
                    </div>
                    <h1>Overview</h1>
                    <div id="overview" class="step-content">
                        <div id="overview_content" style="padding:3px;">
                        </div>
			<div class="row">
                            <div id="bid-tips" class="col-md-6"></div>
			    <div class="col-md-4">
                                <h4>Place Your Bid</h4>
			        <input type="text" id="bid" name="bid" value="4.20">
				<label class="error hide" for="bid"></label>
			    </div>
                        </div>               
                    </div>                    
                </div>
		</form>
                <br />
                <div class="ibox-content">
                    <h5>Add New Media or Links Here:</h5>
                    <div>@include('media_upload')</div><br /><div>@include('link_upload')</div>
                </div>
            <div><br /><br />
                        <h3>Campaign:</h3>
                        [kam-<b>peyn</b>] - 
                        <i>noun</i>
                        <ul><li>a systematic course of aggressive activities for some specific purpose</li></ul>
                        
                        <div class="well">
                            <ul>
                                <li>A Trafficroots Campaign is a targeted advertising plan that consists of at least one Creative.</li>
                                <li>Campaigns target a specific Location Type and all Creatives must conform.</li>
                                <li>All Creatives and their destination Links must conform to the specified Category.</li>
                                <li>We offer Cost Per Click (CPC) and Cost Per Milli (CPM) Campaign Types. </li>
                             </ul>
                        </div>
            </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    //$('[multiple]').chosen();
    jQuery(document).ready(function($){
	    $('#campaign_name').focus();
	    $(document).on('hidden.bs.modal', function(){
	        reloadMedia();
	    });    
	    $("#wizard").steps({
                transitionEffect: "fade",
		autoFocus: true,
                onStepChanged: function (event, currentIndex, priorIndex)
		    {
                        updateOverview();
	            },
                onFinishing: function (event, currentIndex)
		{
			       return checkForm();
		            },
                onFinished: function (event, currentIndex)
		            {
				    $('#campaign_form').submit(function(){
	                                alert("Submitted");
				    });	     
		            }			
        });
        $('#folder_id').change(function(){
            var check = parseInt($(this).val());
            if(check){
                $('#link_id').prop("disabled", true);
                $('#media_id').prop("disabled", true);
            }else{
                $('#link_id').prop("disabled", false);
                $('#media_id').prop("disabled", false);
            }
        });
        $('.reload').change(function($){
           reloadMedia(); 
        });
    });
    function checkForm(){
       if($.trim($('#campaign_name').val()) == ''){
	       alert('Campaign must have a name!');
	       $('#campaign_name').focus();
	       return false;
       }
       if(confirm("Submit this campaign?")){
	       var data = $('#campaign_form').serialize();
	       $.post('/campaign', data).done(function(result){
		   info = JSON.parse(result);
		   if(info.result == 'OK'){
			   toastr.success("Campaign Created!", function(){
				   setTimeout(function(){ window.location = '/campaigns'; }, 2000);
			   });
	           }else{
			   toastr.error(info);
	           }
	   });
       }
       return true;
    }
    function updateOverview(){
	    var creatives = 0;
	    $(".creative").each(function(){
	        creatives ++;
	    });	    
	    var myhtml = '<h4>Campaign Overview</h4><div class="ibox-content"><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Campaign Name:</strong></h6></div><div class="col-md-6"><h6>' + $('#campaign_name').val() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Campaign Type:</strong></h6></div><div class="col-md-6"><h6>' + $('#campaign_type option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Campaign Category:</strong></div><div class="col-md-6"><h6>' + $('#campaign_category option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Location Type:</strong></div><div class="col-md-6"><h6>' + $('#location_type option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Frequency Capping:</strong></div><div class="col-md-6"><h6>' + $('#frequency_capping option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Country/Geo Targeting:</strong></div><div class="col-md-6"><h6>' + $('#countries option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>State Targeting:</strong></div><div class="col-md-6"><h6>' + $('#states option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Platform Targeting:</strong></div><div class="col-md-6"><h6>' + $('#platform_targets option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>OS Targeting:</strong></div><div class="col-md-6"><h6>' + $('#operating_systems option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Browser Targeting:</strong></div><div class="col-md-6"><h6>' + $('#browser_targets option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Keyword Targeting:</strong></div><div class="col-md-6"><h6>' + $('#keyword_targets').val() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Creatives:</strong></div><div class="col-md-6"><h6>' + creatives + '</h6></div></div></div><!--ends here --></div>';
	    $('#overview_content').html(myhtml);
    }
    function reloadMedia(){
        var category = parseInt($('#campaign_category').val());
	var location_type = parseInt($('#location_type').val());
        if(category && location_type){
            var url = '/getmedia?category=' + category + '&location_type=' + location_type;
            $.getJSON(url, function(data){
                $('#folder_id').html(data.folders);
                $('#link_id').html(data.links);
                $('#media_id').html(data.media);               
            });
        }else{
            $('#folder_id').html("<option value=''>Choose</option>");
            $('#link_id').html("<option value=''>Choose</option>");
            $('#media_id').html("<option value=''>Choose</option>");
        }
    }
    function addCreative(){
	    var description = $.trim($('#description').val());
	    if(description == ''){
		    alert("Creative must have a description.");
		    $('#description').focus();
		    return false;
            }
	    var media_id = parseInt($('#media_id').val());
            if(!media_id || isNaN(media_id)){
		    alert("Please select a media image.");
		    $('#media_id').focus();
		    return false;
	    }
	    var media_option = $('#media_id option:selected').text();
	    var link_id = parseInt($('#link_id').val());
	    if(!link_id || isNaN(link_id)){
		    alert("Please select a link for this creative.");
		    $('#link_id').focus();
		    return false;
	    }
	    var link_option = $('#link_id option:selected').text();
	    var current_creatives = $('#creatives').html();
	    if($('#creative_' + media_id + '_' + link_id).length){
		    alert("This creative already exists.");
		    return false;
            }
	    var this_creative = '<div class="row" id="row_' + media_id + '_' + link_id + '" style="padding:2px;"><div class="col-md-3">&nbsp;</div><div class="col-md-6"><input class="creative" name="creative_' + media_id + '_' + link_id + '" id="creative_' + media_id + '_' + link_id + '" type="hidden" value="' + description + '">' + description + ':   ' + media_option + ' - ' + link_option + '</div><div class="col-md-3"><button class="btn btn-xs btn-danger" onclick="$(this).parent().parent().remove();"><i class="fa fa-remove"></i>&nbsp;Remove</button></div></div>';
	   $('#creatives').html(current_creatives + this_creative); 
	return false;
    }
</script>
@endsection
