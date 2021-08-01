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
                                     style="background-image:url('{{ asset("assets/login/image/login-box.jpg") }}');"
                                >

                                </div>
                                <div class="flex-col-xl-6">
                                    <div class="pad-all">
                                        <div class="text-center">
                                            <br>
                                            <img loading="lazy"  src="{{ asset('assets/login/image/logo.png') }}" class="" height="44">

                                            <br>
                                            <br>
                                            <br>

                                        </div>
                                        <form class="pad-hor" action="{{ route('login') }}" method="POST">
                                            @csrf

                                            <div class="form-group">
                                                <input  class="form-control" id="email" type="email"  name="email" value="{{ old('email') }}"  autocomplete="email" autofocus placeholder="BDO Email">
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
                                                    <div class="checkbox pad-btm text-left">
                                                        <label for="demo-form-checkbox">
                                                            @if (Route::has('password.request'))
                                                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                                                    {{ __('Forgot Password?') }}
                                                                </a>
                                                            @endif
                                                        </label>
                                                    </div>
                                                </div>

                                               {{-- <div class="col-6 text-right">
                                                    <a href="{{ route('change.password') }}" class="link link-xs link--style-3">Forgot password?</a>
                                                </div>--}}
                                                {{--<div class="col-6 text-right">
                                                    <a href="{{ route('password.request') }}" class="link link-xs link--style-3">{{__('Forgot password?')}}</a>
                                                </div>--}}

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



{{--

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Distributor || Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Font Awesome -->
<link rel="stylesheet" href="{{asset('assets/bdo/plugins/fontawesome-free/css/all.min.css')}}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- icheck bootstrap -->
<link rel="stylesheet" href="{{asset('assets/bdo/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('assets/bdo/dist/css/adminlte.min.css')}}">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <div><b>Distributor</b></div>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form  action="{{ route('login') }}" method="POST">
                @csrf

                <div class="input-group mb-3">
                    <input  class="form-control" id="email" type="email"  name="email" value="{{ old('email') }}"  autocomplete="email" autofocus placeholder="Distributor Email">
                </div>
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                @enderror

                <div class="input-group mb-3">
                    <input  class="form-control"  id="password" type="password"   name="password"  autocomplete="current-password" placeholder="Password">
                </div>
                @error('password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                --}}
{{-- <div class="row">
                     <div class="col-8">
                         <div class="icheck-primary">
                             <input type="checkbox"  name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                             <label class="form-check-label" for="remember">
                                 {{ __('Remember Me') }}
                             </label>
                         </div>
                     </div>
                 </div>--}}{{--

                <div class="social-auth-links text-center mb-3">
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
            </form>

            <!-- /.social-auth-links -->
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('assets/bdo/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets/bdo/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/bdo/dist/js/adminlte.min.js')}}"></script>

</body>
</html>--}}
