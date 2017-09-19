@extends('layouts.app') 

@section('css')
<link href="{{ URL::asset('css/plugins/footable/footable.core.css') }}" rel="stylesheet">
<style type="text/css">
    @media only screen and (min-width: 769px) {
        .stats-tabs {
            display: flex;
            justify-content: space-between;
        }
        .stats-tabs:before,
        .stats-tabs:after {
            display: none;
        }
    }

    .hide {
        display: none;
    }
</style>


@endsection 

@section('js')
<script src="{{ URL::asset('js/plugins/footable/footable.all.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.footable').footable();
        $('.footable').removeClass('hide');
    });
</script>
@endsection 

@section('content')
<div class="row">
    <div class="ibox-title">
        <h5>
            {{ $site_name }}
            <small class="m-l-sm">Year to date</small>
        </h5>
    </div>
    <div class="tabs-container">
        <ul class="nav nav-tabs stats-tabs">
            <li class="active">
                <a data-toggle="tab" href="#dates">Dates</a>
            </li>
            <li class="nav nav-tabs">
                <a data-toggle="tab" href="#countries">Countries</a>
            </li>
            <li class="nav nav-tabs">
                <a data-toggle="tab" href="#states">States</a>
            </li>
            <li class="nav nav-tabs">
                <a data-toggle="tab" href="#cities">Cities</a>
            </li>
            <li class="nav nav-tabs">
                <a data-toggle="tab" href="#platforms">Platforms</a>
            </li>
            <li class="nav nav-tabs">
                <a data-toggle="tab" href="#os">Operating Systems</a>
            </li>
            <li class="nav nav-tabs">
                <a data-toggle="tab" href="#browsers">Browsers</a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="dates" class="tab-pane active">
                <div class="ibox-content">
                    <div class="ibox-content">
                        <input type="text" class="form-control input-sm m-b-xs" id="filter" placeholder="Search in table">

                        <table class="footable table table-stripped hide" data-page-size="8" data-filter=#filter>
                            <thead>
                                <tr>
                                    <tr>
                                        <th>Date</th>
                                        <th>Impressions</th>
                                        <th>Clicks</th>
                                        <th>CTR</th>
                                    </tr>
                            </thead>
                            <tbody>
                                @foreach ($stats->groupBy('stat_date') as $day)
                                <tr>
                                    <td>{{ $day->first()->stat_date }} </td>
                                    <td>{{ $stats->where('stat_date', $day->first()->stat_date)->sum('impressions') }}</td>
                                    <td>{{ $stats->where('stat_date', $day->first()->stat_date)->sum('clicks') }}</td>
                                    <td>{{ ($stats->where('stat_date', $day->first()->stat_date)->sum('impressions')/1000) * $stats->where('stat_date', $day->first()->stat_date)->sum('clicks') }}%</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <ul class="pagination pull-right"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div id="countries" class="tab-pane">
                <div class="ibox-content">
                    <div class="ibox-content">
                        <input type="text" class="form-control input-sm m-b-xs" id="filter" placeholder="Search in table">

                        <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                            <thead>
                                <tr>
                                    <tr>
                                        <th>Country</th>
                                        <th>Impressions</th>
                                        <th>Clicks</th>
                                        <th>CTR</th>
                                    </tr>
                            </thead>
                            <tbody>
                                @foreach (App\Country::all() as $country) 
                                    @if($stats->where('country_id', $country->id)->sum('impressions'))
                                        <tr>
                                            <td>{{ $country->country_name }} </td>
                                            <td>{{ $stats->where('country_id', $country->id)->sum('impressions') }}</td>
                                            <td>{{ $stats->where('country_id', $country->id)->sum('clicks') }}</td>
                                            <td>{{ ($stats->where('country_id', $country->id)->sum('impressions')/1000) * $stats->where('country_id', $country->id)->sum('clicks') }}%</td>
                                        </tr>
                                    @endif 
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <ul class="pagination pull-right"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div id="states" class="tab-pane">
                <div class="ibox-content">
                    <div class="ibox-content">
                        <input type="text" class="form-control input-sm m-b-xs" id="filter" placeholder="Search in table">

                        <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                            <thead>
                                <tr>
                                    <tr>
                                        <th>State</th>
                                        <th>Impressions</th>
                                        <th>Clicks</th>
                                        <th>CTR</th>
                                    </tr>
                            </thead>
                            <tbody>
                                @foreach (App\State::all() as $state) 
                                    @if($stats->where('state_code', $state->id)->sum('impressions'))
                                        <tr>
                                            <td>{{ $state->state_name }} </td>
                                            <td>{{ $stats->where('state_code', $state->id)->sum('impressions') }}</td>
                                            <td>{{ $stats->where('state_code', $state->id)->sum('clicks') }}</td>
                                            <td>{{ ($stats->where('state_code', $state->id)->sum('impressions')/1000) * $stats->where('state_code', $state->id)->sum('clicks') }}%</td>
                                        </tr>
                                    @endif 
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <ul class="pagination pull-right"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div id="cities" class="tab-pane">
                <div class="ibox-content">
                    <div class="ibox-content">
                        <input type="text" class="form-control input-sm m-b-xs" id="filter" placeholder="Search in table">

                        <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                            <thead>
                                <tr>
                                    <tr>
                                        <th>City</th>
                                        <th>Impressions</th>
                                        <th>Clicks</th>
                                        <th>CTR</th>
                                    </tr>
                            </thead>
                            <tbody>
                                @foreach (App\City::all() as $city) 
                                    @if($stats->where('city_code', $city->id)->sum('impressions'))
                                        <tr>
                                            <td>{{ $city->city_name }} </td>
                                            <td>{{ $stats->where('city_code', $city->id)->sum('impressions') }}</td>
                                            <td>{{ $stats->where('city_code', $city->id)->sum('clicks') }}</td>
                                            <td>{{ ($stats->where('city_code', $city->id)->sum('impressions')/1000) * $stats->where('country_id', $city->id)->sum('clicks') }}%</td>
                                        </tr>
                                    @endif 
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <ul class="pagination pull-right"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div id="platforms" class="tab-pane">
                <div class="ibox-content">
                    <div class="ibox-content">
                        <input type="text" class="form-control input-sm m-b-xs" id="filter" placeholder="Search in table">

                        <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                            <thead>
                                <tr>
                                    <tr>
                                        <th>Platform</th>
                                        <th>Impressions</th>
                                        <th>Clicks</th>
                                        <th>CTR</th>
                                    </tr>
                            </thead>
                            <tbody>
                                @foreach (App\Platform::all() as $platform) 
                                    @if($stats->where('platform', $platform->id)->sum('impressions'))
                                        <tr>
                                            <td>{{ $platform->platform }} </td>
                                            <td>{{ $stats->where('platform', $platform->id)->sum('impressions') }}</td>
                                            <td>{{ $stats->where('platform', $platform->id)->sum('clicks') }}</td>
                                            <td>{{ ($stats->where('platform', $platform->id)->sum('impressions')/1000) * $stats->where('platform', $platform->id)->sum('clicks') }}%</td>
                                        </tr>
                                    @endif 
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <ul class="pagination pull-right"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div id="os" class="tab-pane">
                <div class="ibox-content">
                    <div class="ibox-content">
                        <input type="text" class="form-control input-sm m-b-xs" id="filter" placeholder="Search in table">

                        <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                            <thead>
                                <tr>
                                    <tr>
                                        <th>Operating System</th>
                                        <th>Impressions</th>
                                        <th>Clicks</th>
                                        <th>CTR</th>
                                    </tr>
                            </thead>
                            <tbody>
                                @foreach (App\OperatingSystem::all() as $os) 
                                    @if($stats->where('os', $os->id)->sum('impressions'))
                                        <tr>
                                            <td>{{ $os->os }} </td>
                                            <td>{{ $stats->where('os', $os->id)->sum('impressions') }}</td>
                                            <td>{{ $stats->where('os', $os->id)->sum('clicks') }}</td>
                                            <td>{{ ($stats->where('os', $os->id)->sum('impressions')/1000) * $stats->where('os', $os->id)->sum('clicks') }}%</td>
                                        </tr>
                                    @endif 
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <ul class="pagination pull-right"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div id="browsers" class="tab-pane">
                <div class="ibox-content">
                    <div class="ibox-content">
                        <input type="text" class="form-control input-sm m-b-xs" id="filter" placeholder="Search in table">

                        <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                            <thead>
                                <tr>
                                    <tr>
                                        <th>Browser</th>
                                        <th>Impressions</th>
                                        <th>Clicks</th>
                                        <th>CTR</th>
                                    </tr>
                            </thead>
                            <tbody>
                                @foreach (App\Browser::all() as $browser) 
                                    @if($stats->where('browser', $browser->id)->sum('impressions'))
                                        <tr>
                                            <td>{{ $browser->browser }} </td>
                                            <td>{{ $stats->where('browser', $browser->id)->sum('impressions') }}</td>
                                            <td>{{ $stats->where('browser', $browser->id)->sum('clicks') }}</td>
                                            <td>{{ ($stats->where('browser', $browser->id)->sum('impressions')/1000) * $stats->where('browser', $browser->id)->sum('clicks') }}%</td>
                                        </tr>
                                    @endif 
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <ul class="pagination pull-right"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
