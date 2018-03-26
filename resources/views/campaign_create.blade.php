@extends('layouts.app')
@section('title', '- Campaigns')
@section('css')
<link rel="stylesheet"
      href="{{ URL::asset('css/plugins/select2/select2.min.css') }}">
<link rel="stylesheet"
      href="{{ URL::asset('css/plugins/chosen/chosen.css') }}">
<link rel="stylesheet"
      href="{{ URL::asset('css/custom.css') }}">
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
.ibox {
    width: 80%;
}
.wizard .content {
    min-height: 100px;
}
.wizard .content > .body {
    width: 100%;
    height: auto;
    padding: 15px;
    position: relative;
}

#wizard-p-3 {
    background: white;
}

#overview .col-md-12 .col-md-3 {
    text-align: right;
}

.step-content .media-selection .col-xs-12 .chkRadioBtn {
    display: inline-block;
}

.image-preview i.fa { display: none; }
.image-previewdiv img { display: block; }

.image-preview.show-icon i.fa { display: inline-block; font-size: 100px; }
.image-preview.show-icon img { display: none; }

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
                            <div class="col-md-10 col-md-offset-2">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Basic Information</h5>
                                    </div>
                                    <div class="ibox-content">
                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <label for="campaign_name" class="col-md-4 control-label">Campaign Name</label>
                                            <div class="col-md-6">
                                                <input id="campaign_name" type="text" class="form-control" name="campaign_name" placeholder="Campaign Name" value="{{ old('campaign_name') }}" required autofocus> @if ($errors->has('campaign_name'))
                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('campaign_name') }}</strong>
                                                                </span> @endif
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
                                                                </span> @endif
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
                                                                </span> @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10 col-md-offset-2">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Configuration & Pricing</h5>
                                    </div>
                                    <div class="ibox-content">
                                        <div class="form-group{{ $errors->has('campaign_type') ? ' has-error' : '' }}">
                                            <label for="campaign_type" class="col-md-4 control-label">Pricing Model <em class="fa fa-question-circle" aria-hidden="true"></em></label>
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
                                                                </span> @endif
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
                                                                </span> @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Max Daily Budget <em class="fa fa-question-circle" aria-hidden="true"></em></label>
                                            &nbsp;
                                            <div class="col-md-6">
                                                <select class="form-control">
                                                    <option value="">Unlimited</option>
                                                    <option value="">$20.00</option>
                                                    <option value="">$50.00</option>
                                                    <option value="">$100.00</option>
                                                    <option value="">$200.00</option>
                                                    <option value="">$500.00</option>
                                                    <option value="">$750.00</option>
                                                    <option value="">$1000.00</option>
                                                    <option value="">$2000.00</option>
                                                    <option value="">$5000.00</option>
                                                    <option value="">$10000.00</option>
                                                    <option value="">$20000.00</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Start and End Date &nbsp;</label>
                                            <div class="col-md-4">
                                                <div id="date_filter">
                                                    <input class="date_range_filter date form-control" type="hidden" id="datepicker_from" />
                                                    <input class="date_range_filter date" type="hidden" id="datepicker_to" />
                                                </div>
                                                <input type="text" class="form-control dateRangeFilter">
                                                <span class="glyphicon glyphicon-calendar fa fa-calendar dateRangeIcon"></span>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group control-label">
                                                                                    <label class="col-md-4" for="exampleInputEmail2">
                                                                                        Ad Group &nbsp; <span class="fa fa-question-circle" aria-hidden="true"></span>
                                                                                    </label>
                                                                                <div class="col-xs-7 col-md-2">
                                                                                    <select class="form-control">
                                                                                        <option>CPM</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-xs-5 col-md-2" style="text-align:  left;">
                                                                                    <a href="#">Manage Groups</a>
                                                                                </div>
                                                                            </div> -->
                                    </div>
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
                            <div class="col-md-12">
                             <h6>State Targeting</h6>
                             <select id="states" name="states[]" class="chosen-select form-control state-control" multiple>
                             {!! $states !!}
                             </select>
                            </div>
                            <div class="col-md-6">
                            <h6>County Targeting</h6>
                                <select name="counties[]" id="counties" class="chosen-select form-control counties" multiple>
                                {!! $counties !!}
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

                    <h2 class="text-success"><strong>Media</strong></h2>
                            <div class="text-center image-preview show-icon">
                                <i class="fa fa-camera"></i>
                                <img class="newCampaignImg" src"" alt="Preview Image"/>
                            </div>

                            <br><br>
                                <div class="media-selection">
                                    <div class="col-xs-12 col-md-6 b-r no-padding">
                                        <p><strong>Select an Image</strong></p>
                                        <br>
                                        <div class="col-xs-12">
                                            <input type="radio" class="chkRadioBtn" checked id="imgExist" value="1" name="optionsImg">
                                            <label for="imgExist">&nbsp; Choose Existing Image</label>
                                            <br>
                                            <br>
                                            <div class="form-group col-xs-12 mediaOptions">
                                                <select class="form-control"><option>Choose Existing Image</option>
                                                </select>
                                            </div>                                            
                                        </div>

                                        <div class="col-xs-12">
                                            <br>
                                            <input type="radio" class="chkRadioBtn"  id="imgCreateNew" value="2" name="optionsImg">
                                            <label for="imgCreateNew">&nbsp; Create New Image</label><br>
                                            <div class="col-xs-12 mediaOptions">
                                                <div class="form-group">
                                                    <label title="Upload image file" for="imgUpload" class="btn btn-success">
                                                        <input type="file" accept="image/*" name="file" id="imgUpload" class="hide">
                                                        Upload New Image
                                                    </label>
                                                </div>
                                                <div class="form-group col-xs-12">
                                                    <!--name, link, category-->
                                                    <input id="image_name" placeholder="Image Name" class="form-control">
                                                </div>                                                
                                                <div class="form-group col-xs-12">
                                                 <select class="form-control m-b"
                                                        id="image_category"
                                                        name="category"
                                                        required>
                                                    <option value="">Choose category</option>
                                                    @foreach(App\Category::all() as $category)
                                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <p><strong>Select a Link</strong></p>
                                        <br>
                                        <div class="col-xs-12">
                                            <input type="radio" class="chkRadioBtn" checked id="linkExist" value="1" name="optionLink">
                                            <label for="linkExist">&nbsp; Choose Existing Link</label>
                                            <br>
                                            <br>
                                            <div class="form-group col-xs-12 mediaOptions">
                                                <select class="form-control"><option>Choose Existing Link</option>
                                                </select>
                                            </div>                                            
                                        </div>
                                        <div class="col-xs-12">
                                            <br>
                                            <input type="radio" class="chkRadioBtn" id="linkCreateNew" value="2" name="optionLink">
                                             <label for="linkCreateNew">&nbsp; Create New Link</label>
                                             <br>
                                             <br>
                                            <div class="col-xs-12 mediaOptions">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="url" id="websiteUrl" placeholder="Must be a valid URL, with http:// or https://" class="form-control" required>
                                                        <!-- <input type="hidden"
                                                            name="return_url"
                                                            id="return_url"
                                            @if( $_SERVER['REQUEST_URI'] == '/campaign')
                                                            value="campaign">
                                                        @else
                                                            value="library">
                                                    @endif
                                                        <label class="error hide"
                                                            for="url"></label> -->
                                                        <a href="#" id="urlLink" class="input-group-addon">
                                                            <span class="fa fa-camera"></span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <!--name, link, category-->
                                                    <input id="link_info" placeholder="Link Name" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control m-b"
                                                            id="link_category"
                                                            name="category"
                                                            required>
                                                        <option value="">Choose category</option>
                                                        @foreach(App\Category::all() as $category)
                                                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                                                        @endforeach
                                                    </select>
                                                    <label class="error hide"
                                                        for="category"></label>
                                                </div>                                               
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <br><br>

                                </div>

