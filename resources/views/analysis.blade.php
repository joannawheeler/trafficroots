@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    <div class="col-md-12">
    <div class="panel panel-default">
    <div class="panel-heading">Site Analysis:  <div class="pull-right"><strong> {{ $site->site_name }} </strong>- <a href="{{ $site->site_url }}" target="_blank">{{ $site->site_url }}</a></div></div>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Countries</div>

                <div class="panel-body">
                {!! $geo_table !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">US States</div>

                <div class="panel-body">
                {!! $state_table !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">US Cities</div>

                <div class="panel-body">
                {!! $city_table !!}
                </div>
            </div>
        </div>


       </div>
       <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Devices</div>

                <div class="panel-body">
                {!! $device_table !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Operating Systems</div>

                <div class="panel-body">
                {!! $os_table !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Browsers</div>

                <div class="panel-body">
                {!! $browser_table !!}
                </div>
            </div>
        </div>
         </div>

    </div>
    </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $.noConflict();
        $('.data-table1').DataTable({
            "order": [[ 1, "desc" ]]
        });    
        $('.data-table2').DataTable({
            "order": [[ 2, "desc" ]]
        });
    });

</script>
@endsection
