@extends('layouts.app')
@section('title', '- Campaigns')
@section('content')
    @if(Session::has('success'))
        <div class="alert alert-success">
            <h2>{{ Session::get('success') }}</h2>
        </div>
    @endif
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title">Create a Campaign</div>

                <div class="ibox-content">
                <form name="campaign_form" id="campaign_form" class="form-horizontal" role="form" method="POST" action="{{ url('/campaign') }}">
                {{ csrf_field() }}

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
                                <select id="campaign_category" class="form-control" name="campaign_category" required>
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
                                <select id="location_type" class="form-control" name="location_type" required>
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
                       <div class="form-group">
                            <label for="submit" class="col-md-4 control-label">Submit Campaign</label>
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-primary" name="submit" id="submit" /></form>&nbsp;&nbsp;<a href="/campaigns"><button type="button" class="btn btn-white">Cancel</button></a> 
                            </div>
                        </div>
                
                    <div>
                        <h3>Campaign:</h3>
                        [kam <b>peyn</b>] - 
                        <i>noun</i>
                        <ul><li>a systematic course of aggressive activities for some specific purpose</li></ul>
                        
                        <div class="well">
                            <ul>
                                <li>A Trafficroots Campaign is a targeted advertising plan that consists of at least one Creative.</li>
                                <li>Campaigns target a specific Location Type and all Creatives and their destination Links must conform to the specified Category.</li>
                                <li>On this page you are creating a new Campaign by naming it and selecting a Campaign Type, Location Type and Category.</li>
                                <li>We offer Cost Per Click (CPC) and Cost Per Milli (CPM) Campaign Types. </li>
                                <li>Once created, additional Campaign targeting options such as City or State, as well as your Bid amount are set on the Campaign Edit page.</li>
                             </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
