<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Bukren</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Patrick+Hand" rel="stylesheet"> 
        <!-- Styles -->
        <link href="{{ asset('css/modernizr.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/slider.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="mainLayout">
            <app-layout></app-layout>
        </div>
    </body>
    <script src="{{ asset('js/jssor.slider-27.5.0.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/style.js') }}"></script>

</html>
