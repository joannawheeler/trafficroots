@extends('layouts.app') 
@section('content') 
{{-- @if(Session::has('success'))
<div class="alert alert-success">
    <h2>{{ Session::get('success') }}</h2>
</div>
@endif  --}}
@if($view_type == 1 || $view_type == 3)
<div class="row">
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">{{ Carbon\Carbon::now()->format('F jS') }}</span>
                <h5>Today</h5>
            </div>
            <div class="ibox-content">
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($pub_data['impressions_today']) }}</div>
                <small>Impressions</small><br />
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($pub_data['clicks_today']) }}</div>
                <small>Clicks</small><br />                
                <div class="stat-percent font-bold text-success pull-right">$ {{ round($pub_data['earned_today'],2) }}</div>
                <small>Earnings</small><br />
                <div class="stat-percent font-bold text-success">$ {{ round($pub_data['cpm_today'],2) }}</div>
                <small>CPM</small>                
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">{{ Carbon\Carbon::now()->format('F') }}</span>
                <h5>This Month</h5>
            </div>
            <div class="ibox-content">
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($pub_data['impressions_this_month']) }}</div>
                <small>Impressions</small><br />
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($pub_data['clicks_this_month']) }}</div>
                <small>Clicks</small><br />                
                <div class="stat-percent font-bold text-success pull-right">$ {{ round($pub_data['earned_this_month'],2) }}</div>
                <small>Earnings</small><br />
                <div class="stat-percent font-bold text-success pull-right">$ {{ round($pub_data['cpm_this_month'],2) }}</div>
                <small>CPM</small>  
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">{{ date('F', strtotime('last month')) }}</span>
                <h5>Last Month</h5>
            </div>
            <div class="ibox-content">
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($pub_data['impressions_last_month']) }}</div>
                <small>Impressions</small><br />
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($pub_data['clicks_last_month']) }}</div>
                <small>Clicks</small><br />                
                <div class="stat-percent font-bold text-success pull-right">$ {{ round($pub_data['earned_last_month'],2) }}</div>
                <small>Earnings</small><br />
                <div class="stat-percent font-bold text-success pull-right">$ {{ round($pub_data['cpm_last_month'],2) }}</div>
                <small>CPM</small>  
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">{{ date('Y') }}</span>
                <h5>This Year</h5>
            </div>
            <div class="ibox-content">
                <div class="stat-percent font-bold text-success">{{ number_format($pub_data['impressions_this_year']) }}</div>
                <small>Impressions</small><br />
                <div class="stat-percent font-bold text-success">{{ number_format($pub_data['clicks_this_year']) }}</div>
                <small>Clicks</small><br />                
                <div class="stat-percent font-bold text-success">$ {{ round($pub_data['earned_this_year'],2) }}</div>
                <small>Earnings</small><br />
                <div class="stat-percent font-bold text-success">$ {{ round($pub_data['cpm_this_year'],2) }}</div>
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
                <h5>Sites - {{ date('F') }}</h5>
            </div>
            <div class="ibox-content">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Site</th>
                            <th>Days Active</th>
                            <th>Impressions</th>
                            <th>Clicks</th>
                            <th>CPM</th>
                            <th>CPC</th>
                            <th>Earnings</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($pub_data['sites'] as $site)
                        <tr>
                            <td>{{ $site->site_name }}</td>
                            <td>{{ $site->days_active }} </td>
                            <td>{{ $site->impressions }}</td>
                            <td>{{ $site->clicks }}</td>
                            <td>{{ $cpm = $site->impressions ? round($site->earned / ($site->impressions / 1000),2) : 0 }}</td>
                            <td>{{ $cpc = $site->clicks ? round($site->earned / $site->clicks,2): 0 }}</td>
                            <td>{{ money_format('%(#10n',$site->earned) }}</td>
                        </tr>
                    @endforeach
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
		var timeFormat = 'MM/DD/YYYY HH:mm';


                var lineData = {
        labels: [@foreach($pub_data['last_thirty_days'] as $key => $value)
                    new Date('{{ $key }}').toLocaleDateString(),
                 @endforeach
                ],
        datasets: [
            {
                label: "Impressions",
                fillColor: "rgba(220,220,220,0.5)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [@foreach($pub_data['last_thirty_days'] as $key => $value)
                    {{ $value['impressions'].',' }}
                 @endforeach]
            },
            {
                label: "Clicks",
                fillColor: "rgba(26,179,148,0.5)",
                strokeColor: "rgba(26,179,148,0.7)",
                pointColor: "rgba(26,179,148,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(26,179,148,1)",
                data: [@foreach($pub_data['last_thirty_days'] as $key => $value)
                    {{ $value['clicks'].',' }}
                 @endforeach]
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
                                scales: {
                                        xAxes: [{
                                                type: "time",
                                                time: {
                                                        format: timeFormat,
                                                        // round: 'day'
                                                        tooltipFormat: 'MMM D'
                                                },
                                                scaleLabel: {
                                                        display: true,
                                                        labelString: 'Date'
                                                }
                                        }, ],
                                        yAxes: [{
                                                scaleLabel: {
                                                        display: true,
                                                        labelString: 'value'
                                                }
                                        }]
                                },
    };


    var ctx = document.getElementById("lineChart").getContext("2d");
    var myNewChart = new Chart(ctx).Line(lineData, lineOptions);

    });
