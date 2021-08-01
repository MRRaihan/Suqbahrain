<div class="sidebar sidebar--style-3 no-border stickyfill p-0">
    <div class="widget mb-0">
        <div class="widget-profile-box text-center p-3">
            @if (Auth::user()->avatar_original != null)
                <div class="image" style="background-image:url('{{ asset(Auth::user()->avatar_original) }}')"></div>
            @else
                <img src="{{ asset('frontend/images/user.png') }}" class="image rounded-circle">
            @endif
            <div class="name">{{ Auth::user()->name }}</div>
        </div>
        <div class="sidebar-widget-title py-3">
            <span>{{__('Menu')}}</span>
        </div>
        <div class="widget-profile-menu py-3">
            <ul class="categories categories--style-3">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ areActiveRoutesHome(['dashboard'])}}">
                        <i class="la la-dashboard"></i>
                        <span class="category-name">
                            {{__('Dashboard')}}
                        </span>
                    </a>
                </li>
                
                @php
                    $canceled_orders = DB::table('orders')
                    ->orderBy('code', 'desc')
                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                    ->where('orders.user_id', Auth::user()->id)
                    ->where('orders.customer_view', 0)
                    ->where('orders.cancel_request', 3)
                    ->select('orders.id')
                    ->distinct()
                    ->count();
                    $orders = DB::table('orders')
                    ->orderBy('code', 'desc')
                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                    ->where('orders.user_id', Auth::user()->id)
                    ->where('orders.customer_view', 0)
                    ->where('orders.cancel_request', '<', 3)
                    ->select('orders.id')
                    ->distinct()
                    ->count();
                @endphp

                @if ( $canceled_orders + $orders > 0 )
                    <li class="">
                        <a id="notific" class="" href="{{ route('dashboard') }}" onclick="myFunction()" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                            <span class="category-name">
                            {{__('Notification(s)')}}
                            <span class="ml-2 text-danger">
                                <strong>({{ __( $canceled_orders + $orders ) }})</strong>
                            </span>
                        </span>
                        </a>
                        <script type="text/javascript">
                            function myFunction(e) {
                                var element = document.getElementById("notific");
                                element.classList.add("active");
                            }
                        </script>
                        <div class="dropdown-menu dropdown-menu-right" style="border-left: 3px solid #1abc9c">
                            @if ($orders > 0)
                                <a class="dropdown-item" href="{{ route('purchase_history.index') }}">New Order(s) <span class="ml-2 text-success">
                            <strong>({{ __($orders) }})</strong>
                        </span></a>
                            @endif

                            @if ( $canceled_orders > 0 )
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('purchase_history.index') }}">Canceled Order(s) <span class="ml-2 text-danger">
                            <strong>({{ __($canceled_orders) }})</strong>
                        </span></a>
                            @endif
                        </div>
                    </li>
                @endif
                

                @if(\App\BusinessSetting::where('type', 'classified_product')->first()->value == 1)
                <li>
                    <a href="{{ route('customer_products.index') }}" class="{{ areActiveRoutesHome(['customer_products.index', 'customer_products.create', 'customer_products.edit'])}}">
                        <i class="la la-diamond"></i>
                        <span class="category-name">
                            {{__('Classified Products')}}
                        </span>
                    </a>
                </li>
                @endif
                @php
                $delivery_viewed = App\Order::where('user_id', Auth::user()->id)->where('delivery_viewed', 0)->get()->count();
                $payment_status_viewed = App\Order::where('user_id', Auth::user()->id)->where('payment_status_viewed', 0)->get()->count();
               
                @endphp
                <li>
                    <a href="{{ route('purchase_history.index') }}" class="{{ areActiveRoutesHome(['purchase_history.index'])}}">
                        <i class="la la-file-text"></i>
                        <span class="category-name">
                            {{__('Purchase History')}}
                            @if($delivery_viewed > 0 || $payment_status_viewed > 0)
                                <span class="ml-2" style="color:green">
                                    <strong>({{ __('New') }})</strong>
                                </span>
                            @endif
                       </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('digital_purchase_history.index') }}" class="{{ areActiveRoutesHome(['digital_purchase_history.index'])}}">
                        <i class="la la-download"></i>
                        <span class="category-name">
                            {{__('Downloads')}}
                        </span>
                    </a>
                </li>


                @php
                    $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
                    $club_point_addon = \App\Addon::where('unique_identifier', 'club_point')->first();
                @endphp
                
                
                @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                    <li>
                        <a href="{{ route('customer_refund_request') }}" class="{{ areActiveRoutesHome(['customer_refund_request'])}}">
                            <i class="la la-file-text"></i>
                            <span class="category-name">
                                {{__('Sent Refund Request')}}
                            </span>
                        </a>
                    </li>
                @endif

                <li>
                    <a href="{{ route('wishlists.index') }}" class="{{ areActiveRoutesHome(['wishlists.index'])}}">
                        <i class="la la-heart-o"></i>
                        <span class="category-name">
                            {{__('Wishlist')}}
                        </span>
                    </a>
                </li>
                @if (\App\BusinessSetting::where('type', 'conversation_system')->first()->value == 1)
                    @php
                        $conversation = \App\Conversation::where('sender_id', Auth::user()->id)->where('sender_viewed', 0)->get();
                    @endphp
                    <li>
                        <a href="{{ route('conversations.index') }}" class="{{ areActiveRoutesHome(['conversations.index', 'conversations.show'])}}">
                            <i class="la la-comment"></i>
                            <span class="category-name">
                                {{__('Conversations')}}
                                @if (count($conversation) > 0)
                                    <span class="ml-2" style="color:green"><strong>({{ count($conversation) }})</strong></span>
                                @endif
                            </span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('profile') }}" class="{{ areActiveRoutesHome(['profile'])}}">
                        <i class="la la-user"></i>
                        <span class="category-name">
                            {{__('Manage Profile')}}
                        </span>
                    </a>
                </li>
                @if (\App\BusinessSetting::where('type', 'wallet_system')->first()->value == 1)
                    <li>
                        <a href="{{ route('wallet.index') }}" class="{{ areActiveRoutesHome(['wallet.index'])}}">
                            <i class="la la-dollar"></i>
                            <span class="category-name">
                                {{__('My Wallet')}}
                            </span>
                        </a>
                    </li>
                @endif

                @if ($club_point_addon != null && $club_point_addon->activated == 1)
                    <li>
                        <a href="{{ route('earnng_point_for_user') }}" class="{{ areActiveRoutesHome(['earnng_point_for_user'])}}">
                            <i class="la la-dollar"></i>
                            <span class="category-name">
                                {{__('Earning Points')}}
                            </span>
                        </a>
                    </li>
                @endif

                @if (\App\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated && Auth::user()->affiliate_user != null && Auth::user()->affiliate_user->status)
                    <li>
                        <a href="{{ route('affiliate.user.index') }}" class="{{ areActiveRoutesHome(['affiliate.user.index', 'affiliate.payment_settings'])}}">
                            <i class="la la-dollar"></i>
                            <span class="category-name">
                                {{__('Affiliate System')}}
                            </span>
                        </a>
                    </li>
                @endif
                @php
                    $support_ticket = DB::table('tickets')
                                ->where('client_viewed', 0)
                                ->where('user_id', Auth::user()->id)
                                ->count();
                @endphp
                <li>
                    <a href="{{ route('support_ticket.index') }}" class="{{ areActiveRoutesHome(['support_ticket.index'])}}">
                        <i class="la la-support"></i>
                        <span class="category-name">
                            {{__('Support Ticket')}} @if($support_ticket > 0)<span class="ml-2" style="color:green"><strong>({{ $support_ticket }} {{ __('New') }})</strong></span></span>@endif
                        </span>
                    </a>
                </li>
                
                 @if(\Illuminate\Support\Facades\Auth::user()->is_merchant == 1 )
                    <li>
                        <a href="{{ route('withdraw_amount.index') }}" class="{{ areActiveRoutesHome(['withdraw_amount.index'])}}">
                            <i class="nav-icon fa fa-money"></i>
                            <span class="category-name">
                                {{__('Withdraw Amount')}}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('bankinfo.index') }}" class="{{ areActiveRoutesHome(['bankinfo.index'])}}">
                            <i class="nav-icon fa fa-university"></i>
                            <span class="category-name">
                                {{__('Bank Information')}}
                            </span>
                        </a>
                    </li>
                @endif
                
                @if(\Illuminate\Support\Facades\Auth::user()->user_type == 'customer' )
                    <li>
                        <a href="{{ route('faqs.index') }}" class="{{ areActiveRoutesHome(['faqs.index'])}}">
                            <i class="nav-icon fa fa-question-circle"></i>
                            <span class="category-name">
                                {{__('FAQS')}}
                            </span>
                        </a>
                    </li>
                @endif
                
            </ul>
        </div>
        <!--@if (\App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
            <div class="widget-seller-btn pt-4">
                <a href="{{ route('shops.create') }}" class="btn btn-anim-primary w-100">{{__('Be A Seller')}}</a>
            </div>
        @endif-->
    </div>
</div>
