<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\OTPVerificationController;
use App\Http\Controllers\ClubPointController;
use App\Http\Controllers\AffiliateController;
use App\Order;
use App\Product;
use App\Color;
use App\OrderDetail;
use App\CouponUsage;
use App\OtpConfiguration;
use App\User;
use App\BusinessSetting;
use Auth;
use Session;
use DB;
use PDF;
use Mail;
use App\Mail\InvoiceEmailManager;
use CoreComponentRepository;
use App\Deposit;
use App\ClubPointSetting;
use App\Wallet;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource to seller.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = DB::table('orders')
                    ->orderBy('code', 'desc')
                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                    ->where('order_details.seller_id', Auth::user()->id)
                    ->select('orders.id')
                    ->distinct()
                    ->paginate(15);

/*      foreach ($orders as $key => $value) {
            $order = \App\Order::find($value->id);
            $order->viewed = 1;
            $order->save();
        }*/

        return view('frontend.seller.orders', compact('orders'));
    }

    /**
     * Display a listing of the resource to admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_orders(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();

        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $admin_user_id = User::where('user_type', 'admin')->first()->id;
        // $orders = DB::table('orders')
        //             ->orderBy('code', 'desc')
        //             ->where('orders.cancel_request', 0)
        //             ->join('order_details', 'orders.id', '=', 'order_details.order_id')
        //             ->where('order_details.seller_id', $admin_user_id)
        //             ->select('orders.id')
        //             ->distinct();

        $orders = DB::table('orders')
                    ->orderBy('code', 'desc')
                    ->where('orders.cancel_request', 0)
                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                    ->where('order_details.seller_id', $admin_user_id)
                    ->select('orders.id')
                    ->distinct();

        if ($request->payment_type != null){
            $orders = $orders->where('order_details.payment_status', $request->payment_type);
            $payment_status = $request->payment_type;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('order_details.delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')){
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%'.$sort_search.'%');
        }
        $orders = $orders->paginate(15);
        return view('orders.index', compact('orders','payment_status','delivery_status', 'sort_search', 'admin_user_id'));
    }

    public function admin_sellers_orders(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();

        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $admin_user_id = User::where('user_type', 'seller')->first()->id;
        $orders = DB::table('orders')
            ->orderBy('code', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('users','users.id','=','order_details.seller_id')
            ->Where('users.user_type', 'seller')
            ->select('orders.id')
            ->distinct();

        if ($request->payment_type != null){
            $orders = $orders->where('order_details.payment_status', $request->payment_type);
            $payment_status = $request->payment_type;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('order_details.delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')){
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%'.$sort_search.'%');
        }
        $orders = $orders->paginate(15);
        return view('orders.seller_orders', compact('orders','payment_status','delivery_status', 'sort_search', 'admin_user_id'));
    }
    
    /**
     * Display a listing of the sales to admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function sales(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();

        $sort_search = null;
        $orders = Order::orderBy('code', 'desc');
        if ($request->has('search')){
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%'.$sort_search.'%');
        }
        $orders = $orders->paginate(15);
        return view('sales.index', compact('orders', 'sort_search'));
    }


    public function order_index(Request $request)
    {
        if (Auth::user()->user_type == 'staff') {
            //$orders = Order::where('pickup_point_id', Auth::user()->staff->pick_up_point->id)->get();
            $orders = DB::table('orders')
                        ->orderBy('code', 'desc')
                        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                        ->where('order_details.pickup_point_id', Auth::user()->staff->pick_up_point->id)
                        ->select('orders.id')
                        ->distinct()
                        ->paginate(15);

            return view('pickup_point.orders.index', compact('orders'));
        }
        else{
            //$orders = Order::where('shipping_type', 'Pick-up Point')->get();
            $orders = DB::table('orders')
                        ->orderBy('code', 'desc')
                        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                        ->where('order_details.shipping_type', 'pickup_point')
                        ->select('orders.id')
                        ->distinct()
                        ->paginate(15);

            return view('pickup_point.orders.index', compact('orders'));
        }
    }

    public function pickup_point_order_sales_show($id)
    {
        if (Auth::user()->user_type == 'staff') {
            $order = Order::findOrFail(decrypt($id));
            return view('pickup_point.orders.show', compact('order'));
        }
        else{
            $order = Order::findOrFail(decrypt($id));
            return view('pickup_point.orders.show', compact('order'));
        }
    }

    /**
     * Display a single sale to admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function sales_show($id)
    {
        $order = Order::findOrFail(decrypt($id));
        return view('sales.show', compact('order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
       {

        $order = new Order;
        if(Auth::check()){
            $order->user_id = Auth::user()->id;
        }
        else{
            $order->guest_id = mt_rand(100000, 999999);
        }

        $order->shipping_address = json_encode($request->session()->get('shipping_info'));

        // if (Session::get('delivery_info')['shipping_type'] == 'Home Delivery') {
        //     $order->shipping_type = Session::get('delivery_info')['shipping_type'];
        // }
        // elseif (Session::get('delivery_info')['shipping_type'] == 'Pick-up Point') {
        //     $order->shipping_type = Session::get('delivery_info')['shipping_type'];
        //     $order->pickup_point_id = Session::get('delivery_info')['pickup_point_id'];
        // }

        $order->payment_type = $request->payment_option;
        $order->delivery_viewed = '0';
        $order->payment_status_viewed = '0';
        $order->code = date('Ymd-His').rand(10,99);
        $order->date = strtotime('now');

        if($order->save()){
            $subtotal = 0;
            $tax = 0;
            $shipping = 0;
            foreach (Session::get('cart') as $key => $cartItem){
                $product = Product::find($cartItem['id']);

                $subtotal += $cartItem['price']*$cartItem['quantity'];
                $tax += $cartItem['tax']*$cartItem['quantity'];

                if ($cartItem['shipping_type'] == 'home_delivery') {
                    $shipping += \App\Product::find($cartItem['id'])->shipping_cost*$cartItem['quantity'];
                }

                $product_variation = $cartItem['variant'];

                if($product_variation != null){
                    $product_stock = $product->stocks->where('variant', $product_variation)->first();
                    $product_stock->qty -= $cartItem['quantity'];
                    $product_stock->save();
                }
                else {
                    $product->current_stock -= $cartItem['quantity'];
                    $product->save();
                }
                $price = $cartItem['price'] * $cartItem['quantity'];
                $category = Category::find($product->category_id);
                $profit = $price * ($category->commision_rate/100);

                $order_detail = new OrderDetail;
                $order_detail->order_id  =$order->id;
                $order_detail->seller_id = $product->user_id;
                $order_detail->product_id = $product->id;
                $order_detail->variation = $product_variation;
                $order_detail->price = $price;
                $order_detail->tax = $cartItem['tax'] * $cartItem['quantity'];
                $order_detail->shipping_type = $cartItem['shipping_type'];
                $order_detail->product_referral_code = $cartItem['product_referral_code'];
                $order_detail->category_id = $product->category_id;
                $order_detail->profit = $profit;

                $pointsetting = ClubPointSetting::orderBy('id', 'DESC')->first();
                if($pointsetting == null){
                    $order_detail->club_point = $price * 10;
                } else{
                    $order_detail->club_point = $price * $pointsetting->point_per_doller;
                }

                $order_detail->user_id  =$order->user_id;

                if ($cartItem['shipping_type'] == 'home_delivery') {
                    $order_detail->shipping_cost = \App\Product::find($cartItem['id'])->shipping_cost*$cartItem['quantity'];
                }
                else{
                    $order_detail->shipping_cost = 0;
                    $order_detail->pickup_point_id = $cartItem['pickup_point'];
                }

                $order_detail->quantity = $cartItem['quantity'];
                $order_detail->save();

                $product->num_of_sale++;
                $product->save();






                //after product buy Distribute club point into customer, distributor, marchant.


                // $order_detail = OrderDetail::find($request->order_detail_id);
                // return Carbon::now()->diffInDays($order_detail->created_at);

                if($order_detail->user->user_type == 'customer' && $order_detail->user->is_merchant == 0){
                    //Merchant
                    $refMerchantCode = $order_detail->user->referred_by;
                    $merchant = User::where( 'referral_code', $refMerchantCode)->first();
                    //Distributor
                    $refDistributorCode = $merchant->referred_by;
                    $Distributor = User::where( 'referral_code', $refDistributorCode)->first();

                    $culb_point = $order_detail->club_point;

                    if($pointsetting != null){
                        //Customer Club Point 50%
                        $deposit1 = new Deposit();
                        $deposit1->user_id = $order_detail->user_id;
                        $deposit1->product_id = $order_detail->product_id;
                        $deposit1->order_id = $order_detail->order_id;
                        $deposit1->deposit_club_point = ($culb_point * $pointsetting->customer_point) / 100;
                        $deposit1->save();

                        //Merchant Club Point 40%
                        $deposit2 = new Deposit();
                        $deposit2->user_id = $merchant->id;
                        $deposit2->product_id = $order_detail->product_id;
                        $deposit2->order_id = $order_detail->order_id;
                        $deposit2->deposit_club_point = ($culb_point * $pointsetting->marchant_point) / 100;
                        $deposit2->save();

                        //Distributor Club Point 2.5%
                        $deposit3 = new Deposit();
                        $deposit3->user_id = $Distributor->id;
                        $deposit3->product_id = $order_detail->product_id;
                        $deposit3->order_id = $order_detail->order_id;
                        $deposit3->deposit_club_point = ($culb_point * $pointsetting->distributor_point) / 100;
                        $deposit3->save();
                    } else {
                        //Customer Club Point 50%
                        $deposit1 = new Deposit();
                        $deposit1->user_id = $order_detail->user_id;
                        $deposit1->product_id = $order_detail->product_id;
                        $deposit1->order_id = $order_detail->order_id;
                        $deposit1->deposit_club_point = ($culb_point * 50) / 100;
                        $deposit1->save();

                        //Merchant Club Point 40%
                        $deposit2 = new Deposit();
                        $deposit2->user_id = $merchant->id;
                        $deposit2->product_id = $order_detail->product_id;
                        $deposit2->order_id = $order_detail->order_id;
                        $deposit2->deposit_club_point = ($culb_point * 40) / 100;
                        $deposit2->save();

                        //Distributor Club Point 2.5%
                        $deposit3 = new Deposit();
                        $deposit3->user_id = $Distributor->id;
                        $deposit3->product_id = $order_detail->product_id;
                        $deposit3->order_id = $order_detail->order_id;
                        $deposit3->deposit_club_point = ($culb_point * 10) / 100;
                        $deposit3->save();
                    }
                }
            }

            $order->grand_total = $subtotal + $tax + $shipping;

            if(Session::has('coupon_discount')){
                $order->grand_total -= Session::get('coupon_discount');
                $order->coupon_discount = Session::get('coupon_discount');

                $coupon_usage = new CouponUsage;
                $coupon_usage->user_id = Auth::user()->id;
                $coupon_usage->coupon_id = Session::get('coupon_id');
                $coupon_usage->save();
            }

            $order->save();

            //stores the pdf for invoice
            $pdf = PDF::setOptions([
                            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
                            'logOutputFile' => storage_path('logs/log.htm'),
                            'tempDir' => storage_path('logs/')
                        ])->loadView('invoices.customer_invoice', compact('order'));
            $output = $pdf->output();

            file_put_contents('public/invoices/'.'Order#'.$order->code.'.pdf', $output);

            $array['view'] = 'emails.invoice';
            $array['subject'] = 'Order Placed - '.$order->code;
            $array['from'] = env('MAIL_USERNAME');
            $array['content'] = 'Hi. A new order has been placed. Please check the attached invoice.';
            $array['file'] = 'public/invoices/Order#'.$order->code.'.pdf';
            $array['file_name'] = 'Order#'.$order->code.'.pdf';

            $admin_products = array();
            $seller_products = array();
            foreach ($order->orderDetails as $key => $orderDetail){
                if($orderDetail->product->added_by == 'admin'){
                    array_push($admin_products, $orderDetail->product->id);
                }
                else{
                    $product_ids = array();
                    if(array_key_exists($orderDetail->product->user_id, $seller_products)){
                        $product_ids = $seller_products[$orderDetail->product->user_id];
                    }
                    array_push($product_ids, $orderDetail->product->id);
                    $seller_products[$orderDetail->product->user_id] = $product_ids;
                }
            }

            // seller mail Off change by Minar

           /* foreach($seller_products as $key => $seller_product){
                try {
                    Mail::to(\App\User::find($key)->email)->queue(new InvoiceEmailManager($array));
                } catch (\Exception $e) {

                }
            }*/

            if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_order')->first()->value){
                try {
                    $otpController = new OTPVerificationController;
                    $otpController->send_order_code($order);
                } catch (\Exception $e) {

                }
            }

            //sends email to customer with the invoice pdf attached
            if(env('MAIL_USERNAME') != null){
                try {
                    // shipping address user mail Off change by Minar

                   /* Mail::to($request->session()->get('shipping_info')['email'])->queue(new InvoiceEmailManager($array));*/
                    Mail::to(User::where('user_type', 'admin')->first()->email)->queue(new InvoiceEmailManager($array));
                } catch (\Exception $e) {

                }
            }
            unlink($array['file']);

            $request->session()->put('order_id', $order->id);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function order_cancel($id)
    {
        $order = Order::find($id);
        $order->cancel_request = 3;
        $order->viewed = 0;
        $order->customer_view = 0;
        $order->seller_viewed = 0;
        $order->save();

        if($order->payment_status == 'paid'){
            // if( $order->grand_total < Auth::user()->balance ){
                // $user = Auth::user();
                // $user->balance = $user->balance - $order->grand_total;
                // $user->save();
                // }
                $wallet = new Wallet;
                $wallet->user_id = $order->user_id;
                $wallet->amount = $order->grand_total;
                $wallet->payment_method = 'Refund';
                $wallet->payment_details = 'Order cancel Money Refund';
                $wallet->save();

                $user = User::findOrFail($order->user_id);
                $user->balance += $order->grand_total;
                $user->save();

                }

        if( $order->user->user_type == 'customer' && $order->user->is_merchant == 0 ){

            $deposits = Deposit::where('order_id', $id)->get();
            if( $deposits != null ){
                foreach($deposits as $key => $deposit){
                    $deposit->delete();
                }
            }
        }
        flash('Order has been Canceled successfully')->success();
        return redirect()->back();



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail(decrypt($id));
        $order->viewed = 1;
        $order->save();
        return view('orders.show', compact('order'));
    }

   public function seller_orders_show($id)
    {
        $order = Order::findOrFail(decrypt($id));
        $order->viewed = 1;
        $order->save();
        return view('orders.seller_orders_show', compact('order'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        if($order != null){
            foreach($order->orderDetails as $key => $orderDetail){
                $orderDetail->delete();
            }
            $order->delete();
            flash('Order has been deleted successfully')->success();
        }
        else{
            flash('Something went wrong')->error();
        }
        return back();
    }

    public function order_details(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->seller_viewed = 1;
        $order->save();
        return view('frontend.partials.order_details_seller', compact('order'));
    }

    public function update_delivery_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->delivery_viewed = '0';
        $order->save();
        if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'seller'){
            foreach($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail){
                $orderDetail->delivery_status = $request->status;
                $orderDetail->save();
            }
        }
        else{
            foreach($order->orderDetails->where('seller_id', \App\User::where('user_type', 'admin')->first()->id) as $key => $orderDetail){
                $orderDetail->delivery_status = $request->status;
                $orderDetail->save();
            }
        }

        if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_delivery_status')->first()->value){
            try {
                $otpController = new OTPVerificationController;
                $otpController->send_delivery_status($order);
            } catch (\Exception $e) {
            }
        }

        return 1;
    }

    public function update_payment_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->payment_status_viewed = '0';
        $order->save();

        if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'seller'){
            foreach($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail){
                $orderDetail->payment_status = $request->status;
                $orderDetail->save();
            }
        }
        else{
            foreach($order->orderDetails->where('seller_id', \App\User::where('user_type', 'admin')->first()->id) as $key => $orderDetail){
                $orderDetail->payment_status = $request->status;
                $orderDetail->save();
            }
        }

        $status = 'paid';
        foreach($order->orderDetails as $key => $orderDetail){
            if($orderDetail->payment_status != 'paid'){
                $status = 'unpaid';
            }
        }
        $order->payment_status = $status;
        $order->save();

        if($order->payment_status == 'paid' && $order->commission_calculated == 0){
            if ($order->payment_type == 'cash_on_delivery') {
                if (BusinessSetting::where('type', 'category_wise_commission')->first()->value != 1) {
                    $commission_percentage = BusinessSetting::where('type', 'vendor_commission')->first()->value;
                    foreach ($order->orderDetails as $key => $orderDetail) {
                        $orderDetail->payment_status = 'paid';
                        $orderDetail->save();
                        if($orderDetail->product->user->user_type == 'seller'){
                            $seller = $orderDetail->product->user->seller;
                            $seller->admin_to_pay = $seller->admin_to_pay - ($orderDetail->price*$commission_percentage)/100;
                            $seller->save();
                        }
                    }
                }
                else{
                    foreach ($order->orderDetails as $key => $orderDetail) {
                        $orderDetail->payment_status = 'paid';
                        $orderDetail->save();
                        if($orderDetail->product->user->user_type == 'seller'){
                            $commission_percentage = $orderDetail->product->category->commision_rate;
                            $seller = $orderDetail->product->user->seller;
                            $seller->admin_to_pay = $seller->admin_to_pay - ($orderDetail->price*$commission_percentage)/100;
                            $seller->save();
                        }
                    }
                }
            }
            elseif($order->manual_payment) {
                if (BusinessSetting::where('type', 'category_wise_commission')->first()->value != 1) {
                    $commission_percentage = BusinessSetting::where('type', 'vendor_commission')->first()->value;
                    foreach ($order->orderDetails as $key => $orderDetail) {
                        $orderDetail->payment_status = 'paid';
                        $orderDetail->save();
                        if($orderDetail->product->user->user_type == 'seller'){
                            $seller = $orderDetail->product->user->seller;
                            $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->price*(100-$commission_percentage))/100;
                            $seller->save();
                        }
                    }
                }
                else{
                    foreach ($order->orderDetails as $key => $orderDetail) {
                        $orderDetail->payment_status = 'paid';
                        $orderDetail->save();
                        if($orderDetail->product->user->user_type == 'seller'){
                            $commission_percentage = $orderDetail->product->category->commision_rate;
                            $seller = $orderDetail->product->user->seller;
                            $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->price*(100-$commission_percentage))/100;
                            $seller->save();
                        }
                    }
                }
            }

            if (\App\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated) {
                $affiliateController = new AffiliateController;
                $affiliateController->processAffiliatePoints($order);
            }

            if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated) {
                $clubpointController = new ClubPointController;
                $clubpointController->processClubPoints($order);
            }

            $order->commission_calculated = 1;
            $order->save();
        }

        if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_paid_status')->first()->value){
            try {
                $otpController = new OTPVerificationController;
                $otpController->send_payment_status($order);
            } catch (\Exception $e) {
            }
        }
        return 1;
    }

        /**
     * Display a listing of the resource to admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_orders_cancel(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();

        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $admin_user_id = User::where('user_type', 'admin')->first()->id;
        $orders = DB::table('orders')
                    ->orderBy('code', 'desc')
                    ->where('orders.cancel_request', '>', 0)
                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                    ->where('order_details.seller_id', $admin_user_id)
                    ->select('orders.id')
                    ->distinct();

        if ($request->payment_type != null){
            $orders = $orders->where('order_details.payment_status', $request->payment_type);
            $payment_status = $request->payment_type;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('order_details.delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')){
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%'.$sort_search.'%');
        }
        $orders = $orders->paginate(15);
        return view('orders_canceled.index', compact('orders','payment_status','delivery_status', 'sort_search', 'admin_user_id'));
    }

    public function admin_order_cancel_settings(){
        $cancelRemaining = DB::table('order_cancel_time_settings')->first();
        return view('orders_cancel_settings.index', compact('cancelRemaining'));
    }

    public function admin_settings_update(Request $request)
    {
        // return $request;

        $validated = $request->validate([
            'hours' => 'required',
            'days' => 'required',
        ]);

        DB::table('order_cancel_time_settings')
        ->where('id', $request->id)
        ->update([
            'cancel_hours' => $request->hours,
            'return_days' => $request->days,
            ]);

        flash('Successfully Updated')->success();
        return redirect()->back();

    }

    public function admin_orders_return(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();

        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $admin_user_id = User::where('user_type', 'admin')->first()->id;
        $orders = DB::table('orders')
                    ->orderBy('code', 'desc')
                    ->where('orders.cancel_request', 0)
                    ->where('orders.return_request', '>', 0)
                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                    ->where('order_details.seller_id', $admin_user_id)
                    ->select('orders.id')
                    ->distinct();

        if ($request->payment_type != null){
            $orders = $orders->where('order_details.payment_status', $request->payment_type);
            $payment_status = $request->payment_type;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('order_details.delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')){
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%'.$sort_search.'%');
        }
        $orders = $orders->paginate(15);
        return view('orders_return.index', compact('orders','payment_status','delivery_status', 'sort_search', 'admin_user_id'));
    }

    public function orders_return_app ($id)
    {
        $order = Order::find($id);
        $order->return_request = 3;
        $order->viewed = 0;
        $order->save();
        // $orderdetails = OrderDetail::where('order_id', $id)->get();
        // foreach($orderdetails as $key => $orderdetail){
        //     $orderdetail->cancel_request = 1;
        //     $orderdetail->save();
        // }
        return redirect()->back();
    }

  /*  public function order_cancel_seller( $id )
    {
        // return $id;
        $order = Order::findOrFail($id);
        $order->cancel_request = 3;
        $order->viewed = 0;
        $order->seller_viewed = 0;
        $order->customer_view = 0;
        $order->canceled_by = 'seller';
        $order->save();
        $orderdetails = OrderDetail::where('order_id', $id)->get();
        foreach($orderdetails as $key => $orderdetail){
            $orderdetail->cancel_request = 1;
            $orderdetail->save();
        }
        flash('Your order cancel successfully submitted');
        return redirect()->back();
    }*/
    
    
    public function order_cancel_seller( $id )
    {
        // return $id;
        $order = Order::findOrFail($id);
        if($order->cancel_request == 1){
            $order->canceled_by = 'customer';
        }else{
            $order->canceled_by = 'seller';
        }
        $order->cancel_request = 3;
        $order->viewed = 0;
        $order->seller_viewed = 0;
        $order->customer_view = 0;
        $order->save();
        $orderdetails = OrderDetail::where('order_id', $id)->get();
        foreach($orderdetails as $key => $orderdetail){
            $orderdetail->cancel_request = 1;
            $orderdetail->save();
        }
        flash('Your order cancel successfully submitted');
        return redirect()->back();
    }

}



