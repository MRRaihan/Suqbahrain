@extends('frontend.layouts.app')

@section('content')

@php
    $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
@endphp

    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @include('frontend.inc.seller_side_nav')
                </div>

                <div class="col-lg-9">
                    <div class="main-content">
                        <!-- Page title -->
                        <div class="page-title">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                        {{__('Orders')}}
                                    </h2>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li class="active"><a href="{{ route('orders.index') }}">{{__('Orders')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (count($orders) > 0)
                            <!-- Order history table -->
                            <div class="card no-border mt-4">
                                <div>
                                    <table class="table table-striped res-table mar-no" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{__('Order Code')}}</th>
                                                <th>{{__('Num. of Products')}}</th>
                                                <th>{{__('Customer')}}</th>
                                                <th>{{__('Amount')}}</th>
                                                <th>{{__('Return')}}</th>
                                                <th>{{__('Reason')}}</th>
                                                <th>{{__('Image')}}</th>
                                                @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                                                    <th>{{__('Refund')}}</th>
                                                @endif
                                                <th width="10%">{{__('Action')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $key => $order_id)
                                                @php
                                                    $order = \App\Order::find($order_id->id);
                                                @endphp
                                                @if($order != null)
                                                    <tr>
                                                        <td>
                                                            <a href="#{{ $order->code }}" onclick="show_purchase_history_details({{ $order->id }})">{{ $order->code }}
                                                            @if($order->seller_viewed == 0)
                                                            <span class="pull-right badge badge-danger">{{ __('New') }}</span>
                                                            @endif
                                                            </a>
                                                        </td>
                                                        <td>
                                                        </td>
                                                        <td>
                                                            {{ count($order->orderDetails->where('seller_id', $admin_user_id)) }}
                                                        </td>
                                                        <td>
                                                            @if ($order->user_id != null)
                                                                 {{ $order->user->name ?? 'No data available' }}
                                                            @else
                                                                Guest ({{ $order->guest_id }})
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ single_price($order->orderDetails->where('seller_id', $admin_user_id)->sum('price') + $order->orderDetails->where('seller_id', $admin_user_id)->sum('tax')) }}
                                                        </td>

                                                        <td>
                                                            @if ( $order->return_request == 1 )
                                                                <span class="badge badge-danger badge--2 mr-4 text-danger">{{__('Pending')}}</span>
                                                            @elseif($order->return_request == 3)
                                                                <span class="badge badge-danger badge--2 mr-4 text-green">{{__('Success')}}</span>
                                                            @endif

                                                        </td>
                                                        <td>
                                                            {{ $order->return->reason }}
                                                        </td>
                                                        <td>
                                                            <img src="{{ asset($order->return->image) ?? '-'}}" alt="" style='width:50%'>
                                                        </td>
                                                        @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                                                            <td>
                                                                @if (count($order->refund_requests) > 0)
                                                                    {{ count($order->refund_requests) }} Refund
                                                                @else
                                                                    No Refund
                                                                @endif
                                                            </td>
                                                        @endif
                                                        <td>
                                                            @if ( $order->return_request == 1 )
                                                                <a class="btn btn-primary" href="{{ route('return_list_seller_update', $order->id) }}">{{__('Accept Return')}}</a>
                                                            @else
                                                             {{__('Done')}}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <div class="pagination-wrapper py-4">
                            <ul class="pagination justify-content-end">
                                {{-- {{ $orders->links() }} --}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="order_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="c-preloader">
                    <i class="fa fa-spin fa-spinner"></i>
                </div>
                <div id="order-details-modal-body">

                </div>
            </div>
        </div>
    </div>

@endsection
