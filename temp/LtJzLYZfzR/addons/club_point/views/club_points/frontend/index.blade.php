@extends('frontend.layouts.app')

@section('content')
    @php
        $club_point_convert_rate = \App\BusinessSetting::where('type', 'club_point_convert_rate')->first()->value;
    @endphp
    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @if(Auth::user()->user_type == 'seller')
                        @include('frontend.inc.seller_side_nav')
                    @elseif(Auth::user()->user_type == 'customer')
                        @include('frontend.inc.customer_side_nav')
                    @endif
                </div>

                <div class="col-lg-9">
                    <div class="main-content">
                        <!-- Page title -->
                        <div class="page-title">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12 d-flex align-items-center">
                                    <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                        {{__('My Points')}}
                                    </h2>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li class="active"><a href="{{ route('earnng_point_for_user') }}">{{__('My Points')}}</a></li>
                                        </ul>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <div class="dashboard-widget text-center green-widget text-white mt-4 c-pointer">
                                    <span class="d-block title heading-3 strong-400 mb-3">{{ $club_point_convert_rate }} {{ __(' Points') }} = {{ single_price(1) }} {{ __('Wallet Money') }}</span>
                                    <span class="d-block sub-title">{{ __('Exchange Rate') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card no-border mt-2">
                            <div class="card-header py-3">
                                <h4 class="mb-0 h6">{{__('Point Earning history')}}</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-responsive-md mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{__('Points')}}</th>
                                            <th>{{__('Converted')}}</th>
                                            <th>{{__('Action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($club_points) > 0)
                                            @foreach ($club_points as $key => $club_point)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($club_point->created_at)) }}</td>
                                                    <td>{{ $club_point->points }} {{ __(' pts') }}</td>
                                                    <td>
                                                        @if ($club_point->convert_status == 1)
                                                            <span class="ml-2" style="color:green"><strong>{{ __('Yes') }}</strong></span>
                                                        @else
                                                            <span class="ml-2" style="color:indigo"><strong>{{ __('No') }}</strong></span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($club_point->convert_status == 0)
                                                            <button onclick="convert_point({{ $club_point->id }})" class="btn btn-sm btn-styled btn-base-1">{{__('Convert Now')}}</button>
                                                        @else
                                                            <span class="ml-2" style="color:green"><strong>{{ __('Done') }}</strong></span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="text-center pt-5 h4" colspan="100%">
                                                    <i class="la la-meh-o d-block heading-1 alpha-5"></i>
                                                <span class="d-block">{{ __('No history found.') }}</span>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="pagination-wrapper py-4">
                            <ul class="pagination justify-content-end">
                                {{ $club_points->links() }}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('script')
    <script type="text/javascript">
        function convert_point(el)
        {
            $.post('{{ route('convert_point_into_wallet') }}',{_token:'{{ csrf_token() }}', el:el}, function(data){
                if (data == 1) {
                    location.reload();
                    showFrontendAlert('success', 'Convert has been done successfully Check your Wallets');
                }
                else {
                    showFrontendAlert('danger', 'Something went wrong');
                }
    		});
        }
    </script>
@endsection
