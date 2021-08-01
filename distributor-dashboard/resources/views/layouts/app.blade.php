<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link name="favicon" type="image/x-icon" href="{{ asset('assets/login/image/favicon.png') }}" rel="shortcut icon"/>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link href="{{ asset('assets/login/css/bootstrap.min.css')}}" rel="stylesheet">

    <!--Font Awesome [ OPTIONAL ]-->
    <link href="{{ asset('assets/login/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">

    <!--active-shop Stylesheet [ REQUIRED ]-->
    <link href="{{ asset('assets/login/css/active-shop.min.css')}}" rel="stylesheet">

    <!--active-shop Premium Icon [ DEMONSTRATION ]-->
    <link href="{{ asset('assets/login/css/demo/active-shop-demo-icons.min.css')}}" rel="stylesheet">

    <!--Demo [ DEMONSTRATION ]-->
    <link href="{{ asset('assets/login/css/demo/active-shop-demo.min.css') }}" rel="stylesheet">

    <!--Theme [ DEMONSTRATION ]-->
    <link href="{{ asset('assets/login/css/themes/type-c/theme-navy.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/login/css/custom.css') }}" rel="stylesheet">


    {{--<!-- Scripts -->
    <script src="{{ asset('js/bootstrap-toggle.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
</head>
<body>
<div id="container" class="blank-index"
     style="background-image:url('{{ asset("assets/login/image/banner.jpeg") }}');"
>
    <div class="cls-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel">
                        <div class="panel-body pad-no">
                            <div class="flex-row">
                                <div class="flex-col-xl-6 blank-index d-flex align-items-center justify-content-center"
                                     style="background-image:url('{{ asset("assets/login/image/login-box.jpg") }}');"
                                >

                                </div>
                                <div class="flex-col-xl-6">
                                    <div class="pad-all">
                                        <div class="text-center">
                                            <br>
                                            <img loading="lazy" src="{{ asset('assets/login/image/logo.png') }}"
                                                 class="" height="44">

                                            <br>
                                            <br>
                                            <br>

                                        </div>
                                        @yield('content')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--<div id="app">


    <main class="py-4">
        @yield('content')
    </main>
</div>--}}

<!--jQuery [ REQUIRED ]-->
<script src=" {{asset('assets/login/js/jquery.min.js') }}"></script>


<!--BootstrapJS [ RECOMMENDED ]-->
<script src="{{ asset('assets/login/js/bootstrap.min.js') }}"></script>


<!--active-shop [ RECOMMENDED ]-->
<script src="{{ asset('assets/login/js/active-shop.min.js') }}"></script>

<!--Alerts [ SAMPLE ]-->
<script src="{{asset('assets/login/js/demo/ui-alerts.js') }}"></script>
</body>
</html>
