@extends('layouts.app')

@section('title','- Media')

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
                    <div>
                        <h3>Media:</h3>
                        [<b>mee</b>-dee-<i>uh</i> ] - 
                        <i>noun</i>
                        <ul><li>an intervening agency, means, or instrument by which something is conveyed or accomplished</li></ul>
                        
                        <div class="well">
                            <ul>
                                <li>Media uploaded must be image files.</li>
                                <li>To avoid duplication, we offer a Media Library feature.</li>
                                <li>Upload and Categorize your images here and they will be available across all your campaigns.</li>
                                <li>On this page you are creating a new Media item by naming it and selecting a Location Type and Category.</li>
                             </ul>
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
    jQuery(document).ready(function ($) {
        $('[data-toggle="popover"]').popover({
            html: true,
        });
        $('.tr-iframe').click(function(){
            var str =  $(this).attr('id');
            var res = str.split("_");
            var url = 'https://publishers.trafficroots.com' + res[4];
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