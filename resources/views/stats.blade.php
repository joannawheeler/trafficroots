@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $site->site_name }} - {{ $site->site_url }}</div>

                <div class="panel-body">
                    <p>Aggregate Statistics</p>
                    <!-- make some graphs here -->
                    <canvas id="dateChart" width="800" height="400"></canvas>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
    
    });

</script>
@endsection
