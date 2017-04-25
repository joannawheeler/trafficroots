@extends('layouts.app')

@section('content')
    @if(Session::has('success'))
        <div class="alert alert-success">
            <h2>{{ Session::get('success') }}</h2>
        </div>
    @endif
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Publisher Dashboard</div>

                <div class="panel-body">
                    <div class="panel panel-default">
                        <div class="panel-heading">My Sites</div>
                        <div class="panel-body table-responsive">
                        @if (count($sites))
                            <table class="table table-hover table-border table-striped table-condensed" name="sites_table" id="sites_table" width="100%">
                            <thead>
                            <tr><th>Site Name</th><th>Site Url</th><th>Site Category</th><th>Stats</th></tr>
                            </thead>
                            <tbody>
                            @foreach ($sites as $site)
                                <tr class="site_row" id="site_row_{{ $site->id }}"><td>{{ $site->site_name }} </td><td> {{ $site->site_url }} </td><td> {{ $site->category }} </td><td><a href="#" class="site-stats" id="site_stats_{{ $site->id }}"><i class="fa fa-bar-chart" aria-hidden="true"></a></i></tr>
                            @endforeach
                            </tbody>
                            </table>
                        @else
                            <h3>No Sites Defined</h3> 
 
                        @endif
                        <br /><br /><a href="/sites"><button class="btn-u" type="button" id="add_site">Add A Site</button></a>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" id="zone_heading">My Zones</div>
                        <div class="panel-body table-responsive" id="zones_div">

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.site_row').click(function(){
            var spinner = '<center><i class="fa fa-cog fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center>';
            $( "#zone_heading").html('My Zones');
            $( "#zones_div" ).html(spinner);
            var str =  $(this).attr('id');
            var res = str.split("_");
            var url = '/getzones/' + res[2];
            $.get( url, function( data ) {
                var ret = data.split("|");
                $( "#zone_heading").html('My Zones - ' + ret[0]);
                $( "#zones_div" ).html( ret[1] );
            });

        });
        $('.site-stats').click(function(){
            var str =  $(this).attr('id');
            var res = str.split("_");
            var url = '/stats/site/' + res[2] + '/1';
            window.location.assign(url);
        }); 
        $('.zone-stats').click(function(){
            var str =  $(this).attr('id');
            var res = str.split("_");
            var url = '/zonestats/' + res[1];
            window.location.assign(url);
        });  
        $('.site_row').hover(function() {
            $(this).css('cursor','pointer');
        });
    });

</script>
@endsection
