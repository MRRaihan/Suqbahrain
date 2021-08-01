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
                                <div class="col-md-6 col-12">
                                    <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                        {{__('Product Return Request')}}
                                    </h2>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li class="active"><a>{{__('Product Return')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form class="" action="{{ route('purchase_return_request_store.customer') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('Request Form')}}
                                </div>
                                <div class="form-box-content p-3">

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Order Code')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" name="code" value="{{ $order->code }}" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Return Reason')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="reason" id="inlineRadio1" value="Change of mind">
                                                <label class="form-check-label" for="inlineRadio1">Change of mind</label>
                                              </div>
                                              <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="reason" id="inlineRadio2" value="Decided for alternative product">
                                                <label class="form-check-label" for="inlineRadio2">Decided for alternative product</label>
                                              </div>
                                              <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="reason" id="inlineRadio3" value="Found cheaper elsewhere">
                                                <label class="form-check-label" for="inlineRadio3">Found cheaper elsewhere</label>
                                              </div>
                                              <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="reason" id="inlineRadio3" value="Change payment method">
                                                <label class="form-check-label" for="inlineRadio3">Change payment method</label>
                                              </div>
                                              <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="reason" id="inlineRadio3" value="Change/combine order">
                                                <label class="form-check-label" for="inlineRadio3">Change/combine order</label>
                                              </div>
                                              <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="reason" id="inlineRadio3" value="Delivery time is too long">
                                                <label class="form-check-label" for="inlineRadio3">Delivery time is too long</label>
                                              </div>

                                            {{-- <textarea name="reason" class="form-control mb-3" placeholder="{{__('Enter product return reason...')}}"></textarea> --}}
                                                @error('reason')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror

                                            {{-- <input type="text" class="form-control mb-3" placeholder="{{__('Your Name')}}" name="name" value="{{ Auth::user()->name }}"> --}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Attache Image')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="file" name="image" id="file-3" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" accept="image/*" />
                                            <label for="file-3" class="mw-100 mb-3">
                                                <span></span>
                                                <strong>
                                                    <i class="fa fa-upload"></i>
                                                    {{__('Choose image')}}
                                                </strong>
                                            </label>
                                            @error('image')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-styled btn-base-1">{{__('Send')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
