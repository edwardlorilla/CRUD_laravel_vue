<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>
        <meta name="_token" content="{{ csrf_token() }}"/>
        <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->

    </head>
    <body>
        <div class="flex-center position-ref full-height">


            <div id="app" class="content">

            </div>
        </div>
        <script src="{{ URL::asset('js/app.js') }}"></script>
    </body>
</html>