<!--
                                <h4>Add A Creative</h4>
                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label for="description" class="col-md-3 control-label">Description</label>
                                    <div class="col-md-6">
                                        <input id="description" type="text" class="form-control" name="description" value=""> @if ($errors->has('description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span> @endif
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
                                        </span> @endif
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
                                            </span> @endif
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
                                            </span> @endif
                                        </div>
                                </div>
                                <div class="text-center" style="padding:4px;">
                                    <button class="btn btn-primary" onclick="return addCreative();"><i class="fa fa-plus-square-o"></i>&nbsp;Add Creative</button>
                                    <br />
                                </div>
                                <div class="ibox-content" id="creatives">
                                    <h4>Creatives:</h4>
                                </div> -->
                    </div>


                    <h1>Overview</h1>

                        <div id="overview" class="step-content">
                            <div id="overview_content" style="padding:3px;">
                            </div>
                            <!-- Overview DIV -->                            

                            <!--   End Overview Page     -->

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
                            <div>@include('media_upload')</div>
                            <br />
                            <div>@include('link_upload')</div>
                        </div>
                        <div>
                            <br />
                            <br />
                            <h3>Campaign:</h3> [kam-
                            <b>peyn</b>] -
                            <i>noun</i>
			<div class="row">
                            <div id="bid-tips" class="col-md-6"></div>
			    <div class="col-md-4">
                                <h4>Place Your Bid</h4>
			        <input type="text" id="bid" name="bid" value="4.20" required>
				<label class="error hide" for="bid"></label><br />
			    </div>
			</div>              
                        <div class="row"><div class="col-md-6">&nbsp;</div>
                            <div class="col-md-4">
                                <h4>Set Your Daily Budget</h4>
				<input type="text" id="daily_budget" name="daily_budget" value"0.00">&nbsp;<i>*optional</i>
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
                        
                        <div class="well">
                            <ul>
                                <li>a systematic course of aggressive activities for some specific purpose</li>
                            </ul>
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
<<<<<<< HEAD
                    {
                    $('#campaign_form').submit(function(){
                                    alert("Submitted");
                    });
                    }
        });
