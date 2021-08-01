<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="@if(\Illuminate\Support\Facades\Auth::user()->avatar_original != null) {{ asset(\Illuminate\Support\Facades\Auth::user()->avatar_original) }} @else {{asset('assets/bdo/dist/img/user2-160x160.jpg')}} @endif" class="img-bordered-sm elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="{{ route('bdo.dashboard') }}" class="d-block">{{ auth()->user()->name }}</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item has-treeview menu-open">
                @php
                    $dashboard_url = Request::is('bdo/dashboard')
                @endphp
                <a href="{{route('bdo.dashboard')}}" class="nav-link {{$dashboard_url ? 'active' : ''}}">
                    <p class="ml-5">Dashboard</p>
                </a>
            </li>
            @php
                $merchant_manu = Request::is('distributor')
            @endphp
            <li class="nav-item has-treeview {{$merchant_manu ? 'menu-open' : ''}}">
                @php

                  if (Request::is('distributor')) {
                        $merchant_url = Request::is('distributor');
                    } else {
                        $merchant_url = Request::is('distributor/*');
                    }
                @endphp
                <a  href="{{route('distributor.index')}}" class="nav-link {{$merchant_url ? 'active' : ''}}">
                    <i class="nav-icon fa fa-user"></i>
                    <p>
                        Distributors
                    </p>
                </a>
            </li>
            
            <li class="nav-item has-treeview {{$merchant_manu ? 'menu-open' : ''}}">
                @php
                    if (Request::is('bankinfo')) {
                        $bank_url = Request::is('bankinfo');
                    } else {
                        $bank_url = Request::is('bankinfo/*');
                    }
                @endphp
                <a href="{{route('bankinfo.index')}}"  class="nav-link {{$bank_url ? 'active' : ''}}">
                    <i class="nav-icon fa fa-university"></i>
                    <p>
                        Bank Information
                    </p>
                </a>
            </li>
            
            
            <li class="nav-item has-treeview {{$merchant_manu ? 'menu-open' : ''}}">
                @php
                    if (Request::is('withdraw')) {
                        $bank_url = Request::is('withdraw');
                    } else {
                        $bank_url = Request::is('withdraw/*');
                    }
                @endphp
                <a href="{{route('withdraw.index')}}"  class="nav-link {{$bank_url ? 'active' : ''}}">
                    <i class="nav-icon fa fa-money-check-alt"></i>
                    <p>
                        Amount Withdraw
                    </p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
