@extends('layouts.app')

@section('title','- Advertisers')

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
                        <div class="ibox-title" id="links_heading">My Links<div class="pull-right">@include('link_upload')</div></div>
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
        // $.noConflict();
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
