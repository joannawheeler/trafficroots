@extends('layouts.app') 
@section('title', '- Campaigns')
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
    });
</script>
@endsection 

@section('content')
<div class="row">
    <div class="ibox-title">
        <h5>
            {{ $campaign->campaign_name }}
            <small class="m-l-sm">Month to date</small>
        </h5>
    </div>
    <div class="tabs-container">
        <ul class="nav nav-tabs stats-tabs">
            <li class="active">
                <a data-toggle="tab"
                    href="#dates">Dates</a>
            </li>
            <li class="nav nav-tabs">
                <a data-toggle="tab"
                    href="#countries">Countries</a>
            </li>
            <li class="nav nav-tabs">
                <a data-toggle="tab"
                    href="#states">States</a>
            </li>
            <li class="nav nav-tabs">
                <a data-toggle="tab"
                    href="#cities">Cities</a>
            </li>
            <li class="nav nav-tabs">
                <a data-toggle="tab"
                    href="#platforms">Platforms</a>
            </li>
            <li class="nav nav-tabs">
                <a data-toggle="tab"
                    href="#os">Operating Systems</a>
            </li>
            <li class="nav nav-tabs">
                <a data-toggle="tab"
                    href="#browsers">Browsers</a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="dates"
                class="tab-pane active">
                <div class="ibox-content">
                    <div class="ibox-content">
                        <input type="text"
                            class="form-control input-sm m-b-xs"
                            id="filter"
                            placeholder="Search in table">

                        <table class="footable table table-stripped"
                            data-page-size="8"
                            data-filter=#filter>
                            <thead>
                                <tr>
                                    <tr>
                                        <th>Date</th>
                                        <th>Impressions</th>
                                        <th>Clicks</th>
                                        <th>CTR</th>
                                        <th>Cost</th>
                                    </tr>
                            </thead>
                            <tbody>
                                @foreach ($campaign->stats->groupBy('stat_date')->all() as $day)
                                <tr>
                                    <td>{{ $day->first()->stat_date }} </td>
                                    <td>{{ $day->sum('impressions') }}</td>
                                    <td>{{ $day->sum('clicks') }}</td>
                                    <td>{{ ($day->sum('impressions')/1000) * $day->sum('clicks') }}%</td>
                                    <td>${{ number_format(
                                            $day->reduce(function($cost, $stat) { 
                                                    return $cost + (($stat->impressions / 1000) * $stat->cpm); 
                                                }), 2
                                            ) }}</td>
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
            <div id="countries"
                class="tab-pane">
                <div class="ibox-content">
                    <div class="ibox-content">
                        <input type="text"
                            class="form-control input-sm m-b-xs"
                            id="filter"
                            placeholder="Search in table">

                        <table class="footable table table-stripped"
                            data-page-size="8"
                            data-filter=#filter>
                            <thead>
                                <tr>
                                    <tr>
                                        <th>Country</th>
                                        <th>Impressions</th>
                                        <th>Clicks</th>
                                        <th>CTR</th>
                                        <th>Cost</th>
                                    </tr>
                            </thead>
                            <tbody>
                                @foreach ($campaign->stats->groupBy('country_id')->all() as $country) 
                                        <tr>
                                            <td>{{ $country->first()->country->country_name }} </td>
                                            <td>{{ $country->sum('impressions') }}</td>
                                            <td>{{ $country->sum('clicks') }}</td>
                                            <td>{{ ($country->sum('impressions')/1000) * $country->sum('clicks') }}%</td>
                                            <td>${{ number_format(
                                                $country->reduce(function($cost, $stat) { 
                                                    return $cost + (($stat->impressions / 1000) * $stat->cpm); 
                                                }), 2
                                            ) }}</td>
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
            <div id="states"
                class="tab-pane">
                <div class="ibox-content">
                    <div class="ibox-content">
                        <input type="text"
                            class="form-control input-sm m-b-xs"
                            id="filter"
                            placeholder="Search in table">

                        <table class="footable table table-stripped"
                            data-page-size="8"
                            data-filter=#filter>
                            <thead>
                                <tr>
                                    <tr>
                                        <th>State</th>
                                        <th>Impressions</th>
                                        <th>Clicks</th>
                                        <th>CTR</th>
                                        <th>Cost</th>
                                    </tr>
                            </thead>
                            <tbody>
                                @foreach ($campaign->stats->groupBy('state_code')->all() as $state) 
                                        <tr>
                                            <td>{{ $state->first()->state->state_name }} </td>
                                            <td>{{ $state->sum('impressions') }}</td>
                                            <td>{{ $state->sum('clicks') }}</td>
                                            <td>{{ ($state->sum('impressions')/1000) * $state->sum('clicks') }}%</td>
                                            <td>${{ number_format(
                                                    $state->reduce(function($cost, $stat) { 
                                                        return $cost + (($stat->impressions / 1000) * $stat->cpm); 
                                                    }), 2
                                                ) }}</td>
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
            <div id="cities"
                class="tab-pane">
                <div class="ibox-content">
                    <div class="ibox-content">
                        <input type="text"
                            class="form-control input-sm m-b-xs"
                            id="filter"
                            placeholder="Search in table">

                        <table class="footable table table-stripped"
                            data-page-size="8"
                            data-filter=#filter>
                            <thead>
                                <tr>
                                    <tr>
                                        <th>City</th>
                                        <th>Impressions</th>
                                        <th>Clicks</th>
                                        <th>CTR</th>
                                        <th>Cost</th>
                                    </tr>
                            </thead>
                            <tbody>
                                @foreach ($campaign->stats->groupBy('city_code')->all() as $city) 
                                        <tr>
                                            <td>{{ $city->first()->city->city_name }} </td>
                                            <td>{{ $city->sum('impressions') }}</td>
                                            <td>{{ $city->sum('clicks') }}</td>
                                            <td>{{ ($city->sum('impressions')/1000) * $city->sum('clicks') }}%</td>
                                            <td>${{ number_format(
                                            $city->reduce(function($cost, $stat) { 
                                                    return $cost + (($stat->impressions / 1000) * $stat->cpm); 
                                                }), 2
                                            ) }}</td>
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
            <div id="platforms"
                class="tab-pane">
                <div class="ibox-content">
                    <div class="ibox-content">
                        <input type="text"
                            class="form-control input-sm m-b-xs"
                            id="filter"
                            placeholder="Search in table">

                        <table class="footable table table-stripped"
                            data-page-size="8"
                            data-filter=#filter>
                            <thead>
                                <tr>
                                    <tr>
                                        <th>Platform</th>
                                        <th>Impressions</th>
                                        <th>Clicks</th>
                                        <th>CTR</th>
                                        <th>Cost</th>
                                    </tr>
                            </thead>
                            <tbody>
                                @foreach ($campaign->stats->groupBy('platform')->all() as $platform) 
                                        <tr>
                                            <td>{{ $platform->first()->platformType->platform }} </td>
                                            <td>{{ $platform->sum('impressions') }}</td>
                                            <td>{{ $platform->sum('clicks') }}</td>
                                            <td>{{ ($platform->sum('impressions')/1000) * $platform->sum('clicks') }}%</td>
                                            <td>${{ number_format(
                                                    $platform->reduce(function($cost, $stat) { 
                                                        return $cost + (($stat->impressions / 1000) * $stat->cpm); 
                                                    }), 2
                                                ) }}</td>
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
            <div id="os"
                class="tab-pane">
                <div class="ibox-content">
                    <div class="ibox-content">
                        <input type="text"
                            class="form-control input-sm m-b-xs"
                            id="filter"
                            placeholder="Search in table">

                        <table class="footable table table-stripped"
                            data-page-size="8"
                            data-filter=#filter>
                            <thead>
                                <tr>
                                    <tr>
                                        <th>Operating System</th>
                                        <th>Impressions</th>
                                        <th>Clicks</th>
                                        <th>CTR</th>
                                        <th>Cost</th>
                                    </tr>
                            </thead>
                            <tbody>
                                @foreach ($campaign->stats->groupBy('os')->all() as $os) 
                                        <tr>
                                            <td>{{ $os->first()->operatingSystem->os }} </td>
                                            <td>{{ $os->sum('impressions') }}</td>
                                            <td>{{ $os->sum('clicks') }}</td>
                                            <td>{{ ($os->sum('impressions')/1000) * $os->sum('clicks') }}%</td>
                                            <td>${{ number_format(
                                                    $os->reduce(function($cost, $stat) { 
                                                        return $cost + (($stat->impressions / 1000) * $stat->cpm); 
                                                    }), 2
                                                ) }}</td>
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
            <div id="browsers"
                class="tab-pane">
                <div class="ibox-content">
                    <div class="ibox-content">
                        <input type="text"
                            class="form-control input-sm m-b-xs"
                            id="filter"
                            placeholder="Search in table">

                        <table class="footable table table-stripped"
                            data-page-size="8"
                            data-filter=#filter>
                            <thead>
                                <tr>
                                    <tr>
                                        <th>Browser</th>
                                        <th>Impressions</th>
                                        <th>Clicks</th>
                                        <th>CTR</th>
                                        <th>Cost</th>
                                    </tr>
                            </thead>
                            <tbody>
                                @foreach ($campaign->stats->groupBy('browser')->all() as $browser) 
                                        <tr>
                                            <td>{{ $browser->first()->browserType->browser }} </td>
                                            <td>{{ $browser->sum('impressions') }}</td>
                                            <td>{{ $browser->sum('clicks') }}</td>
                                            <td>{{ ($browser->sum('impressions')/1000) * $browser->sum('clicks') }}%</td>
                                            <td>${{ number_format(
                                                    $browser->reduce(function($cost, $stat) { 
                                                        return $cost + (($stat->impressions / 1000) * $stat->cpm); 
                                                    }), 2
                                                ) }}</td>
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
        </div>
    </div>
@endsection
