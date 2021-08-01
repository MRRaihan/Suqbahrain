@extends('frontend.layouts.app')

@section('content')

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
                                        {{__('Refund Request Request')}}
                                    </h2>
                                </div>
                            </div>
                        </div>

                        <form class="" method="POST" enctype="multipart/form-data" id="choice_form">
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('Reason')}}
                                </div>
                                @if( $refund->reason == null)
                                    <div class="form-box-content p-3">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>{{__('Reason')}} <span class="required-star">*</span></label>
                                            </div>
                                            <div class="col-md-10">
                                                {{ __('Order cancel by seller, That\'s why customer want refund!') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-box-content p-3">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>{{__('Refund Method')}} <span class="required-star">*</span></label>
                                            </div>
                                            <div class="col-md-10">
                                                {{ $refund->refund_method }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-box-content p-3">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>{{__('Method Details')}} <span class="required-star">*</span></label>
                                            </div>
                                            <div class="col-md-10">
                                                @if ( $refund->refund_method == 'Bank Account' )
                                                    @php
                                                        $ac = json_decode($refund->method_details, true);
                                                    @endphp
                                                    @foreach($ac as $key => $val)
                                                        @if ( $key != '_token' && $key != 'name' && $key != 'code' &&$key != 'refund_method' )
                                                        {{ strtoupper($key) . ' : ' . strtoupper($val) }}
                                                        <br>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {{ $refund->method_details }}
                                                @endif
                                                {{-- {{ $refund->method_details }} --}}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-box-content p-3">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>{{__('Refund Reason')}} <span class="required-star">*</span></label>
                                            </div>
                                            <div class="col-md-10">
                                                {{ $refund->reason }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                {{-- @if($refund->seller_approval == 1 && $refund->refund_status == 0 )
                                    <div class="form-box-content p-3">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>{{__('After compleate refund payment, than click paid')}}</label>
                                            </div>
                                            <div class="col-md-10">
                                                <a class="btn btn-primary" href="{{ route('vendor_refund_pay', $refund->id ) }}">
                                                    {{ 'PAID' }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif --}}
                                @if( $refund->refund_status == 1 )
                                    <div class="form-box-content p-3">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>{{__('Status')}}</label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="col-md-10 text-success">
                                                    {{ __('Paid') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
