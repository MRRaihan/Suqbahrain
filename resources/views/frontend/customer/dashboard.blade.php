@extends('frontend.layouts.app')

@section('content')

    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @include('frontend.inc.customer_side_nav')
                </div>
                <div class="col-lg-9">
                    <!-- Page title -->
                    <div class="page-title">
                        <div class="row align-items-center">
                            <div class="col-md-6 col-12">
                                <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                    {{__('Dashboard')}}
                                </h2>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="float-md-right">
                                    <ul class="breadcrumb">
                                        <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                        <li class="active"><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- dashboard content -->
                    <div class="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="dashboard-widget text-center green-widget mt-4 c-pointer">
                                    <a href="javascript:;" class="d-block">
                                        <i class="fa fa-shopping-cart"></i>
                                        @if(Session::has('cart'))
                                            <span class="d-block title">{{ count(Session::get('cart'))}} {{__('Product(s)')}}</span>
                                        @else
                                            <span class="d-block title">0 {{__('Product')}}</span>
                                        @endif
                                        <span class="d-block sub-title">{{__('in your cart')}}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="dashboard-widget text-center red-widget mt-4 c-pointer">
                                    <a href="javascript:;" class="d-block">
                                        <i class="fa fa-heart"></i>
                                        <span class="d-block title">{{ count(Auth::user()->wishlists)}} {{__('Product(s)')}}</span>
                                        <span class="d-block sub-title">{{__('in your wishlist')}}</span>
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="dashboard-widget text-center yellow-widget mt-4 c-pointer">
                                    <a href="javascript:;" class="d-block">
                                        <i class="fa fa-building"></i>
                                        @php
                                            $orders = \App\Order::where('user_id', Auth::user()->id)->get();
                                            $total = 0;
                                            foreach ($orders as $key => $order) {
                                                $total += count($order->orderDetails);
                                            }
                                        @endphp
                                        <span class="d-block title">{{ $total }} {{__('Product(s)')}}</span>
                                        <span class="d-block sub-title">{{__('you ordered')}}</span>
                                    </a>
                                </div>
                            </div>

                            @if(\Illuminate\Support\Facades\Auth::user()->is_merchant == 1 )

                                {{-- Total BHD Earning --}}
                                <div class="col-md-4">
                                    <div class="dashboard-widget text-center bg-primary mt-4 c-pointer">
                                        <a href="javascript:;" class="d-block">
                                            <i class="fa fa-shopping-bag"></i>
                                            <span class="d-block title">{{ number_format($availbleProfit, 2) }} {{ __('(BHD) Total Earning')}}</span>
                                            <span class="d-block sub-title">{{__('My Profit (50%)')}}</span>
                                        </a>
                                    </div>
                                </div>

                                {{-- Today gain profit --}}
                                <div class="col-md-4">
                                    <div class="dashboard-widget text-center bg-info mt-4 c-pointer">
                                        <a href="javascript:;" class="d-block">
                                            <i class="fa fa-diamond"></i>
                                            <span class="d-block title">{{ number_format($merchant_today_profit, 2) }} {{__('(BHD) Today Earning')}}</span>
                                            <span class="d-block sub-title">{{__('My Profit (50%)')}}</span>
                                        </a>
                                    </div>
                                </div>

                                {{-- Total gain points --}}
                                <div class="col-md-4">
                                    <div class="dashboard-widget text-center bg-dark mt-4 c-pointer">
                                        <a href="javascript:;" class="d-block">
                                            <i class="fa fa-diamond"></i>
                                            <span class="d-block title">{{ $depositPoint }} {{__('Points(s) Gain')}}</span>
                                            <span class="d-block sub-title">{{__('My Point (40%)')}}</span>
                                        </a>
                                    </div>
                                </div>

                               {{-- Profit withdraw section --}}
                                <div class="col-md-4">
                                    <div class="dashboard-widget text-center bg-danger mt-4 c-pointer">
                                            @if ( \Carbon\Carbon::now()->diffInDays($lastwithdraw) >= 30 )
                                                @php
                                                    $lastwithdraw = $lastwithdraw->addDays(30);
                                                @endphp
                                                @if( $availbleProfit < 1)
                                                    <a href="javascript:;" onclick="swal('Sorry!', 'You don\'t have much amount for withdrew','error');" data-toggle="tooltip"  class="d-block" title="You don\'t have much amount for withdrew">
                                                        <i class="fa fa-money" ></i>
                                                        <span class="d-block title">{{__('Withdraw Your Profit')}}</span>
                                                        <span class="d-block sub-title">
                                                           {{__('Available after: ' . $lastwithdraw->format('j F Y'))}}
                                                    </span>
                                                    </a>
                                                @else
                                                    @if ( $bankinfo == null)
                                                        <a href="javascript:;" data-toggle="modal" data-target="#bankinfocreate_modal" class="d-block">
                                                            <i class="fa fa-money" ></i>
                                                            <span class="d-block title">{{__('Click For Withdraw Amount')}}</span>
                                                            <span class="d-block sub-title">
                                                                {{__($lastwithdraw->format('j F Y'))}}
                                                            </span>
                                                        </a>
                                                    @else
                                                    <a href="javascript:;" data-toggle="modal" data-target="#_withdraw" class="d-block">
                                                        <i class="fa fa-money" ></i>
                                                        <span class="d-block title">{{__('Click For Withdraw Amount')}}</span>
                                                        <span class="d-block sub-title">
                                                             {{__('Available after : ')}}{{ $lastwithdraw->format('j F Y') }}
                                                        </span>
                                                    </a>
                                                    @endif
                                                @endif
                                            @else
                                            @php
                                                $lastwithdraw = $lastwithdraw->addDays(30);
                                            @endphp
                                                <a href="javascript:;" onclick="swal('Sorry!', 'You can withdraw your profit After {{ $lastwithdraw->format('j F Y') }}', 'error');" data-toggle="tooltip"  class="d-block" title="You can withdraw your profit After {{ $lastwithdraw->format('j F Y') }} ">
                                                    <i class="fa fa-money" ></i>
                                                    <span class="d-block title">{{__('Withdraw Your Profit')}}</span>
                                                    <span class="d-block sub-title">
                                                        {{__('Available after : ')}}{{ $lastwithdraw->format('j F Y') }}
                                                    </span>
                                                </a>
                                            @endif

                                    </div>
                                </div>
                                
                                
                                
                                {{-- Point convert section --}}
                                <div class="col-md-4">
                                    <div class="dashboard-widget text-center bg-secondary mt-4 c-pointer">

                                        @if ( $depositPoint >= 10000 )

                                            <a href="{{ route('pointconvert.index')}}" class="d-block">
                                                <i class="fa fa-diamond"></i> => <i class="fa fa-money"></i>
                                                <span class="d-block title">Convert {{ floor($depositPoint).'P' }} to {{ number_format($depositPoint *(1/10000), 2).'BDH ' }}</span>
                                                <span class="d-block sub-title">{{__('Click for convert')}}</span>
                                            </a>
                                        @else
                                            <a href="javascript:;" onclick="swal('Sorry!', 'You can convert your point(s) after 10000 Points gain', 'error');" data-toggle="tooltip"  class="d-block" title="You can convert your point(s) after 10000 Points gain">
                                                <i class="fa fa-diamond"></i> => <i class="fa fa-money"></i>
                                                <span class="d-block title">Convert {{ floor($depositPoint).'P' }} to {{ number_format($depositPoint * (1/10000), 2).'BDH ' }}</span>
                                                <span class="d-block sub-title">{{__('Refer & gain points')}}</span>
                                            </a>

                                        @endif
                                    </div>
                                </div>
                            @else

                                {{-- Total gain points --}}
                                <div class="col-md-4">
                                    <div class="dashboard-widget text-center bg-primary mt-4 c-pointer">
                                        <a href="javascript:;" class="d-block">
                                            <i class="fa fa-diamond"></i>
                                            <span class="d-block title">{{ $depositPoint }} {{__('Points(s) Gain')}}</span>
                                            <span class="d-block sub-title">{{__('Buy & Gain Points')}}</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="dashboard-widget text-center bg-info mt-4 c-pointer">

                                        @if ( $depositPoint >= 10000 )

                                            <a href="{{ route('pointconvert.index')}}" class="d-block">
                                                <i class="fa fa-diamond"></i> => <i class="fa fa-money"></i>
                                                <span class="d-block title">Convert {{ floor($depositPoint).'P' }} to {{ number_format($depositPoint *(1/10000), 2).'BDH ' }}</span>
                                                <span class="d-block sub-title">{{__('Click for convert')}}</span>
                                            </a>
                                        @else
                                            <a href="javascript:;" onclick="swal('Sorry!', 'You can convert your point(s) after 10,000 Points gain', 'error');" data-toggle="tooltip"  class="d-block" title="You can convert your point(s) after 000 Points gain">
                                                <i class="fa fa-diamond"></i> => <i class="fa fa-money"></i>
                                                <span class="d-block title">Convert {{ floor($depositPoint).'P' }} to {{ number_format($depositPoint * (1/10000), 2).'BDH ' }}</span>
                                                <span class="d-block sub-title">{{__('Refer & gain points')}}</span>
                                            </a>

                                        @endif
                                    </div>
                                </div>

                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-box bg-white mt-4">
                                    <div class="form-box-title px-3 py-2 clearfix ">
                                        {{__('Saved Shipping Info')}}
                                        <div class="float-right">
                                            <a href="{{ route('profile') }}" class="btn btn-link btn-sm">{{__('Edit')}}</a>
                                        </div>
                                    </div>
                                    <div class="form-box-content p-3">
                                        <table>
                                            @if(\Illuminate\Support\Facades\Auth::user()->is_merchant == 1 )
                                                <tr>
                                                    <th>
                                                        <button   class="btn btn-primary float-right"value="copy" onclick="copyToClipboard()">Copy Share Link!</button>
                                                        {{-- {{ url('/users/registration?ref=' .\Illuminate\Support\Facades\Auth::user()->referral_code) }} --}}
                                                    </th>
                                                    <td>
                                                        <input class="form-control" type="text" id="copy_refcode" value="{{ url('/users/registration?ref=' .\Illuminate\Support\Facades\Auth::user()->referral_code) }}" readonly>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><b>{{__('Your Referral Code')}}:</b></th>
                                                    <td>
                                                        @if(Auth::user()->referral_code != null)
                                                            <b>{{ Auth::user()->referral_code }}</b>
                                                        @else
                                                            Have no referral code
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('Your listed customer')}}:</td>
                                                    @php
                                                        $customers = DB::table('users')->where('referred_by', Auth::user()->referral_code)->count();
                                                    @endphp
                                                    @if($customers != null)
                                                        <td class="p-2">{{ $customers }}</td>
                                                    @else
                                                        <td class="p-2">No Customer</td>
                                                    @endif
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>{{__('Address')}}:</td>
                                                <td class="p-2">{{ Auth::user()->address }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Country')}}:</td>
                                                <td class="p-2">
                                                    @if (Auth::user()->country != null)
                                                        {{ \App\Country::where('code', Auth::user()->country)->first()->name }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{__('City')}}:</td>
                                                <td class="p-2">{{ Auth::user()->city }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Postal Code')}}:</td>
                                                <td class="p-2">{{ Auth::user()->postal_code }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Phone')}}:</td>
                                                <td class="p-2">{{ Auth::user()->phone }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-box bg-white mt-4">
                                    <div class="form-box-title px-3 py-2 clearfix ">
                                        {{__('Purchased Package')}}
                                    </div>
                                    @php
                                        $customer_package = \App\CustomerPackage::find(Auth::user()->customer_package_id);
                                    @endphp
                                    <div class="form-box-content p-3">
                                        @if($customer_package != null)
                                            <div class="form-box-content p-2 category-widget text-center">
                                                <center><img alt="Package Logo" src="{{ asset($customer_package->logo) }}" style="height:100px; width:90px;"></center>
                                                <left> <strong><p>{{__('Product Upload')}}: {{ $customer_package->product_upload }} {{__('Times')}}</p></strong></left>
                                                <strong><p>{{__('Product Upload Remaining')}}: {{ Auth::user()->remaining_uploads }} {{__('Times')}}</p></strong>
                                                <strong><p><div class="name mb-0">{{__('Current Package')}}: {{ $customer_package->name }} <span class="ml-2"><i class="fa fa-check-circle" style="color:green"></i></span></div></p></strong>
                                            </div>
                                        @else
                                            <div class="form-box-content p-2 category-widget text-center">
                                                <center><strong><p>{{__('Package Removed')}}</p></strong></center>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>

        function copyToClipboard() {
            swal('Copied', 'Your Shareable Link', 'success');
            document.getElementById("copy_refcode").select();
            document.execCommand('copy');
        }
    </script>

    <!-- _withdraw Modal -->
    @if (!$bankinfo == null)
        @include('frontend.customer.modal._withdraw');
    @endif
    <!-- /end _withdraw Modal -->
    @include('frontend.bankinfo.modal._create')

@endsection
