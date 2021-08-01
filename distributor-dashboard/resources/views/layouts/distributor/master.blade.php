<!DOCTYPE html>
<html>
<head>
    @include('layouts.distributor._head')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
     <!-- Navbar -->
     @include('layouts.distributor._topNav')
     <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        {{--<!-- Brand Logo -->
        <a href="{{ route('distributor.dashboard') }}" class="brand-link">
            <img src="{{asset('assets/distributor/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Suqbahrain</span>
        </a>--}}

        <!-- Sidebar -->
        @include('layouts.distributor._leftNav')
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
         @yield('content-head')
        <!-- /.content-header -->

        <!-- Main content -->
        @yield('content')
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        @include('layouts.distributor._footer')
    </footer>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

@include('layouts.distributor._script')
</body>
</html>

