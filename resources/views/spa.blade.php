<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @section('title')
            {{ config('app.name') }}
        @show
    </title>

    @section('scripts')
        <script src="{{ mix('/js/app.js') }}" defer></script>
    @show
    @section('styles')
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    @show

</head>
<body>
@section('main')
    <div id="root"></div>
@show
</body>
</html>
