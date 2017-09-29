@extends('layouts.app') 
@section('content') 
{{-- @if(Session::has('success'))
<div class="alert alert-success">
    <h2>{{ Session::get('success') }}</h2>
</div>
@endif  --}}
@if($user->user_type < 2)
<div class="row">
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">{{ Carbon\Carbon::now()->format('F jS') }}</span>
                <h5>Today</h5>
            </div>
            <div class="ibox-content">
                <div class="stat-percent font-bold text-success">$ {{ $pub_data['impressions_today'] }} <i class="fa fa-bolt"></i></div>
                <small>Impressions</small>
                <div class="stat-percent font-bold text-success">$ {{ $pub_data['clicks_today'] }} <i class="fa fa-bolt"></i></div>
                <small>Clicks</small>                
                <div class="stat-percent font-bold text-success">$ {{ $pub_data['earned_today'] }} <i class="fa fa-bolt"></i></div>
                <small>Earnings</small>
                <div class="stat-percent font-bold text-success">$ {{ $pub_data['earned_today'] / ($pub_data['impressions_today'] / 1000) }} <i class="fa fa-bolt"></i></div>
                <small>CPM</small>                
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-info pull-right">{{ Carbon\Carbon::now()->format('F') }}</span>
                <h5>This Month</h5>
            </div>
            <div class="ibox-content">
                <div class="stat-percent font-bold text-success">$ {{ $pub_data['impressions_this_month'] }} <i class="fa fa-bolt"></i></div>
                <small>Impressions</small>
                <div class="stat-percent font-bold text-success">$ {{ $pub_data['clicks_this_month'] }} <i class="fa fa-bolt"></i></div>
                <small>Clicks</small>                
                <div class="stat-percent font-bold text-success">$ {{ $pub_data['earned_this_month'] }} <i class="fa fa-bolt"></i></div>
                <small>Earnings</small>
                <div class="stat-percent font-bold text-success">$ {{ $pub_data['earned_this_month'] / ($pub_data['impressions_this_month'] / 1000) }} <i class="fa fa-bolt"></i></div>
                <small>CPM</small>  
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-info pull-right">{{ date('F', strtotime('last month')) }}</span>
                <h5>Last Month</h5>
            </div>
            <div class="ibox-content">
                <div class="stat-percent font-bold text-success">$ {{ $pub_data['impressions_last_month'] }} <i class="fa fa-bolt"></i></div>
                <small>Impressions</small>
                <div class="stat-percent font-bold text-success">$ {{ $pub_data['clicks_last_month'] }} <i class="fa fa-bolt"></i></div>
                <small>Clicks</small>                
                <div class="stat-percent font-bold text-success">$ {{ $pub_data['earned_last_month'] }} <i class="fa fa-bolt"></i></div>
                <small>Earnings</small>
                <div class="stat-percent font-bold text-success">$ {{ $pub_data['earned_last_month'] / ($pub_data['impressions_last_month'] / 1000) }} <i class="fa fa-bolt"></i></div>
                <small>CPM</small>  
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-info pull-right">Daily</span>
                <h5>This Year</h5>
            </div>
            <div class="ibox-content">
                <div class="stat-percent font-bold text-success">$ {{ $pub_data['impressions_this_year'] }} <i class="fa fa-bolt"></i></div>
                <small>Impressions</small>
                <div class="stat-percent font-bold text-success">$ {{ $pub_data['clicks_this_year'] }} <i class="fa fa-bolt"></i></div>
                <small>Clicks</small>                
                <div class="stat-percent font-bold text-success">$ {{ $pub_data['earned_this_year'] }} <i class="fa fa-bolt"></i></div>
                <small>Earnings</small>
                <div class="stat-percent font-bold text-success">$ {{ $pub_data['earned_this_year'] / ($pub_data['impressions_this_year'] / 1000) }} <i class="fa fa-bolt"></i></div>
                <small>CPM</small>  
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
@endif
@if($user->user_type > 1)
<div class="row">
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">{{ Carbon\Carbon::now()->format('F') }}</span>
                <h5>Impressions</h5>
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
@endif
@endsection
@section('js')
@if($user->user_type < 2)
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
@endif
@if($user->user_type > 1)
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
@endif
@endsection