<div class="panel-body card-body">
    <div class="pos-cart c-scrollbar c-scrollbar-light">
        <table class="table table-bordered mb-0 mar-no" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="60%">{{__('Product')}}</th>
                    <th width="10%">{{__('QTY')}}</th>
                    <th>{{__('Price')}}</th>
                    <th>{{__('Subtotal')}}</th>
                    <th class="text-right">{{__('Remove')}}</th>
                </tr>
            </thead>
            <tbody>
                @if (Session::has('posCart'))
                    @php
                        $subtotal = 0;
                        $tax = 0;
                        $shipping = 0;
                    @endphp
                    @forelse (Session::get('posCart') as $key => $cartItem)
                        @php
                            $subtotal += $cartItem['price']*$cartItem['quantity'];
                            $tax += $cartItem['tax']*$cartItem['quantity'];
                            $shipping += $cartItem['shipping']*$cartItem['quantity'];
                            if(Session::get('shipping', 0) == 0){
                                $shipping = 0;
                            }
                        @endphp
                        <tr>
                            <td>
                                <span class="media">
                                    <div class="media-left">
                                        <img class="mr-3 mar-rgt" height="60" src="{{ asset(\App\Product::find($cartItem['id'])->thumbnail_img) }}" >
                                    </div>
                                    <div class="media-body">
                                        {{ \App\Product::find($cartItem['id'])->name }} ({{ $cartItem['variant'] }})
                                    </div>
                                </span>
                            </td>
                            <td>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control text-center" placeholder="1" id="qty-{{ $key }}" value="{{ $cartItem['quantity'] }}" onchange="updateQuantity({{ $key }})" min="1">
                                </div>
                            </td>
                            <td>{{ single_price($cartItem['price']) }}</td>
                            <td>{{ single_price($cartItem['price']*$cartItem['quantity']) }}</td>
                            <td class="text-right">
                                <button class="btn btn-circle btn-danger btn-xs" type="button" onclick="removeFromCart({{ $key }})">
                                    <i class="fa fa-close"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                <img src="{{ asset('img/nothing-found.jpg') }}" class="img-fit" height="150">
                                <p>No Product Added</p>
                            </td>
                        </tr>
                    @endforelse
                @endif
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer bord-top">
    <table class="table mar-no" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="text-center">{{__('Sub Total')}}</th>
                <th class="text-center">{{__('Total Tax')}}</th>
                <th class="text-center">{{__('Total Shipping')}}</th>
                <th class="text-center">{{__('Discount')}}</th>
                <th class="text-center">{{__('Total')}}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">{{ single_price($subtotal) }}</td>
                <td class="text-center">{{ single_price($tax) }}</td>
                <td class="text-center">{{ single_price($shipping) }}</td>
                <td class="text-center">{{ single_price(Session::get('pos_discount', 0)) }}</td>
                <td class="text-center">{{ single_price($subtotal+$tax+$shipping - Session::get('pos_discount', 0)) }}</td>
            </tr>
        </tbody>
    </table>
</div>
