<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\DB;

use App\Deposit;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\ProfitSetting;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $order_details = DB::table('order_details')->with('users')->orderBy('created_at', 'DESC')->get();

        $order_details = OrderDetail::with('user')->orderBy('created_at', 'DESC')->get();
        return view('deposit.index', compact('order_details'));
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


        $order_detail = OrderDetail::find($request->order_detail_id);
        // return Carbon::now()->diffInDays($order_detail->created_at);

        if($order_detail->commission_splitting_status == 'pending' && $order_detail->payment_status == 'paid' && $order_detail->delivery_status == 'delivered'){

            //distributor
            $refDistributorCode = $order_detail->user->referred_by;
            $Distributor = User::where( 'referral_code', $refDistributorCode)->first();
            //BDO
            $refBDOCode = $Distributor->referred_by;
            $BDO = User::where( 'referral_code', $refBDOCode)->first();
            //Suq Bahrain.
            $suqbahrain = User::where( 'email', 'info@suqbahrain.com')->where('user_type', 'admin')->first();
            $profit = $order_detail->profit;

            if($order_detail->user->is_merchant == 1 && $order_detail->user->user_type == 'customer' && Carbon::now()->diffInDays($order_detail->created_at) >= 7 ){

                $profitsetting = ProfitSetting::where('start_date', '<=', $order_detail->created_at)->where('end_date', '>=', $order_detail->created_at)->orderBy('id', 'DESC')->first();
                if($profitsetting == null){
                    $merchantpro = ($profit * 50) / 100;
                    $distributorpro = ($profit * 10) / 100;
                    $bdopro = ($profit * 2.5) / 100;
                    $suqbahrainpro = ($profit * 37.5) / 100;

                } else {
                    $merchantpro = ($profit * $profitsetting->marchant_comission) / 100;
                    $distributorpro = ($profit * $profitsetting->distributor_comission) / 100;
                    $bdopro = ($profit * $profitsetting->bdo_comission) / 100;
                    $suqbahrainpro = ($profit * $profitsetting->suqbahrain_comission) / 100;
                }
                //Marcent profit
                $deposit1 = new Deposit();
                $deposit1->user_id = $order_detail->user_id;
                $deposit1->product_id = $order_detail->product_id;
                $deposit1->order_id = $order_detail->order_id;
                $deposit1->deposit_amount = $merchantpro;
                $deposit1->save();

                //Dristributor profit
                $deposit2 = new Deposit();
                $deposit2->user_id = $Distributor->id;
                $deposit2->product_id = $order_detail->product_id;
                $deposit2->order_id = $order_detail->order_id;
                $deposit2->deposit_amount = $distributorpro;
                $deposit2->save();

                //BDO profit
                $deposit3 = new Deposit();
                $deposit3->user_id = $BDO->id;
                $deposit3->product_id = $order_detail->product_id;
                $deposit3->order_id = $order_detail->order_id;
                $deposit3->deposit_amount = $bdopro;
                $deposit3->save();

                //Suq Bahrain profit
                $deposit4 = new Deposit();
                $deposit4->user_id = $suqbahrain->id;
                $deposit4->product_id = $order_detail->product_id;
                $deposit4->order_id = $order_detail->order_id;
                $deposit4->deposit_amount = $suqbahrainpro;
                $deposit4->save();

            } else {
                //Suq Bahrain profit
                // $deposit = new Deposit();
                // $deposit->user_id = $suqbahrain->id;
                // $deposit->product_id = $order_detail->product_id;
                // $deposit->order_id = $order_detail->order_id;
                // $deposit->deposit_amount = $profit;
                // $deposit->save();
            }

            $order_detail->commission_splitting_status = 'done';
            $order_detail->update();
            return redirect()->back();
        } else {
            return 'Are You Hacker??';
            // return redirect()->back()->with('success', 'Are You Hacker??');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function show(Deposit $deposit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function edit(Deposit $deposit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deposit $deposit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deposit $deposit)
    {
        //
    }
}
