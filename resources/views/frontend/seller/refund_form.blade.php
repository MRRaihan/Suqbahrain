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
                                        {{__('Send Refund Request')}}
                                    </h2>
                                </div>
                            </div>
                        </div>

                        <form class="" action="{{route('refund_send_customer.customer', $order_detail)}}" method="POST" enctype="multipart/form-data" id="choice_form">
                            @csrf
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Product Name')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" name="name" placeholder="{{__('Product Name')}}" value="{{ $order_detail->product->name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Product Price')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="number" class="form-control mb-3" name="name" placeholder="{{__('Product Price')}}" value="{{ $order_detail->product->unit_price }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Order Code')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" name="code" value="{{ $order_detail->order->code }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Refund Method')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <select class="form-control mb-3" name="refund_method" id="refund_method">
                                                <option>Wallet</option>
                                                <option>Cash on Hand</option>
                                                <option>Benifit Pay</option>
                                                <option>Paypal</option>
                                                <option>Bank Account</option>
                                                <option>Pocket</option>
                                            </select>
                                            <div id="method_details"></div>
                                        </div>
                                    </div>
                                    {{-- <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Method Details')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <textarea name="method_details" rows="8" placeholder="If available" class="form-control mb-3"></textarea>
                                            @if ($errors->has('method_details'))
                                                <span class="text-danger">{{ $errors->first('method_details') }}</span>
                                            @endif
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="form-box mt-4 text-right">
                                <button type="submit" class="btn btn-styled btn-base-1">{{ __('Send Request') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $("select#refund_method").on("change", function () {
            var method = $("#refund_method").val();

            var label = "<label>Age of children: </label>";

            var cash = '<div class="form-group"> <label for="email">Your Address</label> <textarea name="email" class="form-control" id="" value="{{ old("email") }}"></textarea> @error("email") <div class="text-danger">{{ $message }}</div> @enderror </div>';

            var benifit = '<div class="form-group"> <label for="email">Benifit Pay Email</label> <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email" value="{{ old("email") }}">  @error("email") <div class="text-danger">{{ $message }}</div> @enderror </div>';

            var paypal = '<div class="form-group"> <label for="email">Paypal Email</label> <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email" value="{{ old("email") }}">  @error("email") <div class="text-danger">{{ $message }}</div> @enderror </div>';

            var pocket = '<div class="form-group"> <label for="email">Pocket account no</label> <input type="text" name="email" class="form-control" id="email" placeholder="Account no"  value="{{ old("email") }}">  @error("email") <div class="text-danger">{{ $message }}</div> @enderror </div>';
 
            var bankac = '<div class="form-group"> <label for="exampleInputEmail1">A/C Holder Name</label> <input type="text" name="ac_holder" class="form-control" id="ac_holder" placeholder="Enter A/C holer name" value="{{ old("ac_holder") }}"> @error("ac_holder") <div class="text-danger">{{ $message }}</div> @enderror </div> <div class="form-group"> <label for="exampleInputEmail1">A/C Number</label> <input type="text" name="ac_no" class="form-control" id="ac_no" placeholder="Enter A/C Number" value="{{ old("ac_no") }}"> @error("ac_no") <div class="text-danger">{{ $message }}</div> @enderror </div> <div class="form-group"> <label for="exampleInputEmail1">IBAN Number</label> <input type="text" name="iban_number" class="form-control" id="iban_number" placeholder="Enter IBAN Number" value="{{ old("iban_number") }}"> @error("iban_number") <div class="text-danger">{{ $message }}</div> @enderror </div> <div class="form-group"> <label for="exampleInputEmail1">Bank Name</label> <input type="text" name="bank_name" class="form-control" id="bank_name" placeholder="Enter Bank Name" value="{{ old("bank_name") }}"> @error("bank_name") <div class="text-danger">{{ $message }}</div> @enderror </div> <div class="form-group"> <label for="exampleInputEmail1">Bank Address (Optional)</label> <input type="text" name="address" class="form-control" id="address" placeholder="Enter Bank Address" value="{{ old("address") }}"> @error("address") <div class="text-danger">{{ $message }}</div> @enderror </div> <div class="form-group"> <label for="exampleInputEmail1">Bank Routing No. (Optional)</label> <input type="text" name="routing_no" class="form-control" id="routing_no" placeholder="Enter Bank Routing Number" value="{{ old("routing_no") }}"> @error("routing_no") <div class="text-danger">{{ $message }}</div> @enderror </div>';

            var html = '';

            $("#method_details").html('');
            // html += label;
            // html += method;
            // for (i = 0; i < number; i++) {
            //     html += newDropList
            // };
            if( method == 'Bank Account'){
                html += bankac;
            }
            if( method == 'Cash on Hand'){
                html += cash;
            }
            if( method == 'Benifit Pay'){
                html += benifit;
            }
            if( method == 'Paypal'){
                html += paypal;
            }
            
             if( method == 'Pocket'){
                html += pocket;
            }

            $("#method_details").html(html);
        });
    </script>



@endsection
