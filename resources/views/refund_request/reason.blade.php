@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title text-center">{{__('Reason For Refund Request')}}</h3>
            </div>
            <div class="panel-body">

                @if( $refund->reason == null)
                    <div class="form-group">
                        <label class="col-lg-3 control-label text-center">{{__('Reason')}}</label>
                        <div class="col-lg-9">
                            <p class="bord-all pad-all">{{ __('Order cancel by seller, That\'s why customer want refund!') }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label text-center">{{__('Refund Method')}}</label>
                        <div class="col-lg-9">
                            <p class="bord-all pad-all">{{ $refund->refund_method }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label text-center">{{__('Method Details')}}</label>
                        <div class="col-lg-9">
                            <p class="bord-all pad-all">
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
                            </p>
                        </div>
                    </div>
                    @if( $refund->admin_approval == 1 && $refund->refund_status == 0 )
                        <div class="form-group">
                            <label class="col-lg-3 control-label text-center">{{__('Payment Status')}}</label>
                            <div class="col-lg-9">
                                <p class="bord-all pad-all">
                                    <a class="btn btn-primary" href="{{ route('vendor_refund_pay', $refund->id ) }}">
                                        {{ 'PAID' }} <small>After payment complete than click.</small>
                                    </a>
                                </p>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="form-group">
                        <label class="col-lg-3 control-label text-center">{{__('Reason')}}</label>
                        <div class="col-lg-9">
                            <p class="bord-all pad-all">{{ $refund->reason }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