</script>
@endif
@if($view_type == 2)
<div class="row">
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">{{ Carbon\Carbon::now()->format('F jS') }}</span>
                <h5>Today</h5>
            </div>
            <div class="ibox-content">
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($buyer_data['impressions_today']) }}</div>
                <small>Impressions</small><br />
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($buyer_data['clicks_today']) }}</div>
                <small>Clicks</small><br />                
                <div class="stat-percent font-bold text-success pull-right">$ {{ round($buyer_data['spent_today'],2) }}</div>
                <small>Spend</small><br />
                <div class="stat-percent font-bold text-success">$ {{ round($buyer_data['current_balance'],2) }}</div>
                <small>Balance</small>                
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">{{ date('F jS',strtotime('yesterday')) }}</span>
                <h5>Yesterday</h5>
            </div>
            <div class="ibox-content">
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($buyer_data['impressions_yesterday']) }}</div>
                <small>Impressions</small><br />
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($buyer_data['clicks_yesterday']) }}</div>
                <small>Clicks</small><br />                
                <div class="stat-percent font-bold text-success pull-right">$ {{ round($buyer_data['spent_yesterday'],2) }}</div>
                <small>Spend</small><br />
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">{{ date('F') }}</span>
                <h5>This Month</h5>
            </div>
            <div class="ibox-content">
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($buyer_data['impressions_this_month']) }}</div>
                <small>Impressions</small><br />
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($buyer_data['clicks_this_month']) }}</div>
                <small>Clicks</small><br />                
                <div class="stat-percent font-bold text-success pull-right">$ {{ round($buyer_data['spent_this_month'],2) }}</div>
                <small>Spend</small><br />
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">{{ date('F', strtotime('last month')) }}</span>
                <h5>Last Month</h5>
            </div>
            <div class="ibox-content">
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($buyer_data['impressions_last_month']) }}</div>
                <small>Impressions</small><br />
                <div class="stat-percent font-bold text-success pull-right">{{ number_format($buyer_data['clicks_last_month']) }}</div>
                <small>Clicks</small><br />                
                <div class="stat-percent font-bold text-success pull-right">$ {{ round($buyer_data['spend_last_month'],2) }}</div>
                <small>Spend</small><br />
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
                <h5>Campaigns - {{ date('F') }}</h5>
            </div>
            <div class="ibox-content">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Campaign</th>
                            <th>Days Active</th>
                            <th>Impressions</th>
                            <th>Clicks</th>
                            <th>Earnings</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($buyer_data['campaigns'] as $campaign)
                        <tr>
                            <td>{{ $site->site_name }}</td>
                            <td>{{ $site->days_active }} </td>
                            <td>{{ $site->impressions }}</td>
                            <td>{{ $site->clicks }}</td>
                            <td>{{ $cpm = $site->impressions ? round($site->earned / ($site->impressions / 1000),2) : 0 }}</td>
                            <td>{{ $cpc = $site->clicks ? round($site->earned / $site->clicks,2): 0 }}</td>
                            <td>{{ money_format('%(#10n',$site->earned) }}</td>
                        </tr>
                    @endforeach
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
		var timeFormat = 'MM/DD/YYYY HH:mm';


                var lineData = {
        labels: [@foreach($buyer_data['last_thirty_days'] as $key => $value)
                    new Date('{{ $key }}').toLocaleDateString(),
                 @endforeach
                ],
        datasets: [
            {
                label: "Impressions",
                fillColor: "rgba(220,220,220,0.5)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [@foreach($buyer_data['last_thirty_days'] as $key => $value)
                    {{ $value['impressions'].',' }}
                 @endforeach]
            },
            {
                label: "Clicks",
                fillColor: "rgba(26,179,148,0.5)",
                strokeColor: "rgba(26,179,148,0.7)",
                pointColor: "rgba(26,179,148,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(26,179,148,1)",
                data: [@foreach($buyer_data['last_thirty_days'] as $key => $value)
                    {{ $value['clicks'].',' }}
                 @endforeach]
            },
            {
                label: "Spend",
                fillColor: "rgba(66,134,234,0.5)",
                strokeColor: "rgba(66,134,234,0.7)",
                pointColor: "rgba(66,134,234,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(26,179,148,1)",
                data: [@foreach($buyer_data['last_thirty_days'] as $key => $value)
                    {{ $value['spend'].',' }}
                 @endforeach]
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
                                scales: {
                                        xAxes: [{
                                                type: "time",
                                                time: {
                                                        format: timeFormat,
                                                        // round: 'day'
                                                        tooltipFormat: 'MMM D'
                                                },
                                                scaleLabel: {
                                                        display: true,
                                                        labelString: 'Date'
                                                }
                                        }, ],
                                        yAxes: [{
                                                scaleLabel: {
                                                        display: true,
                                                        labelString: 'value'
                                                }
                                        }]
                                },
    };


    var ctx = document.getElementById("lineChart").getContext("2d");
    var myNewChart = new Chart(ctx).Line(lineData, lineOptions);

    });
</script>
@endif
@endsection
