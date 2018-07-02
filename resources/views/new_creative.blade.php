@extends('layouts.app')
@section('title', 'Creatives')
@section('content')
    @if(Session::has('success'))
        <div class="alert alert-success">
            <h2>{{ Session::get('success') }}</h2>
        </div>
    @endif
<div class="content">
	<div class="row">	
		<div class="col-xs-12">
			<div class="panel panel-default">
				<a href="/manage_campaign/{{ $campaign->id }}" class="btn btn-primary btn-xs pull-right m-t m-r">
					<span class="fa fa-arrow-circle-left"></span>&nbsp;Back to Campaign</a>
                <h4 class="p-title">New Creative for Campaign {{ $campaign->id }} - {{ $campaign->campaign_name }}</h4>

                <div class="ibox-content">
					<div class="row">
						<div class="col-xs-6">
                			<p>A Creative can be a Folder or a combination of Media and Link ids</p>
                			<form name="creative_form" id="creative_form" class="form-horizontal" role="form" method="POST" action="{{ url('/creatives') }}">
							{{ csrf_field() }}
								<input type="hidden" name="campaign_id" id="campaign_id" value="{{ $campaign->id }}">
								<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
									<label for="description" class="col-md-4 control-label">Description</label>

									<div class="col-sm-8">
										<input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}" required autofocus>

										@if ($errors->has('description'))
											<span class="help-block">
												<strong>{{ $errors->first('description') }}</strong>
											</span>
										@endif
									</div>
								</div>  
								@if ($user->allow_folders && count($folders))              
								<div class="form-group{{ $errors->has('media') ? ' has-error' : '' }}">
									<label for="folder_id" class="col-md-4 control-label">Folder</label>

									<div class="col-sm-8">
										<select id="folder_id" class="form-control" name="folder_id">
										<option value="">Choose</option>
										@foreach($folders as $folder)
											<option value="{{ $folder->id }}">{{$folder->folder_name}}</option>

										@endforeach
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
									<label for="media_id" class="col-md-4 control-label">Media</label>

									<div class="col-sm-8">
										<select id="media_id" class="form-control" name="media_id" required>
										<option value="">Choose</option>
										@foreach($media as $type)
											<option value="{{ $type->id }}">{{$type->media_name}}</option>

										@endforeach
										</select>

										@if ($errors->has('media_id'))
											<span class="help-block">
												<strong>{{ $errors->first('media_id') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group{{ $errors->has('link_id') ? ' has-error' : '' }}">
									<label for="link_id" class="col-md-4 control-label">Link</label>

									<div class="col-sm-8">
										<select id="link_id" class="form-control" name="link_id" required>
										<option value="">Choose</option>
										@foreach($links as $link)
											<option value="{{ $link->id }}">{{$link->link_name}}</option>

										@endforeach
										</select>

										@if ($errors->has('link_id'))
											<span class="help-block">
												<strong>{{ $errors->first('link_id') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group text-center">
									<br><br>
									<input class="btn btn-primary btn-lg" type="submit" name="submit" id="submit">
								</div>
							</form>
						</div>
					</div>
            	</div>
        	</div>
		</div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function($){
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
    });

</script>
   <script type="text/javascript">
       jQuery(document).ready(function ($) {
               $('.nav-click').removeClass("active");
               $('#nav_buyer').addClass("active");
       });
   </script>
@endsection
