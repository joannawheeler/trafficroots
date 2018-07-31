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

    @include('_landing_styles')
    @include('_landing_scripts')
</head>

<body>
    @yield('content')
</body>

</html>