=======
		            {
				    $('#campaign_form').submit(function(){
	                                alert("Submitted");
				    });	     
		            }			
	    });
	@if($user->allow_folders)    
>>>>>>> master
        $('#folder_id').change(function(){
            var check = parseInt($(this).val());
            if(check){
                $('#link_id').prop("disabled", true);
                $('#media_id').prop("disabled", true);
            }else{
                $('#link_id').prop("disabled", false);
                $('#media_id').prop("disabled", false);
            }
<<<<<<< HEAD
        });
        $('.reload').change(function($){
           reloadMedia();
=======
	});
	@endif
		$('.state-control').change(function(){
            var url = "{{ url('/load_counties') }}";
            var mydata = $("#campaign_form").serialize();
            $.post(url, mydata)
		.done(function (response) {
                    $('.counties').html(response);
                })
                .fail(function (response) {
                    toastr.error(response);
                });       });
	$('.reload').change(function($){
           reloadMedia(); 
>>>>>>> master
        });

        if ($("#imgUpload").length) {
            $("#imgUpload").change(function() {
              uploadImgURL(this);
              $(".image-preview").toggleClass("show-icon");
              // $("overViewCampaignImg").attr("src", this);
            });
        }

        if ($("input#websiteUrl").length) {
            $("input#websiteUrl").change(function(){
                var linkurl = $("#websiteUrl").val();

                if (linkurl === "") {
                    $("#urlLink").attr('href', "#");
                    $("#urlLink").removeAttr('target', '_blank');
                } else {
                    $("#urlLink").attr('href', "http://" + linkurl);
                    $("#urlLink").attr('target', '_blank');
                }
            });
        }

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
<<<<<<< HEAD
        var creatives = 0;
        var newPreviewImg = $(".newCampaignImg").attr("src");
     
        $(".creative").each(function(){
            creatives ++;
        });
        var myhtml =  '<style>.col-md-3 {text-align: right;}</style><div class="ibox-content"><h2 class="text-success"><strong>General & Pricing</strong></h2><div class="row"><div class="form-group"><div class="col-md-3"> <label class="control-label p-t-half">Campaign Name</label></div><div class="col-md-4"><div type="text" value="campaign name" class="form-control" disabled> ' + $('#campaign_name').val() + '</div></div></div></div><div class="row m-t"><div class="form-group"><div class="col-md-3"> <label class="control-label p-t-half">Campaign Category</label></div><div class="col-md-4"><div type="text" value="campaign category" class="form-control" disabled> ' + $('#campaign_category option:selected').text() + '</div></div></div></div><div class="row m-t"><div class="form-group"><div class="col-md-3"> <label class="control-label p-t-half">Location Type<em class="fa fa-question-circle" aria-hidden="true"></em></label></div><div class="col-md-4"><div type="text" value="campaign category" class="form-control" disabled> ' + $('#location_type option:selected').text() + '</div></div></div></div></div> <br><h2 class="text-success"><strong>Advanced Targeting</strong></h2><div class="row m-t"><div class="col-md-3"> <label class="control-label p-t-half">Country Targeting</label></div><div class="col-md-4"><div type="text" text="example, example" class="form-control" disabled> ' + $('#countries option:selected').text() + '</div></div></div><div class="row m-t"><div class="col-md-3"> <label class="control-label p-t-half">State Targeting</label></div><div class="col-md-4"><div type="text" text="example, example" class="form-control" disabled> ' + $('#states option:selected').text() + '</div></div></div><div class="row m-t"><div class="col-md-3"> <label class="control-label p-t-half">City Targeting</label></div><div class="col-md-4"> <input type="text" text="example, example" class="form-control" disabled></div></div><div class="row m-t"><div class="col-md-3"> <label class="control-label p-t-half">Platform Targeting</label></div><div class="col-md-4"><div type="text" text="example, example" class="form-control" disabled> ' + $('#platform_targets option:selected').text() + '</div></div></div><div class="row m-t"><div class="col-md-3"> <label class="control-label p-t-half">OS Targeting</label></div><div class="col-md-4"><div type="text" text="example, example" class="form-control" disabled> ' + $('#operating_systems option:selected').text() + '</div></div></div><div class="row m-t"><div class="col-md-3"> <label class="control-label p-t-half">Browser Targeting</label></div><div class="col-md-4"><div type="text" text="example, example" class="form-control" disabled> ' + $('#browser_targets option:selected').text() + '</div></div></div><div class="row m-t"><div class="col-md-3"> <label class="control-label p-t-half">Keyword Targeting</label></div><div class="col-md-4"><div type="text" text="example, example" class="form-control" disabled> ' + $('#keyword_targets').val() + '</div></div></div> <br><h2 class="text-success"><strong>Media</strong></h2><div class="row"><div class="col-xs-12 col-md-9 col-md-offset-1"><div class="text-center image-preview show-icon"> <i class="fa fa-camera"></i> <img class="newCampaignImg" src=" ' + newPreviewImg + ' " alt="Preview Image"/></div><br><br><div class="col-md-6 b-r"> <label class="control-label">Image Info</label><div value="Image Name" class="form-control" disabled>' + $('#image_name').val() + '</div> <br><div value="Category Name" class="form-control" disabled>' + $('#image_category option:selected').text() + '</div></div><div class="col-md-6"> <label class="control-label">Link Info</label><div value="Link Name" class="form-control" disabled>' + $('#link_info').val() + '</div><br><div value="Category Name" class="form-control" disabled>' + $('#link_category option:selected').text() + '</div><br><div class="input-group"> <input type="url" id="websiteUrl" placeholder="Must be a valid URL" class="form-control" disabled=""> <a href="#" id="urlLink" class="input-group-addon"> <span class="fa fa-camera"></span>  </a></div>';






        // + '<h4>Campaign Overview</h4><div class="ibox-content"><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Campaign Name:</strong></h6></div><div class="col-md-6"><h6>' + $('#campaign_name').val() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Campaign Type:</strong></h6></div><div class="col-md-6"><h6>' + $('#campaign_type option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Campaign Category:</strong></div><div class="col-md-6"><h6>' + $('#campaign_category option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Location Type:</strong></div><div class="col-md-6"><h6>' + $('#location_type option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Frequency Capping:</strong></div><div class="col-md-6"><h6>' + $('#frequency_capping option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Country/Geo Targeting:</strong></div><div class="col-md-6"><h6>' + $('#countries option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>State Targeting:</strong></div><div class="col-md-6"><h6>' + $('#states option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Platform Targeting:</strong></div><div class="col-md-6"><h6>' + $('#platform_targets option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>OS Targeting:</strong></div><div class="col-md-6"><h6>' + $('#operating_systems option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Browser Targeting:</strong></div><div class="col-md-6"><h6>' + $('#browser_targets option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Keyword Targeting:</strong></div><div class="col-md-6"><h6>' + $('#keyword_targets').val() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Creatives:</strong></div><div class="col-md-6"><h6>' + creatives + '</h6></div></div></div><!--ends here --></div>';
        $('#overview_content').html(myhtml);
