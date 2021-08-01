<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link name="favicon" type="image/x-icon" href="{{ asset('assets/login/image/favicon.png') }}" rel="shortcut icon" />

    <title>Distributor || login</title>

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
                                     style="background-image:url('{{ asset("assets/login/image/distributor.jpg") }}');"
                                >

                                </div>
                                <div class="flex-col-xl-6">
                                    <div class="pad-all">
                                        <div class="text-center">
                                            <br>
                                            <img loading="lazy"  src="{{ asset('assets/login/image/logo.png') }}" class="" height="44">
                                            
                                            <br>
                                            <h4>Distributor Login</h4>
                                            <br>
                                            <br> 
                                        </div>
                                        <form class="pad-hor" action="{{ route('login') }}" method="POST">
                                            @csrf
                                            
                                        
                                            <div class="form-group">
                                                <input  class="form-control" id="email" type="email"  name="email" value="{{ old('email') }}"  autocomplete="email" autofocus placeholder="Distributor Email">
                                            </div>
                                            @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror

                                            <div class="form-group">
                                                <input  class="form-control"  id="password" type="password"   name="password"  autocomplete="current-password" placeholder="Password">
                                            </div>
                                            @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="checkbox pad-btm text-left">
                                                        <input id="demo-form-checkbox" class="magic-checkbox" type="checkbox" name="remember" id="remember" >
                                                        <label for="demo-form-checkbox">
                                                            Remember Me
                                                        </label>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="col-sm-6 text-right">
                                                    <div class="checkbox pad-btm text-right">
                                                        @if (Route::has('password.request'))
                                                            <a class="text-primary" style="margin-top: -8px;" href="{{ route('password.request') }}">
                                                                {{ __('Forgot Password?') }}
                                                            </a>
                                                        @endif
                                                    </div>
                                               </div>
                                            
                                            
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                                Login
                                            </button>
                                        </form>
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

<!--JAVASCRIPT-->
<!--=================================================-->

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



