<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <title>{{ config('app.name', 'Laravel') }}</title>


    @if (env('APP_ENV') == 'local')
        <script src="{{ asset('js/app.js') . '?rndstr=' . random_int(0, 1000) }}" defer></script>
        <link href="{{ asset('css/app.css') . '?rndstr=' . random_int(0, 1000) }}" rel="stylesheet">
    @else
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @endif

</head>

<body>
    <div id='dashboard'></div>
</body>

</html>
