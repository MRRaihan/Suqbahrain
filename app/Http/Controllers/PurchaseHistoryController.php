<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderDetail;
use App\ProductReturn;
use DB;
use Illuminate\Support\Facades\Auth;

class PurchaseHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('code', 'desc')->paginate(9);
        return view('frontend.purchase_history', compact('orders'));
    }

    public function digital_index()
    {
        $orders = DB::table('orders')
                        ->orderBy('code', 'desc')
                        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                        ->join('products', 'order_details.product_id', '=', 'products.id')
                        ->where('orders.user_id', Auth::user()->id)
                        ->where('products.digital', '1')
                        ->where('order_details.payment_status', 'paid')
                        ->select('order_details.id')
                        ->paginate(1);
        return view('frontend.digital_purchase_history', compact('orders'));
    }

    public function purchase_history_details(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        if(Auth::user()->user_type == 'customer'){
            $order->delivery_viewed = 1;
            $order->payment_status_viewed = 1;
            $order->customer_view = 1;
        } elseif(Auth::user()->user_type == 'seller'){
            $order->seller_viewed = 1;
        }
        $order->save();
        return view('frontend.partials.order_details_customer', compact('order'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    public function purchase_return_request($id)
    {
        // return $id;
        $order = Order::where('id', $id)->first();
        return view('frontend.purchase_return_request', compact('order'));
    }

    public function purchase_return_request_store(Request $request)
    {
        // return $request;
        $validated = $request->validate([
            'reason' => 'required | max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // return ProductReturn::all();
        $product_return = new ProductReturn();
        $product_return->user_id = Auth::user()->id;
        $product_return->order_id = $request->order_id;
        $product_return->reason = $request->reason;
        if($request->hasFile('image')){
            $image = $request->file('image')->store('uploads/product_return');
            $product_return->image = $image;
        }
        if( $product_return->save() ){
            $order = Order::findOrFail($request->order_id);
            $order->return_request = 1;
            $order->save();

            flash('Your product return request has been successfully send')->success();
            return redirect()->route('purchase_history.index');
        }

        flash('Somethisg went wrong')->error();
        return redirect()->back();

    }

}
