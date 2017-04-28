@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">About Us</div>

                <div class="panel-body">
                    <p>TrafficRoots was founded by digital marketing veterans intent on creating the largest cannabis focused ad network in the US and around the Globe!</p>
                    @if (Auth::guest())
                    <p><a href="/register ">Join Us Today!</a></p>
                    @else
                    <p>Thank you for being our valued Publisher! We appreciate your trust and business!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
   <script type="text/javascript">
       jQuery(document).ready(function ($) {
               $('.nav-click').removeClass("active");
               $('#nav_about').addClass("active");
       });
   </script>
@endsection
