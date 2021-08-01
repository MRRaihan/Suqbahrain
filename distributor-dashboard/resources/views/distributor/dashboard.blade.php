@extends('layouts.distributor.master')
@section('title', 'Distributor Dashboard')
@section('content-head')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('distributor.dashboard') }}">Dashboard</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $total_merchant }}</h3>

                            <p>Merchant Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3>{{ $merchant_today }}</h3>
                            <p>Today Merchant's</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">

                        <div class="inner">
                            
                            <h3>{{ number_format($availbleProfit, 2) }} BHD</h3>
                            <p>Your Total Earning BHD</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        
                         @if ( \Carbon\Carbon::now()->diffInDays($lastwithdraw->created_at) >= 30 )
                            @if( $availbleProfit < 1 )
                                <a style="cursor: pointer;" class="small-box-footer" data-toggle="modal" data-target="#noMuchMoney" data-bs-toggle="tooltip" data-bs-placement="bottom" title="You don't have much amount for withdraw">
                                    Withdraw ({{ floor($availbleProfit) }} BHD) <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            @elseif ($bankinfo == null )
                                <a href="{{ route('bankinfo.create')}}" class="small-box-footer" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Before withdraw you should must add your bank information, Click Here">
                                    Add Bank Information <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            @else
                            <a style="cursor: pointer;"  data-toggle="modal" data-target="#_withdraw" class="small-box-footer">
                                withdraw ({{ floor($availbleProfit) }} BHD) <i class="fas fa-arrow-circle-right"></i>
                            </a>
                            @endif
                        @else
                            <a style="cursor: pointer;" class="small-box-footer" data-toggle="modal" data-target="#withdraw_err" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Your next withdrawable date is :  {{$lastwithdraw->created_at->addDays(30)->format('j F Y')}}.">
                                Withdraw ({{ floor($availbleProfit) }} BHD) <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        @endif

                    </div>
                </div>
                <!-- ./col -->

                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ number_format($distributor_today_profit, 2) }} BHD</h3>
                            <p>Your Today Earning BHD</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-gradient-info">
                        <div class="inner">
                        
                            <h3>{{ $depositPoint }} Points</h3>

                            <p>Total Earning Point(s) </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-gem"></i>
                        </div>

                        @if ( $depositPoint >= 10000 )
                            <a href="{{ route('pointconvert.index')}}" class="small-box-footer btn">
                                Convert {{ floor($depositPoint).'P' }} = {{ number_format($depositPoint *(1/10000), 2).'BDH ' }} <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        @else
                            <a style="cursor: pointer;" class="small-box-footer btn" data-toggle="modal" data-target="#point_convert_err" data-bs-toggle="tooltip" data-bs-placement="bottom" title="After 10,000 Points Gain You Can Convert to BDH" >
                                Convert {{ floor($depositPoint).'P' }} = {{ number_format($depositPoint *(1/10000), 2).'BDH ' }}<i class="fas fa-arrow-circle-right"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <!-- ./col -->


                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                        
                            <h3>{{ $lastwithdraw->created_at->addDays(30)->format('j F Y')}}</h3>

                            <p>Next Withdrawable date </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-clock"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">
                                Your Referral Code : <b>{{ \Illuminate\Support\Facades\Auth::user()->referral_code }} </b>
                            </span>
                            <span>
                                <button   class="btn btn-primary"value="copy" onclick="copyToClipboard()">Copy Shareable link!</button>
                            </span>
                            <span class="info-box-number">
                                <input class="form-control" type="text" id="copy_refcode" value="{{ 'http://www.suqbahrain.com/users/registration?ref=' .\Illuminate\Support\Facades\Auth::user()->referral_code }}" readonly>
                            </span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                
            </div>
            <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
    <script>
        function copyToClipboard() {
            /*toastr["success"]("Your Sharable Link", "Copied...");*/
            document.getElementById("copy_refcode").select();
            document.execCommand('copy');
        }
    </script>

    <!-- _withdraw Modal -->
    @include('distributor.modal._withdraw')
    <!-- /_withdraw Modal -->

@endsection
