<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_globalsign-domain-verification" content="qbw9lV17xS49YNux6uCCiE45peUkwMOWEjK5xjrONE" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} @yield('title', '')</title>

    <!-- Scripts -->
    <script>
    window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <!-- Global and page level js -->
    @include('_landing_styles')
    @include('_landing_scripts')
</head>

<body id="page-top" class="landing-page no-skin-config">
<div class="navbar-wrapper">
       <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
           <div class="container">
               <div class="navbar-header page-scroll">
               <div class="navbar-left-logo"></div>
                   <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                       <span class="sr-only">Toggle navigation</span>
                       <span class="icon-bar"></span>
                       <span class="icon-bar"></span>
                       <span class="icon-bar"></span>
                   </button>
               </div>
               <div id="navbar" class="navbar-collapse collapse">
               <a href="{{ url('/') }}"><img class="navlogo" src="{{ url('/img/landing/longlogo.png') }}" title="Home Page" alt="Traffic Roots Logo"></a>
                   <ul class="nav navbar-nav navbar-right">
                       <li><a class="page-scroll" href="#page-top">Advertisers</a></li>
                       <li><a class="page-scroll" href="#features">Publishers</a></li>
                       <li><a class="page-scroll" href="#team">Blog</a></li>
                       <li><a class="page-scroll" href="#traffic">Support</a></li>
                       <li><a href="login">Login/Sign Up</a></li>
                   </ul>
               </div>
           </div>
       </nav>
</div>
@yield('content')
<img alt="Trafficroots Analysis Pixel" src="https://publishers.trafficroots.com/pixel/58daaf821381f
https://publishers.trafficroots.com/pixel/58daaf821381f
" style="display: none;">
</body>

</html>
