@extends('layouts.app') 
@section('content') 
@if(Session::has('success'))
<div class="alert alert-success">
    <h2>{{ Session::get('success') }}</h2>
</div>
@endif {{--
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
                                    <tr>
                                        <th>Site Name</th>
                                        <th>Site Url</th>
                                        <th>Site Category</th>
                                        <th>Stats</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sites as $site)
                                    <tr class="site_row" id="site_row_{{ $site->id }}">
                                        <td>{{ $site->site_name }} </td>
                                        <td> {{ $site->site_url }} </td>
                                        <td> {{ $site->category }} </td>
                                        <td><a href="#" class="site-stats" id="site_stats_{{ $site->id }}"><i class="fa fa-bar-chart" aria-hidden="true"></a></i>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <h3>No Sites Defined</h3> @endif
                            <br />
                            <br />
                            <a href="/sites">
                                <button class="btn-u" type="button" id="add_site">Add A Site</button>
                            </a>
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
jQuery(document).ready(function($) {
    $('.site_row').click(function() {
        var spinner = '<center><i class="fa fa-cog fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></center>';
        $("#zone_heading").html('My Zones');
        $("#zones_div").html(spinner);
        var str = $(this).attr('id');
        var res = str.split("_");
        var url = '/getzones/' + res[2];
        $.get(url, function(data) {
            var ret = data.split("|");
            $("#zone_heading").html('My Zones - ' + ret[0]);
            $("#zones_div").html(ret[1]);
        });
    });
    $('.site-stats').click(function() {
        var str = $(this).attr('id');
        var res = str.split("_");
        var url = '/stats/site/' + res[2] + '/1';
        window.location.assign(url);
    });
    $('.zone-stats').click(function() {
        var str = $(this).attr('id');
        var res = str.split("_");
        var url = '/zonestats/' + res[1];
        window.location.assign(url);
    });
    $('.site_row').hover(function() {
        $(this).css('cursor', 'pointer');
    });
});
</script>
<script type="text/javascript">
jQuery(document).ready(function($) {
    $('.nav-click').removeClass("active");
    $('#nav_pub').addClass("active");
});
</script> --}}
<div class="row">
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">Monthly</span>
                <h5>Balance</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">$420</h1>
                <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                <small>Current Earnings</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-info pull-right">Daily</span>
                <h5>Today</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">$4.20</h1>
                <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div>
                <small>Todays revenue</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-info pull-right">Revenue</span>
                <h5>Today</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">$4.20</h1>
                <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div>
                <small>Todays revenue</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-info pull-right">Daily</span>
                <h5>Today</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">$4.20</h1>
                <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div>
                <small>Todays revenue</small>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Daily Stats</h5>
                <div ibox-tools></div>
            </div>
            <div class="ibox-content">
                <div>
                    <canvas id="lineChart" height="70"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Basic Table</h5>
            </div>
            <div class="ibox-content">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Impressions</th>
                            <th>Clicks</th>
                            <th>CPM</th>
                            <th>CPC</th>
                            <th>Earnings</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>5/25</td>
                            <td>120,000</td>
                            <td>950</td>
                            <td>4.20</td>
                            <td>.20</td>
                            <td><span class="label label-primary">$420</span></td>
                        </tr>
                        <tr>
                            <td>5/24</td>
                            <td>110,000</td>
                            <td>899</td>
                            <td>4.20</td>
                            <td>.20</td>
                            <td><span class="label label-primary">$420</span></td>
                        </tr>
                        <tr>
                            <td>5/23</td>
                            <td>123,000</td>
                            <td>1,000</td>
                            <td>4.20</td>
                            <td>.20</td>
                            <td><span class="label label-primary">$420</span></td>
                        </tr>
                        <tr>
                            <td>5/22</td>
                            <td>123,000</td>
                            <td>1,000</td>
                            <td>4.20</td>
                            <td>.20</td>
                            <td><span class="label label-primary">$420</span></td>
                        </tr>
                        <tr>
                            <td>5/21</td>
                            <td>123,000</td>
                            <td>1,000</td>
                            <td>4.20</td>
                            <td>.20</td>
                            <td><span class="label label-primary">$420</span></td>
                        </tr>
                        <tr>
                            <td>5/20</td>
                            <td>123,000</td>
                            <td>1,000</td>
                            <td>4.20</td>
                            <td>.20</td>
                            <td><span class="label label-primary">$420</span></td>
                        </tr>
                        <tr>
                            <td>5/19</td>
                            <td>123,000</td>
                            <td>1,000</td>
                            <td>4.20</td>
                            <td>.20</td>
                            <td><span class="label label-primary">$420</span></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function() {


                var lineData = {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [
            {
                label: "Example dataset",
                fillColor: "rgba(220,220,220,0.5)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [65, 59, 80, 81, 56, 55, 40]
            },
            {
                label: "Example dataset",
                fillColor: "rgba(26,179,148,0.5)",
                strokeColor: "rgba(26,179,148,0.7)",
                pointColor: "rgba(26,179,148,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(26,179,148,1)",
                data: [28, 48, 40, 19, 86, 27, 90]
            }
        ]
    };

    var lineOptions = {
        scaleShowGridLines: true,
        scaleGridLineColor: "rgba(0,0,0,.05)",
        scaleGridLineWidth: 1,
        bezierCurve: true,
        bezierCurveTension: 0.4,
        pointDot: true,
        pointDotRadius: 4,
        pointDotStrokeWidth: 1,
        pointHitDetectionRadius: 20,
        datasetStroke: true,
        datasetStrokeWidth: 2,
        datasetFill: true,
        responsive: true,
    };


    var ctx = document.getElementById("lineChart").getContext("2d");
    var myNewChart = new Chart(ctx).Line(lineData, lineOptions);

        });
</script>
@endsection