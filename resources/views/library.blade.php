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
                        @include('media')
                    </div>
                    <div class="tab-pane table-responsive active" id="link-tab">
                        @include('links')
                    </div> 
                    @if($allow_folders)
                    <div class="tab-pane table-responsive active" id="folder-tab">
                        @include('folders');
                    </div> 
                    @endif
                    </div>
                </div>    
            </div>
        </div>
    </div>
</div>    
@endsection