<<<<<<< Updated upstream
=======
	    var creatives = 0;
	    $(".creative").each(function(){
	        creatives ++;
	    });	    
	    var myhtml = '<h4>Campaign Overview</h4><div class="ibox-content"><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Campaign Name:</strong></h6></div><div class="col-md-6"><h6>' + $('#campaign_name').val() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Campaign Type:</strong></h6></div><div class="col-md-6"><h6>' + $('#campaign_type option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Campaign Category:</strong></div><div class="col-md-6"><h6>' + $('#campaign_category option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Location Type:</strong></div><div class="col-md-6"><h6>' + $('#location_type option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Frequency Capping:</strong></div><div class="col-md-6"><h6>' + $('#frequency_capping option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Country/Geo Targeting:</strong></div><div class="col-md-6"><h6>' + $('#countries option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>State Targeting:</strong></div><div class="col-md-6"><h6>' + $('#states option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>County Targeting:</strong></div><div class="col-md-6"><h6>' + $('#counties option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Platform Targeting:</strong></div><div class="col-md-6"><h6>' + $('#platform_targets option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>OS Targeting:</strong></div><div class="col-md-6"><h6>' + $('#operating_systems option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Browser Targeting:</strong></div><div class="col-md-6"><h6>' + $('#browser_targets option:selected').text() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Keyword Targeting:</strong></div><div class="col-md-6"><h6>' + $('#keyword_targets').val() + '</h6></div></div><div class="row"><div class="col-md-2">&nbsp;</div><div class="col-md-2"><h6><strong>Creatives:</strong></div><div class="col-md-6"><h6>' + creatives + '</h6></div></div></div><!--ends here --></div>';
	    $('#overview_content').html(myhtml);
>>>>>>> master
=======

        if (newPreviewImg) {
                $(".image-preview").toggleClass("show-icon")
            }
>>>>>>> Stashed changes
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
    // Preview Loaded Img
    function uploadImgURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('.newCampaignImg').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
      }
    }



</script>
@endsection
