<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\OTPVerificationController;
use App\Http\Controllers\ClubPointController;
use App\Http\Controllers\AffiliateController;
use App\OtpConfiguration;
use App\BusinessSetting;
use App\OrderDetail;
use App\ProductStock;
use App\Product;
use App\Order;
use App\Color;
use App\User;
use Session;
use Auth;
use DB;
use PDF;
use Mail;
use App\Mail\InvoiceEmailManager;
use App\Http\Resources\PosProductCollection;

class PosController extends Controller
{
    public function index()
    {
        if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
            return view('pos.index');
        }
        else {
            $pos_activation = BusinessSetting::where('type', 'pos_activation_for_seller')->first();
            if ($pos_activation != null && $pos_activation->value == 1) {
                return view('pos.frontend.seller.pos.index');
            }
            else {
                flash(__('POS is disable for Sellers!!!'))->error();
                return back();
            }
        }
    }

    public function search(Request $request)
    {
        if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff'){
            $products = Product::where('added_by', 'admin')->where('published', '1');
        }
        else {
            $products = Product::where('user_id', Auth::user()->id)->where('published', '1');
        }

        if($request->category != null){
            $arr = explode('-', $request->category);
            if($arr[0] == 'category'){
                $products = $products->where('category_id', $arr[1]);
            }
            elseif($arr[0] == 'subcategory'){
                $products = $products->where('subcategory_id', $arr[1]);
            }
            elseif($arr[0] == 'subsubcategory'){
                $products = $products->where('subsubcategory_id', $arr[1]);
            }
        }

        if($request->brand != null){
            $products = $products->where('brand_id', $request->brand);
        }

        if ($request->keyword != null) {
            $products = $products->where('name', 'like', '%'.$request->keyword.'%')->orWhere('barcode', $request->keyword)->orderBy('created_at', 'desc');
        }

        $stocks = new PosProductCollection($products->paginate(16));
        $stocks->appends(['keyword' =>  $request->keyword]);
        return $stocks;
    }

    public function getVarinats(Request $request){
        $stocks = Product::find($request->id)->stocks;
        if(count($stocks) > 0){
            return view('pos.variants', compact('stocks'));
        }
        else {
            return 0;
        }
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);

        $data = array();
        $data['id'] = $product->id;
        $tax = 0;
        $data['variant'] = $request->variant;

        if($request->variant != null && $product->variant_product){
            $product_stock = $product->stocks->where('variant', $request->variant)->first();
            $price = $product_stock->price;
            $quantity = $product_stock->qty;

            if($request['quantity'] > $quantity){
                return 0;
            }
        }
        else{
            $price = $product->unit_price;
        }

        //discount calculation based on flash deal and regular discount
        //calculation of taxes
        $flash_deals = \App\FlashDeal::where('status', 1)->get();
        $inFlashDeal = false;
        foreach ($flash_deals as $flash_deal) {
            if ($flash_deal != null && $flash_deal->status == 1  && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
                $flash_deal_product = \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first();
                if($flash_deal_product->discount_type == 'percent'){
                    $price -= ($price*$flash_deal_product->discount)/100;
                }
                elseif($flash_deal_product->discount_type == 'amount'){
                    $price -= $flash_deal_product->discount;
                }
                $inFlashDeal = true;
                break;
            }
        }
        if (!$inFlashDeal) {
            if($product->discount_type == 'percent'){
                $price -= ($price*$product->discount)/100;
            }
            elseif($product->discount_type == 'amount'){
                $price -= $product->discount;
            }
        }

        if($product->tax_type == 'percent'){
            $tax = ($price*$product->tax)/100;
        }
        elseif($product->tax_type == 'amount'){
            $tax = $product->tax;
        }

        $data['quantity'] = $request->quantity;
        $data['price'] = $price;
        $data['tax'] = $tax;
        $data['shipping'] = $product->shipping_cost;

        if($request->session()->has('posCart')){
            $foundInCart = false;
            $cart = collect();

            foreach ($request->session()->get('posCart') as $key => $cartItem){
                if($cartItem['id'] == $request->product_id){
                    if($cartItem['variant'] == $request->variant){
                        $foundInCart = true;
                        $cartItem['quantity'] += $request->quantity;
                    }
                }
                $cart->push($cartItem);
            }

            if (!$foundInCart) {
                $cart->push($data);
            }
            $request->session()->put('posCart', $cart);
        }
        else{
            $cart = collect([$data]);
            $request->session()->put('posCart', $cart);
        }

        return view('pos.cart');
    }

    //updated the quantity for a cart item
    public function updateQuantity(Request $request)
    {
        $cart = $request->session()->get('posCart', collect([]));
        $cart = $cart->map(function ($object, $key) use ($request) {
            if($key == $request->key){
                $object['quantity'] = $request->quantity;
            }
            return $object;
        });
        $request->session()->put('posCart', $cart);

        return view('pos.cart');
    }

    //removes from Cart
    public function removeFromCart(Request $request)
    {
        if(Session::has('posCart')){
            $cart = Session::get('posCart', collect([]));
            $cart->forget($request->key);
            Session::put('posCart', $cart);
        }

        return view('pos.cart');
    }

    //Shipping Address
    public function getShippingAddress(Request $request){
        $user = User::find($request->id);
        return $user;
    }

    //set Discount
    public function setDiscount(Request $request){
        if($request->discount >= 0){
            Session::put('pos_discount', $request->discount);
        }
        return view('pos.cart');
    }

    //set Shipping Cost
    public function setShipping(Request $request){
        if($request->shipping != null){
            Session::put('shipping', $request->shipping);
        }
        return view('pos.cart');
    }

    //order place
    public function order_store(Request $request)
    {
        if(Session::has('posCart') && count(Session::get('posCart')) > 0){
            $order = new Order;
            if ($request->user_id == null) {
                $order->guest_id = mt_rand(100000, 999999);
            }
            else {
                $order->user_id = $request->user_id;
            }
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['address'] = $request->address;
            $data['country'] = $request->country;
            $data['city'] = $request->city;
            $data['postal_code'] = $request->postal_code;
            $data['phone'] = $request->phone;

            $shipping_info = $data;
            Session::put('pos_shipping_info', $shipping_info);
            $order->shipping_address = json_encode(Session::get('pos_shipping_info'));

            $order->payment_type = $request->payment_type;
            $order->delivery_viewed = '0';
            $order->payment_status_viewed = '0';
            $order->code = date('Ymd-His').rand(10,99);
            $order->date = strtotime('now');
            $order->payment_status = 'paid';
            $order->payment_details = $request->payment_type;

            if($order->save()){
                $subtotal = 0;
                $tax = 0;
                $shipping = 0;
                foreach (Session::get('posCart') as $key => $cartItem){
                    $product = Product::find($cartItem['id']);

                    $subtotal += $cartItem['price']*$cartItem['quantity'];
                    $tax += $cartItem['tax']*$cartItem['quantity'];

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

                    $order_detail = new OrderDetail;
                    $order_detail->order_id  =$order->id;
                    $order_detail->seller_id = $product->user_id;
                    $order_detail->product_id = $product->id;
                    $order_detail->payment_status = 'paid';
                    $order_detail->variation = $product_variation;
                    $order_detail->price = $cartItem['price'] * $cartItem['quantity'];
                    $order_detail->tax = $cartItem['tax'] * $cartItem['quantity'];
                    $order_detail->shipping_type = null;

                    if (Session::get('shipping', 0) == 0){
                        $order_detail->shipping_cost = 0;
                    }
                    else {
                        if($cartItem['shipping'] == null){
                            $order_detail->shipping_cost = 0;
                        }
                        else {
                            $order_detail->shipping_cost = $cartItem['shipping'];
                            $shipping += $cartItem['shipping'];
                        }
                    }

                    $order_detail->quantity = $cartItem['quantity'];
                    $order_detail->save();

                    $product->num_of_sale++;
                    $product->save();
                }

                $order->grand_total = $subtotal + $tax + $shipping;

                if(Session::has('pos_discount')){
                    $order->grand_total -= Session::get('pos_discount');
                    $order->coupon_discount = Session::get('pos_discount');
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

                foreach($seller_products as $key => $seller_product){
                    try {
                        Mail::to(\App\User::find($key)->email)->queue(new InvoiceEmailManager($array));
                    } catch (\Exception $e) {

                    }
                }

                if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated) {
                    $clubpointController = new ClubPointController;
                    $clubpointController->processClubPoints($order);
                }

                if (\App\BusinessSetting::where('type', 'category_wise_commission')->first()->value != 1) {
                    $commission_percentage = \App\BusinessSetting::where('type', 'vendor_commission')->first()->value;
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

                $order->commission_calculated = 1;
                $order->save();

                //sends email to customer with the invoice pdf attached
                if(env('MAIL_USERNAME') != null){
                    try {
                        Mail::to($request->session()->get('pos_shipping_info')['email'])->queue(new InvoiceEmailManager($array));
                        Mail::to(User::where('user_type', 'admin')->first()->email)->queue(new InvoiceEmailManager($array));
                    } catch (\Exception $e) {

                    }
                }
                unlink($array['file']);

                $request->session()->put('order_id', $order->id);

                Session::forget('pos_shipping_info');
                Session::forget('shipping');
                Session::forget('pos_discount');
                Session::forget('posCart');
                return 1;
            }
            else {
                return 0;
            }
        }
        return 0;
    }

    public function pos_activation()
    {
        $pos_activation = BusinessSetting::where('type', 'pos_activation_for_seller')->first();
        return view('pos.pos_activation', compact('pos_activation'));
    }
}
