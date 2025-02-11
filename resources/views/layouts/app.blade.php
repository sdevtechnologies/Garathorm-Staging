<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta http-equiv="Content-Security-Policy" content="default-src 'self' ;
        img-src 'self'      data:;
        font-src 'self'     https://fonts.bunny.net;
        style-src 'self'    https://fonts.bunny.net
                            https://cdn.jsdelivr.net
                            https://cdnjs.cloudflare.com
                            'sha256-47DEQpj8HBSa+/TImW+5JCeuQeRkm5NMpJWZG3hSuFU='
                            'sha256-+pmDa8uXN8Kj5xN6VqwPVeqEISYMYmznE4Il6eDKAZM=';
        script-src 'self'   https://code.jquery.com
                            https://cdn.jsdelivr.net
                            https://cdnjs.cloudflare.com;
        form-action 'self';">

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="stylesheet" href="{{URL::to('bootstrap-5.3.3-dist/css/bootstrap.min.css')}}"/>
        <link rel="stylesheet" href="{{URL::to('fontawesome-free-6.5.1-web/css/all.css')}}"/>
        <link rel="stylesheet" href="{{URL::to('custom/css/homepage.css')}}"/>
        <!-- Tempus Dominus Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/css/tempus-dominus.min.css" crossorigin="anonymous">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    </head>
    <body>
        <div class="wrapper">
            @include('layouts.navigation')
            <div class="main"> 
                @include('layouts.sidebar')
                <main class="content">
                    <div class="container-fluid">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
        
    <script src="{{URL::to('custom/js/homepage.js')}}"></script>
    <script src="{{URL::to('bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js')}}"></script>
    
     </body>
    
</html>
