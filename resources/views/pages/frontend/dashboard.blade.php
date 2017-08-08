<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FAV AND TOUCH ICONS -->
  <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>
    @section("title")
      {{ config('app.name') }}
    @show
  </title>

  <!-- Styles -->
  @section('stylesheets')
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">
  @show

  <!-- Script for CSRF TOKEN -->
  <script>
    window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
  </script>
</head>
<body>

<!-- =========================

  Content Template

============================== -->
<div id="app">
  <router-view></router-view>
</div>

<!-- =========================

  Scripts

============================== -->
<script src="{{ elixir('js/manifest.js') }}"></script>
<script src="{{ elixir('js/vendor.js') }}"></script>
<script src="{{ elixir('js/app.js') }}"></script>

</body>
</html>
